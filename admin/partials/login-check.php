<?php

    //Authentication
    if(!isset($_SESSION['user']))
    {
        //user is not locked in redirect to login page
        $_SESSION['no-login-message'] = "<div class='error text-center'>Please Login to Access Admin Panel.</div>";

        header('location:'.SITEURL.'admin/login.php');
    }

?>