<?php

    include('../config/constants.php');

    //check whether the id and imag_name value is set or not
    if(isset($_GET['id']) AND isset($_GET['image_name']))
    {
        //get the value and delete
        //echo "get value and delete";
        $id = $_GET['id'];
        $image_name = $_GET['image_name'];

        if($image_name!="")
        {
            //Image available
            $path = "../images/food/".$image_name;
            $remove = unlink($path);

            if($remove==FALSE)
            {
                //Show error if failed to remove image
                $_SESSION['remove'] = "<div class='error'>Failed to Remove Food Image.</div>";
                header('location:'.SITEURL.'admin/manage-food.php');
                die();
            }
        }

        //delete data from database
        $sql = "DELETE FROM tbl_food WHERE id=$id";

        $res = mysqli_query($conn, $sql);

        if($res==true)
        {
            //sucess
            $_SESSION['delete'] = "<div class='sucess'>Food Sucessfully Deleted.</div>";
            header('location:'.SITEURL.'admin/manage-food.php');
        }
        else
        {
            //Failed
            $_SESSION['delete'] = "<div class='error'>Failed to delete Food.</div>";
            header('location:'.SITEURL.'admin/manage-food.php');
        }
    }
    else
    {
        //redirect to manage food page
        $_SESSION['unauth'] = "<div class='error'>Unauthorized Access.</div>";
        header('location:'.SITEURL.'admin/manage-food.php');
    }

?>