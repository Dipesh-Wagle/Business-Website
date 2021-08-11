<?php include("partials/menu.php") ?>

<!-- Main content section Starts -->
<div class="main-content">
            <div class="wrapper">
                <h1>Manage Foods</h1>

                <br />

                <?php
            
                    if(isset($_SESSION['add']))
                    {
                        echo $_SESSION['add'];
                        unset($_SESSION['add']);
                    }
                    if(isset($_SESSION['delete']))
                    {
                        echo $_SESSION['delete'];
                        unset($_SESSION['delete']);
                    }
                    if(isset($_SESSION['remove']))
                    {
                        echo $_SESSION['remove'];
                        unset($_SESSION['remove']);
                    }
                    if(isset($_SESSION['unauth']))
                    {
                        echo $_SESSION['unauth'];
                        unset($_SESSION['unauth']);
                    }
                    if(isset($_SESSION['no-food-found']))
                    {
                        echo $_SESSION['no-food-found'];
                        unset($_SESSION['no-food-found']);
                    }
                    if(isset($_SESSION['failed-to-remove']))
                    {
                        echo $_SESSION['failed-to-remove'];
                        unset($_SESSION['failed-to-remove']);
                    }
                    if(isset($_SESSION['update']))
                    {
                        echo $_SESSION['update'];
                        unset($_SESSION['update']);
                    }
            
                ?>

                <br /><br />
                
                <!--  Button to Add Food -->
                <a href="<?php echo SITEURL;?>admin/add-food.php" class="btn-primary">Add Food</a>

                <br /><br />

                <table class="tbl-full">
                    <tr>
                        <th>S.N.</th>
                        <th>Title</th>
                        <th>Image</th>
                        <th>Featured</th>
                        <th>Active</th>
                        <th>Actions</th>
                    </tr>

                    <?php
                    
                        //sql query to get all food
                        $sql = "SELECT * FROM tbl_food";
                        $res = mysqli_query($conn, $sql);

                        //count rows to check the avilability of food
                        $count = mysqli_num_rows($res);

                        //create serial number varible and set defult value
                        $sn=1;

                        if($count>0)
                        {
                            //Food available
                            //get from database
                            while($row=mysqli_fetch_assoc($res))
                            {
                                $id = $row['id'];
                                $title = $row['title'];
                                $image_name = $row['image_name'];
                                $featured = $row['featured'];
                                $active = $row['active'];

                                ?>
                                
                                <tr>
                                    <td><?php echo $sn++; ?></td>
                                    <td><?php echo $title; ?></td>
                                    <td>
                                        <?php 

                                            //check if image is avilable or not
                                            if($image_name=="")
                                            {
                                                //No image - error
                                                echo "<div class='error'>Image not Added!</div>";
                                            }
                                            else
                                            {
                                                //Display Image
                                                ?>
                                                
                                                <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" width="100px">

                                                <?php
                                            } 

                                        ?>
                                    </td>
                                    <td><?php echo $featured; ?></td>
                                    <td><?php echo $active; ?></td>
                                    <td>
                                        <a href="<?php echo SITEURL;?>admin/update-food.php?id=<?php echo $id;?>" class="btn-secondary">Update Food</a>
                                        <a href="<?php echo SITEURL;?>admin/delete-food.php?id=<?php echo $id;?>&image_name=<?php echo $image_name;?>" class="btn-danger">Delete Food</a>
                                    </td>
                                 </tr>
                                
                                <?php

                            }
                        }
                        else
                        {
                            //No food Avilable
                            echo "<tr><td colspan='7' class='error'>Food not added yet!</td></tr>";
                        }
                    
                    ?>

                    
                </table>

                <div class="clearfix"></div>

            </div>
        </div>
        <!-- Main content section Ends -->

<?php include("partials/footer.php") ?>