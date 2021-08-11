<?php include("partials/menu.php") ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Admin</h1>

        <?php 
                
            if(isset($_SESSION['add'])) //Checking whether the session is set or not
            {
                echo $_SESSION['add']; //Displaying session message if set
                unset($_SESSION['add']); //Removing session message 
            }

        ?>


        <br><br>

        <form action="" method="POST">

            <table class="tbl-30">
                <tr>
                    <td>Full name: </td>
                    <td><input type="text" name="full_name" placeholder="Enter your Name"></td>
                </tr>
                <tr>
                    <td>Username: </td>
                    <td><input type="text" name="username" placeholder="Your Username"></td>
                </tr>
                <tr>
                    <td>Password: </td>
                    <td><input type="password" name="password" placeholder="Your Password"></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Admin" class="btn-secondary">
                    </td>
                </tr>
            </table>

        </form>
    </div>
</div>

<?php include("partials/footer.php") ?> 

<?php
    //Process the value from Form and save it in database

    //Check weather the submit button is clicked or not

    if(isset($_POST['submit']))
    {
        //Button clicked
        //echo "Button clicked";

        //1.Get the data from from
        $full_name=$_POST['full_name'];
        $username=$_POST['username'];
        $passwod=md5($_POST['password']); //password Encryption with md5

        //2.SQL Query to save the data into database
        $sql = "INSERT INTO tbl_admin SET
            full_name='$full_name',
            username='$username',
            password='$passwod'
        ";
        
        //3.Executing query and saving data into database
        $res = mysqli_query($conn, $sql) or die(mysqli_error());

        //4.check whether the query is executed or not and display appropiate message
        if($res==TRUE)
        {
            //Data Inserted
            //echo "Data Inserted";
            
            //create a session variable to display message
            $_SESSION['add'] = "<div class='sucess'>Admin Added Sucessfully</div";
            
            //Redirect page to Manage Admin
            header("location:".SITEURL.'admin/manage-admin.php');
        }
        else
        {
            //failed to insert data
            //echo "failed to insert data";
            
            //create a session variable to display message
            $_SESSION['add'] = "<div class='error'>Failed to Add Admin</div>";
            
            //Redirect page to Add Admin
            header("location:".SITEURL.'admin/add-admin.php');
        }
    }

?>