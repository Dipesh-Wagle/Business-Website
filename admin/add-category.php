<?php include("partials/menu.php") ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Category</h1>
        
        <?php 
                
            if(isset($_SESSION['add'])) //Checking whether the session is set or not
            {
                echo $_SESSION['add']; //Displaying session message if set
                unset($_SESSION['add']); //Removing session message 
            }
            if(isset($_SESSION['upload'])) //Checking whether the session is set or not
            {
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }

        ?>
        <br><br>

        <!--Add category section starts Here-->

        <form action="" method="POST" enctype="multipart/form-data">

            <table class="tbl-30">
                <tr>
                    <td>Title: </td>
                    <td><input type="text" name="title" placeholder="Category Title"></td>
                </tr>
                <tr>
                    <td>Select Image: </td>
                    <td><input type="file" name="image"></td>
                </tr>
                <tr>
                    <td>Username: </td>
                    <td><input type="text" name="username" placeholder="Your Username"></td>
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
                        <input type="submit" name="submit" value="Add Category" class="btn-secondary">
                    </td>
                </tr>
            </table>

        </form>

        <!--Add category section Ends Here-->

        <?php
        
            //check submit button
            if(isset($_POST['submit']))
            {
                //echo "button clicked";
                //Get all the values from form to update
                $title=$_POST['title'];
                //for radio input type
                if(isset($_POST['featured']))
                {
                    //Get the value from form
                    $featured=$_POST['featured'];
                }
                else
                {
                    //set the default value
                    $featured= "No";
                }
                if(isset($_POST['active']))
                {
                    $active=$_POST['active'];
                }
                else
                {
                    $active= "No";
                }

                //check whether image is selected or not
                //print_r($FILES['image']);
                //die();
                if(isset($_FILES['image']['name']))
                {
                    //upload the image
                    $image_name = $_FILES['image']['name'];

                    //upload the Image only if image is selected
                    if($image_name!="")
                    {

                        //auto rename image
                        $ext = end(explode('.', $image_name));
                        $image_name = "food_category".rand(000, 999).'.'.$ext;

                        $source_path = $_FILES['image']['tmp_name'];
                        $destination_path = "../images/category/".$image_name;

                        $uplaod= move_uploaded_file($source_path, $destination_path);
                        //check if the image is uploded or not
                        if($uplaod==FALSE)
                        {
                            //set message
                            $_SESSION['upload'] = "<div class='error'>Failed to upload Image.</div";
                            header("location:".SITEURL.'admin/add-category.php');

                            die();
                        }
                    }
                }
                else
                {
                    //Dont upload image
                    $image_name="";
                }

                //create sql query to insert category into database
                $sql="INSERT INTO tbl_category SET
                    title='$title',
                    image_name='$image_name',
                    featured='$featured',
                    active='$active'
                ";

                //execute the query
                $res=mysqli_query($conn, $sql);

                //check whether the query executed or not
                if($res==TRUE)
                {
                    //category added
                    $_SESSION['add'] = "<div class='sucess'>Category Added Sucessfully.</div>";
                    header('location:'.SITEURL.'admin/manage-category.php');
                }
                else
                {
                    //Failed to add category
                    $_SESSION['add'] = "<div class='error'>Failed to Add Category.</div>";
                    header('location:'.SITEURL.'admin/add-category.php');

                }
            }
        
        ?>


    </div>
</div>

<?php include("partials/footer.php") ?>