<?php include("partials/menu.php") ?>

    <div class="main-content">
        <div class="wrapper">
            <h1>Add Food</h1>
            <br><br>

            <?php
            
            if(isset($_SESSION['upload']))
            {
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }
            
            ?>

            <!--Add category section starts Here-->

            <form action="" method="POST" enctype="multipart/form-data">

                <table class="tbl-30">
                    <tr>
                        <td>Title: </td>
                        <td><input type="text" name="title" placeholder="Food Title"></td>
                    </tr>
                    <tr>
                        <td>Description: </td>
                        <td>
                            <textarea name="description" cols="30" rows="3" placeholder="Description of the Food"></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>Select Image: </td>
                        <td><input type="file" name="image"></td>
                    </tr>
                    <tr>
                        <td>Category: </td>
                        <td>
                            <select name="category">

                            <?php
                            
                            //display categories from database
                            //sql to get active category from database
                            $sql = "SELECT * FROM tbl_category WHERE active='yes'";
                            $res = mysqli_query($conn, $sql);

                            //count rows to check if categories is avilable or not
                            $count = mysqli_num_rows($res);
                            if($count>0)
                            {
                                //category available
                                while($row=mysqli_fetch_assoc($res))
                                {
                                    //get details of category
                                    $id = $row['id'];
                                    $title = $row['title'];

                                    ?>

                                    <option value="<?php echo $id;?>"><?php echo $title;?></option>

                                    <?php
                                }
                            }
                            else
                            {
                                //No category available
                                ?>
                                
                                <option value="0">No categories Found</option>

                                <?php
                            }

                            //display in dropdown
                            
                            ?>

                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Featured: </td>
                        <td>
                            <input type="radio" name="featured" Value="yes"> Yes
                            <input type="radio" name="featured" Value="no"> No
                        </td>
                    <tr>
                        <td>Active: </td>
                        <td>
                            <input type="radio" name="active" Value="yes"> Yes
                            <input type="radio" name="active" Value="no"> No
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <input type="hidden" name="id" value="<?php echo $id; ?>">
                            <input type="submit" name="submit" value="Add Food" class="btn-secondary">
                        </td>
                    </tr>
                </table>

            </form>

            <?php
            
                            //check if the submit button is clicked or not
                            if(isset($_POST['submit']))
                            {
                                //add in database
                                //get data from form
                                $title = $_POST['title'];
                                $description = $_POST['description'];
                                $category = $_POST['category'];

                                //for radio buttons
                                if(isset($_POST['featured']))
                                {
                                    $featured = $_POST['featured'];
                                }
                                else
                                {
                                    $featured = "no";
                                }

                                if(isset($_POST['active']))
                                {
                                    $active = $_POST['active'];
                                }
                                else
                                {
                                    $active = "no";
                                }

                                //upload the image
                                //check whether the selected image is clicked or not
                                if(isset($_FILES['image']['name']))
                                {
                                    //get the details
                                    $image_name = $_FILES['image']['name'];
                                    
                                    //check and upload image if selected only
                                    if($image_name!="")
                                    {
                                        //image is selected
                                        
                                        //rename the image
                                        $ext = end(explode('.', $image_name));
                                        $image_name = "food-name-".rand(000, 999).".".$ext; //new image name
                                        
                                        //upload the image
                                        //get path
                                        $src = $_FILES['image']['tmp_name'];
                                        $dst = "../images/food/".$image_name;

                                        $upload = move_uploaded_file($src, $dst);

                                        //check if the image is uploaded or not
                                        if($upload==false)
                                        {
                                            //image failed to upload
                                            $_SESSION['upload'] = "<div class='error'>Failed to upload Image!</div>";
                                            header("location:".SITEURL.'admin/add-food.php');
                                            die();

                                        }
                                    }

                                }
                                else
                                {
                                    $image_name = "";
                                }


                                //insert to database
                                $sql2 = "INSERT INTO tbl_food SET
                                    title = '$title',
                                    description = '$description',
                                    image_name = '$image_name',
                                    category_id = '$category',
                                    featured = '$featured',
                                    active = '$active'
                                ";

                                $res2 =mysqli_query($conn, $sql2);
                                
                                //check if the data is inserted or not
                                if($res2==true)
                                {
                                    //data Inserted
                                    $_SESSION['add'] = "<div class='sucess'>Food Added Sucessfully.</div";
                                    header("location:".SITEURL.'admin/manage-food.php');
                                }
                                else
                                {
                                    //failed to insert data
                                    $_SESSION['add'] = "<div class='error'>Failed to Add Food.</div";
                                    header("location:".SITEURL.'admin/manage-food.php');
                                }

                            }
                            
            
            ?>

            <!--Add category section Ends Here-->
        </div>
    </div>

<?php include("partials/footer.php") ?>