<?php include('../config/constants.php') ?>

<html>
    <header>
        <title>Login - SubodhFoods</title>
        <link rel="stylesheet" href="../css/admin.css">
    </header>
    <body>
        
        <div class="login">

            <h1 class="text-center">Login</h1>
            <br><br>

            <?php
            
                if(isset($_SESSION['login']))
                {
                    echo $_SESSION['login'];
                    unset($_SESSION['login']);
                }
                
                if(isset($_SESSION['no-login-message']))
                {
                    echo $_SESSION['no-login-message'];
                    unset($_SESSION['no-login-message']);
                }
            
            ?>
            <br><br>

            <!-- Login Form Starts Here -->

            <form action="" method="POST" class="text-center">
                Username: <br>
                <input type="text" name="username" placeholder="Enter Username"><br>
                
                Password: <br>
                <input type="password" name="password" placeholder="Enter Password"><br><br>
                <input type="submit" name="submit" value="Login" class="btn-primary">
            </form>
            <br><br>
            <!-- Login Form Ends Here -->

            <p class="text-center">Created By - <a href="#">Dipesh Wagle</a></p>

        </div>

    </body>
</html>

<?php

    //check wether the submit button is clicked or not
    if(isset($_POST['submit']))
    {
        //process for login
        //get data from login form
        $username=$_POST['username'];
        $password=md5($_POST['password']);

        //create sql query to check whether the user with username and password exist or not
        $sql = "SELECT * FROM tbl_admin WHERE username='$username' AND password='$password'";

        //exectue the query
        $res = mysqli_query($conn, $sql);

        //count rows to check user existense
        $count=mysqli_num_rows($res);
        if($count==1)
        {
            //user available
            $_SESSION['login']="<div class='sucess'>Login Sucessful.</div>";
            //to check if user is still logged in or not
            $_SESSION['user']=$username;
            
            header("location:".SITEURL.'admin/');

        }
        else
        {
            //User not avilable
            $_SESSION['login']="<div class='error text-center'>Login Failed.</div>";
            header("location:".SITEURL.'admin/login.php');
        }

    }

?>