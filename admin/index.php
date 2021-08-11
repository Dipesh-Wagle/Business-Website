<?php include("partials/menu.php") ?>

        <!-- Main content section Starts -->
        <div class="main-content">
            <div class="wrapper">
                <h1>DASHBOARD</h1>
                <br>
                <?php
            
                    if(isset($_SESSION['login']))
                    {
                        echo $_SESSION['login'];
                        unset($_SESSION['login']);
                    }
            
                ?>
                <br>
                <div class="col-4 text-center">
                    
                    <?php
                    
                        //sql query to get data
                        $sql = "SELECT * FROM tbl_category";
                        $res = mysqli_query($conn, $sql);
                        //count rows
                        $count = mysqli_num_rows($res);

                    
                    ?>

                    <h1><?php echo $count; ?></h1>
                    <br />
                    Categories
                </div>
                <div class="col-4 text-center">

                    <?php
                        
                        //sql query to get data
                        $sql2 = "SELECT * FROM tbl_food";
                        $res2 = mysqli_query($conn, $sql2);
                        //count rows
                        $count2 = mysqli_num_rows($res2);

                    
                    ?>

                    <h1><?php echo $count2; ?></h1>
                    <br />
                    Foods
                </div>
                <div class="col-4 text-center">

                    <?php
                        
                        //sql query to get data
                        $sql3 = "SELECT * FROM tbl_contact";
                        $res3 = mysqli_query($conn, $sql3);
                        //count rows
                        $count3 = mysqli_num_rows($res3);

                    
                    ?>

                    <h1><?php echo $count3; ?></h1>
                    <br />
                    Contacts
                </div>

                <div class="clearfix"></div>

            </div>
        </div>
        <!-- Main content section Ends -->

<?php include("partials/footer.php") ?>        