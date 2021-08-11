<?php include('partials-front/menu.php'); ?>

    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search">
        <div class="container">
            
            <h2 class="text-center text-white">Contact Us</h2>

            <form action="" method="POST" class="order">
                
                <fieldset>
                    <legend>Contact Form</legend>
                    <div class="order-label">Full Name</div>
                    <input type="text" name="full-name" placeholder="Your Name" class="input-responsive" required>

                    <div class="order-label">Email</div>
                    <input type="email" name="email" placeholder="Your Mail" class="input-responsive" required>

                    <div class="order-label">Message</div>
                    <textarea name="message" rows="10" placeholder="Contact Us" class="input-responsive" required></textarea>
                    <br>

                    <input type="submit" name="submit" value="Confirm Submit" class="btn btn-primary">
                </fieldset>

            </form>

            <?php
            
                //check whether submit button is licked or not
                if(isset($_POST['submit']))
                {
                    //GET ALL DETAILS from the form
                    $contact_date = date("Y-m-d h:i:sa");
                    $status = "contacted";
                    $full_name = $_POST['full-name'];
                    $email = $_POST['email'];
                    $message = $_POST['message'];

                    //save data in db
                    $sql = "INSERT INTO tbl_contact SET
                        contact_date = '$contact_date',
                        status = '$status',
                        full_name = '$full_name',
                        email = '$email',
                        message = '$message'
                    ";

                    //echo $sql; die();

                    $res = mysqli_query($conn, $sql);

                    //check if query executed or not
                    if($res==true)
                    {
                        //query executed
                        $_SESSION['contact'] = "<div class='sucess text-center'>We will get back to you soon.</div>";
                        header('location:'.SITEURL);
                    }
                    else
                    {
                        //failed to save data
                        $_SESSION['contact'] = "<div class='error text-center'>There Was trouble Sending the Message.</div>";
                        header('location:'.SITEURL);
                    }

                }

            
            ?>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->

    <?php include('partials-front/footer.php'); ?>