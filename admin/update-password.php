<?php include("partials/menu.php") ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Change Password</h1>
        <br><br>
        
        <?php
        
        if(isset($_GET['id']))
        {

        $id=$_GET['id'];
        
        }
        
        ?>

        <form action="" method="POST">
            <table class="tbl-30">
                
                <tr>
                    <td>Current Password: </td>
                    <td>
                        <input type="password" name="current_password" placeholder="Current Password">
                    </td>
                </tr>
                <tr>
                    <td>New Password: </td>
                    <td>
                        <input type="password" name="new_password" placeholder="New Password">
                    </td>
                </tr>
                <tr>
                    <td>Confirm Password: </td>
                    <td>
                        <input type="password" name="confirm_password" placeholder="Confirm Password">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>"> 
                        <input type="submit" name="submit" value="Change password" class="btn-secondary">
                    </td>
                </tr>

            </table>
        </form>
    </div>
</div>

<?php

        //check if submit button is clicked or not
        if(isset($_POST['submit']))
        {
            //echo "clicked";
            //get the data from form
            $id=$_POST['id'];
            $current_password=md5($_POST['current_password']);
            $new_password=md5($_POST['new_password']);
            $confirm_password=md5($_POST['confirm_password']);


            //check whether the user with cueent id and password exist or not
            $sql="SELECT * FROM tbl_admin WHERE id=$id AND password='$current_password'";

            //Execute the query
            $res=mysqli_query($conn, $sql);

            if($res==TRUE)
            {
                //check whether the data is available or not
                $count=mysqli_num_rows($res);

                if($count==1)
                {
                    //User exist
                    //echo "User Found";

                    //check whether the new password or confirm password match or not
                    if($new_password==$confirm_password)
                    {
                        //update password
                        $sql2="UPDATE tbl_admin SET
                            password='$new_password' 
                            WHERE id='$id'
                        ";
                        //execute the query
                        $res2=mysqli_query($conn, $sql2);
                        //check wheter the query is executed or not
                        if($res2==TRUE)
                        {
                            //display sucess message
                            $_SESSION['change-pwd']="<div class='sucess'>Password changed sucessfully.</div>";
                            header("location:".SITEURL.'admin/manage-admin.php');
                        }
                        else
                        {
                            //display error message
                            $_SESSION['password-not-match']="<div class='error'>Failed to change Password.</div>";
                            header("location:".SITEURL.'admin/manage-admin.php');
                        }
                    }
                    else
                    {
                        //redirect to manage admin pade with error message
                        $_SESSION['password-not-match']="<div class='error'>Password did not match.</div>";
                        header("location:".SITEURL.'admin/manage-admin.php');
                    }


                }
                else
                {
                    //User dosesnot exist and redirect
                    $_SESSION['user-not-found']="<div class='error'>User Not Found.</div>";
                    header("location:".SITEURL.'admin/manage-admin.php');
                }
            }

            //update password if all above is true


        }

?>

<?php include("partials/footer.php") ?>