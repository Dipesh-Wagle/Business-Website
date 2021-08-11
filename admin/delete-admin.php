<?php

    include('../config/constants.php');

    //1. Get ID of admin to be deleted
    $id = $_GET['id'];

    //2. create sql query to delete admin
    $sql = "DELETE FROM tbl_admin WHERE id=$id";

    //Execute the query
    $res = mysqli_query($conn, $sql);

    //check whether the query executed sucessfully or not
    if($res==True)
    {
        //Query extecuted sucessfully
        //echo "Admin Deleted";

        //create session variable to display message
        $_SESSION['delete'] = "<div class='sucess'>Admin Deleted Sucessfully.</div>";
        //Redirect to manage admin page
        header('location:'.SITEURL.'admin/manage-admin.php');
    }
    else
    {
        //Failed to execute query
        //echo "Failed to delete admin";

        //create session variable to display message
        $_SESSION['delete'] = "<div class='error'>Failed to Delete Admin.</div>";
        //Redirect to manage admin page
        header('location:'.SITEURL.'admin/manage-admin.php');
    }

    //3. redirect to manage admin page with message (sucess/error)

?>