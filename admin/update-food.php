<?php include('partials/menu.php') ?>

    <div class="main-content">
        <div class="wrapper">
            <h1>Update Food</h1>

            <br><br>
            
            <?php
            
                //check whether the id is set or not
                if(isset($_GET['id']))
                {
                    //get the details
                    $id=$_GET['id'];
                    $sql2 = "SELECT * FROM tbl_food WHERE id=$id";
                    $res2 = mysqli_query($conn, $sql2);

                    //COunt the rows to check whether the ID is valid or not
                    $count=mysqli_num_rows($res2);
                    if($count==1)
                    {
                        //Get data
                        $row2 = mysqli_fetch_assoc($res2);
                        $title = $row2['title'];
                        $description = $row2['description'];
                        $current_image = $row2['image_name'];
                        $current_category = $row2['category_id'];
                        $featured = $row2['featured'];
                        $active = $row2['active'];
                    }
                    else
                    {
                        //redirect
                        $_SESSION['no-food-found'] = "<div class='error'>Food Not Found!</div>";
                        header('location:'.SITEURL.'admin/manage-food.php');
                    }
                }
                else
                {
                    //redirect
                    header('location:'.SITEURL.'admin/manage-food.php');
                }
            
            ?>

            <form action="" method="POST" enctype="multipart/form-data">
                <table class="tbl-30">
                <tr>
                        <td>Title: </td>
                        <td><input type="text" name="title" value="<?php echo $title; ?>"></td>
                    </tr>
                    <tr>
                        <td>Current Image: </td>
                        <td>
                            <?php

                                if($current_image!="")
                                {
                                    //Display image
                                    ?>
                                    
                                    <img src="<?php echo SITEURL;?>images/food/<?php echo $current_image;?>" width="150px">

                                    <?php
                                }
                                else
                                {
                                    //display message
                                    echo "<div class='error'>Image Not Added.</div>";
                                }

                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>New Image: </td>
                        <td><input type="file" name="image"></td>
                    </tr>
                    <tr>
                        <td>Description: </td>
                        <td>
                            <textarea name="description" cols="30" rows="3"><?php echo $description; ?></textarea>
                        </td>
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
                                    $category_id = $row['id'];
                                    $category_title = $row['title'];

                                    ?>

                                    <option <?php if($current_category==$category_id){ echo "selected"; };?> value="<?php echo $category_id;?>"><?php echo $category_title;?></option>

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
                    <tr>
                        <td>Featured: </td>
                        <td>
                            <input <?php if($featured=="yes"){ echo "checked"; } ?> type="radio" name="featured" Value="yes"> Yes

                            <input <?php if($featured=="no"){ echo "checked"; } ?> type="radio" name="featured" Value="no"> No
                        </td>
                    <tr>
                        <td>Active: </td>
                        <td>
                            <input <?php if($active=="yes"){ echo "checked"; } ?> type="radio" name="active" Value="yes"> Yes

                            <input <?php if($active=="no"){ echo "checked"; } ?> type="radio" name="active" Value="no"> No
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                            <input type="hidden" name="id" value="<?php echo $id; ?>">
                            <input type="submit" name="submit" value="Update Food" class="btn-secondary">
                        </td>
                    </tr>
                </table>
            </form>

            <?php
            
                if(isset($_POST['submit']))
                {
                    //get all values from form
                    $id = $_POST['id'];
                    $title = $_POST['title'];
                    $current_image = $_POST['current_image'];
                    $description = $_POST['description'];
                    $category = $_POST['category'];
                    $featured = $_POST['featured'];
                    $active = $_POST['active'];
                    

                    //Updating new image
                    //check if the image is selected or not
                    if(isset($_FILES['image']['name']))
                    {
                        //get image details
                        $image_name = $_FILES['image']['name'];

                        if($image_name!="")
                        {
                            //image avilable
                            //upload new image
                            
                            //auto rename image
                            $ext = end(explode('.', $image_name));
                            $image_name = "food-name-".rand(000, 999).'.'.$ext;

                            $source_path = $_FILES['image']['tmp_name'];
                            $destination_path = "../images/food/".$image_name;

                            $uplaod= move_uploaded_file($source_path, $destination_path);
                            //check if the image is uploded or not
                            if($uplaod==FALSE)
                            {
                                //set message
                                $_SESSION['upload'] = "<div class='error'>Failed to upload Image.</div";
                                header("location:".SITEURL.'admin/manage-food.php');

                                die();
                            }

                            //remove current image if available
                            if($current_image!="")
                            {

                                $remove_path = "../images/food/".$current_image;

                                $remove = unlink($remove_path);

                                //check if the image is removed or not
                                if($remove==false)
                                {
                                    //Failed to remove image
                                    $_SESSION['failed-to-remove'] = "<div class='error'>Failed to remove Image.</div>";
                                    header("location:".SITEURL.'admin/manage-food.php');
                                    die();
                                }
                            }


                        }
                        else
                        {
                            //image name will be current image name
                            $image_name = $current_image;
                        }
                    }
                    else
                    {
                        //image name will be current image name
                        $image_name = $current_image;
                    }

                    //update database
                    $sql2 = "UPDATE tbl_food SET
                        title = '$title',
                        description = '$description',
                        image_name = '$image_name',
                        category_id = '$category',
                        featured = '$featured',
                        active = '$active'
                        WHERE id=$id
                    ";
                    //execute the query
                    $res2 = mysqli_query($conn, $sql2);

                    //check if quer executed or not
                    if($res2==true)
                    {
                        //Category updated
                        $_SESSION['update'] = "<div class='sucess'>Food Updated Sucessfully.</div>";
                        header('location:'.SITEURL.'admin/manage-food.php');

                    }
                    else
                    {
                        //Failed to Update
                        $_SESSION['update'] = "<div class='error'>Failed to Update Food.</div>";
                        header('location:'.SITEURL.'admin/manage-food.php');

                    }

                }
            
            ?>

        </div>
    </div>

<?php include("partials/footer.php") ?>