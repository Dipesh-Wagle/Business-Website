<?php include("partials/menu.php") ?>

    <div class="main-content">
        <div class="wrapper">
            <h1>Manage Admin</h1>
            <br /><br />

            <?php

                if(isset($_SESSION['update']))
                {
                    echo $_SESSION['update'];
                    unset($_SESSION['update']);
                }
    
            ?>
            <br><br>

            <table class="tbl-full">
                <tr>
                    <th>S.N.</th>
                    <th>FullName</th>
                    <th>E-mail</th>
                    <th>Message</th>
                    <th>Contact Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>

                <?php
                    
                    //Query to get all contacts data
                    $sql = "SELECT * FROM tbl_contact ORDER BY id DESC";
                    //Execute the Query
                    $res = mysqli_query($conn, $sql);

                    //count rows to check whether we have data in database or not
                    $count = mysqli_num_rows($res); //Function to get all the rows in database

                    //Create a variable and assign the value 1
                    $sn=1;

                    //Check the number of rows
                    if($count>0)
                    {
                        //We have data in database
                        while($rows=mysqli_fetch_assoc($res))
                        {
                            //using while loop to get all the data from database

                            //get individual data
                            $id=$rows['id'];
                            $full_name=$rows['full_name'];
                            $email=$rows['email'];
                            $message=$rows['message'];
                            $contact_date=$rows['contact_date'];
                            $status=$rows['status'];

                            //Display the values in our table
                            ?>

                                <tr>
                                    <td><?php echo $sn++; ?></td>
                                    <td><?php echo $full_name; ?></td>
                                    <td><?php echo $email; ?></td>
                                    <td><?php echo $message; ?></td>
                                    <td><?php echo $contact_date; ?></td>
                                    <td>
                                        <?php 
                                        
                                        if($status=="recived")
                                        {
                                            echo "<label style='color: yellow'>$status</label>";
                                        } 
                                        elseif($status=="processing")
                                        {
                                            echo "<label style='color: red'>$status</label>";
                                        }
                                        elseif($status=="contacted")
                                        {
                                            echo "<label style='color: green'>$status</label>";
                                        }
                                        
                                        ?>
                                    </td>

                                    <td>
                                        <a href="<?php echo SITEURL; ?>admin/update-contact.php?id=<?php echo $id; ?>" class="btn-danger">update contact</a>
                                    </td>
                                </tr>

                            <?php

                        }
                    }
                    else
                    {
                        //We do not have data in database
                        echo "no data";
                    }
                    
                    ?>

            </table>

        </div>
    </div>


<?php include("partials/footer.php") ?>