<?php include('partials-front/menu.php'); ?>

    <?php
    
        //check if the id is passed or not
        if(isset($_GET['category_id']))
        {
            //category id is get
            $category_id = $_GET['category_id'];
            //get category title based on category_id
            $sql = "SELECT title FROM tbl_category WHERE id=$category_id";
            $res = mysqli_query($conn, $sql);
            //get the value from database
            $row = mysqli_fetch_assoc($res);
            //get the title
            $cat_title = $row['title'];
        }
        else
        {
            //category not passed
            header('location:'.SITEURL);
        }
    
    ?>

    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search text-center">
        <div class="container">
            
            <h2>Foods on <a href="#" class="text-white">"<?php echo $cat_title; ?>"</a></h2>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->



    <!-- fOOD MEnu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Our Products</h2>

            <?php
            
                //sql query to get food based on category
                $sql2 = "SELECT * FROM tbl_food WHERE category_id=$category_id";
                $res2 = mysqli_query($conn, $sql2);
                //count the rows
                $count2 = mysqli_num_rows($res2);
                //check if food is available or not
                if($count2>0)
                {
                    //food available
                    while($row2=mysqli_fetch_assoc($res2))
                    {
                        //get values
                        $id = $row2['id'];
                        $title = $row2['title'];
                        $description = $row2['description'];
                        $image_name = $row2['image_name'];
                        
                        ?>
                        
                            <div class="food-menu-box">
                                <div class="food-menu-img">
                                <?php
                                
                                    if($image_name=="")
                                    {
                                        //image not available
                                        echo "<div class='error'>Image not available</div>";
                                    }
                                    else
                                    {
                                        //image available
                                        ?>
                                        
                                            <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" class="img-responsive img-curve">
                                        
                                        <?php
                                    }
                                
                                ?>
                                    
                                </div>

                                <div class="food-menu-desc">
                                    <h4><?php echo $title; ?></h4>                                   
                                    <p class="food-detail">
                                        <?php echo $description; ?>
                                    </p>
                                    <br>

                                    <a href="#" class="btn btn-primary">Order Now</a>
                                </div>
                            </div>
                        
                        <?php
                    }
                }
                else
                {
                    //food not available
                    echo "<div class='error'>Food not Available.</div>";
                }
            
            ?>

            <div class="clearfix"></div>
            
        </div>

    </section>
    <!-- fOOD Menu Section Ends Here -->

    <?php include('partials-front/footer.php'); ?>