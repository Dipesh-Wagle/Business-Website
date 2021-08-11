<?php

    include('../config/constants.php');

    //destory session and redirect to login page
    session_destroy();

    header('location:'.SITEURL.'admin/login.php');

?>