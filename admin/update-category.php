<?php include('partials/menu.php') ?>

    <div class="main-content">
        <div class="wrapper">
            <h1>Update Category</h1>

            <br><br>
            
            <?php
            
                //check whether the id is set or not
                if(isset($_GET['id']))
                {
                    //get the details
                    $id=$_GET['id'];
                    $sql = "SELECT * FROM tbl_category WHERE id=$id";
                    $res = mysqli_query($conn, $sql);

                    //COunt the rows to check whether the ID is valid or not
                    $count=mysqli_num_rows($res);
                    if($count==1)
                    {
                        //Get data
                        $row = mysqli_fetch_assoc($res);
                        $title = $row['title'];
                        $current_image = $row['image_name'];
                        $featured = $row['featured'];
                        $active = $row['active'];
                    }
                    else
                    {
                        //redirect
                        $_SESSION['no-category-found'] = "<div class='error'>Category Not Found!</div>";
                        header('location:'.SITEURL.'admin/manage-category.php');
                    }
                }
                else
                {
                    //redirect
                    header('location:'.SITEURL.'admin/manage-category.php');
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
                                    
                                    <img src="<?php echo SITEURL;?>images/category/<?php echo $current_image;?>" width="150px">

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
                            <input type="submit" name="submit" value="Update Category" class="btn-secondary">
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
                            $image_name = "food_category".rand(000, 999).'.'.$ext;

                            $source_path = $_FILES['image']['tmp_name'];
                            $destination_path = "../images/category/".$image_name;

                            $uplaod= move_uploaded_file($source_path, $destination_path);
                            //check if the image is uploded or not
                            if($uplaod==FALSE)
                            {
                                //set message
                                $_SESSION['upload'] = "<div class='error'>Failed to upload Image.</div";
                                header("location:".SITEURL.'admin/manage-category.php');

                                die();
                            }

                            //remove current image if available
                            if($current_image!="")
                            {

                                $remove_path = "../images/category/".$current_image;

                                $remove = unlink($remove_path);

                                //check if the image is removed or not
                                if($remove==false)
                                {
                                    //Failed to remove image
                                    $_SESSION['failed-remove'] = "<div class='error'>Failed to remove Image.</div>";
                                    header("location:".SITEURL.'admin/manage-category.php');
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
                    $sql2 = "UPDATE tbl_category SET
                        title = '$title',
                        image_name = '$image_name',
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
                        $_SESSION['update'] = "<div class='sucess'>Category Updated Sucessfully.</div>";
                        header('location:'.SITEURL.'admin/manage-category.php');

                    }
                    else
                    {
                        //Failed to Update Category
                        $_SESSION['update'] = "<div class='error'>Failed to Update Category.</div>";
                        header('location:'.SITEURL.'admin/manage-category.php');

                    }

                }
            
            ?>

        </div>
    </div>

<?php include("partials/footer.php") ?>