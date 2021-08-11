<?php include("partials/menu.php") ?>

    <div class="main-content">
        <div class="wrapper">
            <h1>Update Conatct</h1>
            <br><br>

            <?php
            
                //check if id is set or not
                if(isset($_GET['id']))
                {
                    //get details
                    $id=$_GET['id'];
                    //query to get details
                    $sql = "SELECT * FROM tbl_contact WHERE id=$id";
                    $res = mysqli_query($conn, $sql);
                    $count = mysqli_num_rows($res);
                    if($count==1)
                    {
                        //detail avilable
                        $row=mysqli_fetch_assoc($res);
                        $name = $row['full_name'];
                        $status = $row['status'];
    
                    }
                    else
                    {
                        //detail not available
                        header('location:'.SITEURL.'admin/manage-contact.php');
                    }
                }
                else
                {
                    //redirect
                    header('location:'.SITEURL.'admin/manage-contact.php');
                }
            
            ?>

            <form action="" method="POST">

                <table class = "tbl-30">

                    <tr>
                        <td>Name: </td>
                        <td><b><?php echo $name; ?></b></td>
                    </tr>
                    <tr>
                        <td>status: </td>
                        <td>
                            <select name="status">
                                <option <?php if($status=="recived") { echo "selected"; } ?> value="recived">Recived</option>
                                <option <?php if($status=="processing") { echo "selected"; } ?>value="processing">On Hold</option>
                                <option <?php if($status=="contacted") { echo "selected"; } ?>value="contacted">Contacted</option>

                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="hidden" name="id" value="<?php echo $id; ?>">
                            <input type="submit" name="submit" value="update-contact" class="btn-secondary">
                        </td>
                    </tr>

                </table>

            </form>

            <?php
            
            //check if update button is clicked
            if(isset($_POST['submit']))
            {
                //echo "clicked";
                //get values from form

                $id = $_POST['id'];
                $name = $_POST['full_name'];
                $status = $_POST['status'];

                $sql2 = "UPDATE tbl_contact SET
                    status = '$status'
                    WHERE id=$id
                ";

                $res2 = mysqli_query($conn, $sql2);

                if($res2==true)
                {
                    //updated
                    $_SESSION['update'] = "<div class='sucess'>Contact Updated</div>";
                    header('location:'.SITEURL.'admin/manage-contact.php');
                }
                else
                {
                    //failed to update
                    $_SESSION['update'] = "<div class='error'>Failed to update Contact</div>";
                    header('location:'.SITEURL.'admin/manage-contact.php');
                }

            }
            
            ?>

        </div>
    </div>

<?php include("partials/footer.php") ?>