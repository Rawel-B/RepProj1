<?php
    $is_invalid = false;
    $invalid_email = false;
    $invalid_psw = false;
    $invalid_pswconf = false;
    $is_taken=false;
    $invalid_ex=false;

    if ($_SERVER["REQUEST_METHOD"] === "POST"){
        if ( ! filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
            //die("Valid email is required");
            $invalid_email=true;
        }

        if (strlen($_POST["password"]) < 8) {
            //die("Password must be at least 8 characters");
            $invalid_psw=true;
        }

        if ( ! preg_match("/[a-z]/i", $_POST["password"])) {
            //die("Password must contain at least one letter");
            $invalid_psw=true;
        }

        if ( ! preg_match("/[0-9]/", $_POST["password"])) {
            //die("Password must contain at least one number");
            $invalid_psw=true;
        }

        if ($_POST["password"] !== $_POST["password_confirmation"]) {
            //die("Passwords must match");
            $invalid_pswconf=true;
        }

        /* Img Section */
        if (isset($_FILES['pic']['name'])){
            $img_name = $_FILES['pic']['name'];
            $img_size = $_FILES['pic']['size'];
            $tmp_name = $_FILES['pic']['tmp_name'];
            $error = $_FILES['pic']['error'];

            if($error==0)
            {
                $img_ex = pathinfo($img_name,PATHINFO_EXTENSION);
                $img_ex_to_lc = strtolower($img_ex);

                $allowed_exs = array('jpg','jpeg','png');
                if(in_array($img_ex_to_lc,$allowed_exs)){
                    $new_img_name = uniqid($_POST["email"], true).'.'.$img_ex_to_lc;
                    $img_upload_path = '../upload/'.$new_img_name;
                    move_uploaded_file($tmp_name,$img_upload_path);
                }else{
                    $invalid_ex=true;
                }
            }
        }

        $password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);
        $score= 80;

        $mysqli = require __DIR__ . "/Server/database.php";


        //Test For Existing Email In DB
        $sql = "SELECT COUNT(*) AS count FROM users WHERE email = ?";
            
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("s", $_POST["email"]);
        $stmt->execute();

        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if ($row['count'] > 0) {
            $is_email_exists = true;
        }
        $stmt->close();

        if (!$is_email_exists) {
        // Test For Default Icon
            if (!empty($new_img_name)){
                $sql = "INSERT INTO users (email, password, score, avatar) VALUES (?, ?, ?, ?)";
                        
                $stmt = $mysqli->stmt_init();

                if ( ! $stmt->prepare($sql)) {
                    die("SQL error: " . $mysqli->error);
                }

                $stmt->bind_param("ssis",
                                $_POST["email"],
                                $password_hash,
                                $score,
                                $new_img_name);
            }else{
                $sql = "INSERT INTO users (email, password, score) VALUES (?, ?, ?)";
                        
                $stmt = $mysqli->stmt_init();

                if ( ! $stmt->prepare($sql)) {
                    die("SQL error: " . $mysqli->error);
                }

                $stmt->bind_param("ssi",
                                $_POST["email"],
                                $password_hash,
                                $score);
            }
            if ($stmt->execute()) {

                header("Location: sign-in.php");
                exit;
                
            } 
        }else{
            $is_taken=true;
        }
                        
        /*else {
            
            if ($mysqli->errno === 1062) {
                die("email already taken");
            } else {
                die($mysqli->error . " " . $mysqli->errno);
            }
        }*/
        if ($invalid_email || $invalid_ex || $invalid_psw || $invalid_pswconf || $is_taken)
        {
            $is_invalid=true;
        }
    }
?>
<!-- image loading -->
<?php
    
    session_start();

    if (isset($_SESSION['user_id'])) {
        $id = $_SESSION['user_id'];
        $mysqli = require __DIR__ . "/Server/database.php";

        if ($mysqli->connect_error) {
            die("Connection failed: " . $mysqli->connect_error);
        }

        $sql = "SELECT * FROM users WHERE id = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0)
        {
            $user_data = $result->fetch_assoc();
            $image_name = $user_data["avatar"];
            $image_src = "upload/" . $image_name;
        } else {
            echo "User not found!";
        }
        $stmt->close();
        $mysqli->close();
    }
?>
<!-- navbar profile -->
<?php

    if (isset($_SESSION['user_id'])) {
        $user_info_html = '<li>
                            <a href="#0" class="cart-button"><i class="flaticon-shopping-basket"></i></a>
                        </li>
                        <li>                    
                            <a href="profile.php"><img class="user-button" src="' . $image_src . '" name="profileicon" id="profileicon"></a>
                            <p>
                            <span style="color: white; font-weight: bold; font-size: 10px;">' . $user_data['name'] . ' ' . $user_data['surname'] . ' :  </span>
                            <span style="color: purple; font-weight: bold; font-size: 12px;">' . $user_data['score'] . '</span>
                            </p>
                        </li>';
    } else {
        $user_info_html = '<li>
                            <a href="sign-in.php" class="login-button" style="color: white; font-weight: bold; font-size: 12px;">Sign In</a>
                            <a href="sign-up.php" class="login-button" style="color: white; font-weight: bold; font-size: 12px;">Sign Up</a>
                        </li>';
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>SmartAuc App</title>

    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/all.min.css">
    <link rel="stylesheet" href="assets/css/animate.css">
    <link rel="stylesheet" href="assets/css/nice-select.css">
    <link rel="stylesheet" href="assets/css/owl.min.css">
    <link rel="stylesheet" href="assets/css/magnific-popup.css">
    <link rel="stylesheet" href="assets/css/flaticon.css">
    <link rel="stylesheet" href="assets/css/jquery-ui.min.css">
    <link rel="stylesheet" href="assets/css/main.css">

    <link rel="shortcut icon" href="assets/images/favicon.png" type="image/x-icon">
</head>

<body>
    <!--============= ScrollToTop Section Starts Here =============-->
    <div class="overlayer" id="overlayer">
        <div class="loader">
            <div class="loader-inner"></div>
        </div>
    </div>
    <a href="#0" class="scrollToTop"><i class="fas fa-angle-up"></i></a>
    <div class="overlay"></div>
    <!--============= ScrollToTop Section Ends Here =============-->


    <!--============= Header Section Starts Here =============-->
    <header>
        <div class="header-top">
            <div class="container">
                <div class="header-top-wrapper">
                    <ul class="customer-support">
                        <li>
                            <a href="#0" class="mr-3"><i class="fas fa-phone-alt"></i><span class="ml-2 d-none d-sm-inline-block">Customer Support</span></a>
                        </li>
                        <li>
                            <i class="fas fa-globe"></i>
                            <select name="language" class="select-bar">
                                <option value="en">En</option>
                                <option value="Bn">Bn</option>
                                <option value="Rs">Rs</option>
                                <option value="Us">Us</option>
                                <option value="Pk">Pk</option>
                                <option value="Arg">Arg</option>
                            </select>
                        </li>
                    </ul>
                    <ul class="cart-button-area">
                        <?php echo $user_info_html; ?> 
                        <script>
                                function redirect(event) {
                                    window.location.href = "profile.php";
                                }
                        </script>                    
                    </ul>
                </div>
            </div>
        </div>
        <div class="header-bottom">
            <div class="container">
                <div class="header-wrapper">
                    <div class="logo">
                        <a href="index.php">
                            <img src="assets/images/logo/logo.png" alt="logo">
                        </a>
                    </div>
                    <ul class="menu ml-auto">
                        <li>
                            <a href="index.php">Home</a>
                        </li>
                        <li>
                            <a href="items.php">Auctions</a>
                        </li>
                        <li>
                            <a href="#0">Support</a>
                            <ul class="submenu">
                                <li>
                                    <a href="contact.php">Contact</a>
                                </li>
                                <li>
                                    <a href="faqs.php">FAQs</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="about.php">About</a>
                        </li>
                    </ul>
                    <form class="search-form">
                        <input type="text" placeholder="Search for brand, model....">
                        <button type="submit"><i class="fas fa-search"></i></button>
                    </form>
                    <div class="search-bar d-md-none">
                        <a href="#0"><i class="fas fa-search"></i></a>
                    </div>
                    <div class="header-bar d-lg-none">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!--============= Header Section Ends Here =============-->

    <!--============= Cart Section Starts Here =============-->
    <div class="cart-sidebar-area">
        <div class="top-content">
            <a href="index.php" class="logo">
                <img src="assets/images/logo/logo2.png" alt="logo">
            </a>
            <span class="side-sidebar-close-btn"><i class="fas fa-times"></i></span>
        </div>
        <div class="bottom-content">
            <div class="cart-products">
                <h4 class="title">Shopping cart</h4>
                <div class="single-product-item">
                    <div class="thumb">
                        <a href="#0"><img src="assets/images/shop/shop01.jpg" alt="shop"></a>
                    </div>
                    <div class="content">
                        <h4 class="title"><a href="#0">Color Pencil</a></h4>
                        <div class="price"><span class="pprice">$80.00</span> <del class="dprice">$120.00</del></div>
                        <a href="#" class="remove-cart">Remove</a>
                    </div>
                </div>
                <div class="single-product-item">
                    <div class="thumb">
                        <a href="#0"><img src="assets/images/shop/shop02.jpg" alt="shop"></a>
                    </div>
                    <div class="content">
                        <h4 class="title"><a href="#0">Water Pot</a></h4>
                        <div class="price"><span class="pprice">$80.00</span> <del class="dprice">$120.00</del></div>
                        <a href="#" class="remove-cart">Remove</a>
                    </div>
                </div>
                <div class="single-product-item">
                    <div class="thumb">
                        <a href="#0"><img src="assets/images/shop/shop03.jpg" alt="shop"></a>
                    </div>
                    <div class="content">
                        <h4 class="title"><a href="#0">Art Paper</a></h4>
                        <div class="price"><span class="pprice">$80.00</span> <del class="dprice">$120.00</del></div>
                        <a href="#" class="remove-cart">Remove</a>
                    </div>
                </div>
                <div class="single-product-item">
                    <div class="thumb">
                        <a href="#0"><img src="assets/images/shop/shop04.jpg" alt="shop"></a>
                    </div>
                    <div class="content">
                        <h4 class="title"><a href="#0">Stop Watch</a></h4>
                        <div class="price"><span class="pprice">$80.00</span> <del class="dprice">$120.00</del></div>
                        <a href="#" class="remove-cart">Remove</a>
                    </div>
                </div>
                <div class="single-product-item">
                    <div class="thumb">
                        <a href="#0"><img src="assets/images/shop/shop05.jpg" alt="shop"></a>
                    </div>
                    <div class="content">
                        <h4 class="title"><a href="#0">Comics Book</a></h4>
                        <div class="price"><span class="pprice">$80.00</span> <del class="dprice">$120.00</del></div>
                        <a href="#" class="remove-cart">Remove</a>
                    </div>
                </div>
                <div class="btn-wrapper text-center">
                    <a href="#0" class="custom-button"><span>Checkout</span></a>
                </div>
            </div>
        </div>
    </div>
    <!--============= Cart Section Ends Here =============-->


    <!--============= Hero Section Starts Here =============-->
    <div class="hero-section">
        <div class="container">
            <ul class="breadcrumb">
                <li>
                    <a href="index.php">Home</a>
                </li>
                <li>
                    <a href="#0">Pages</a>
                </li>
                <li>
                    <span>Sign Up</span>
                </li>
            </ul>
        </div>
        <div class="bg_img hero-bg bottom_center" data-background="assets/images/banner/hero-bg.png"></div>
    </div>
    <!--============= Hero Section Ends Here =============-->


    <!--============= Account Section Starts Here =============-->
    <section class="account-section padding-bottom">
        <div class="container">
            <div class="account-wrapper mt--100 mt-lg--440">
                <div class="left-side">
                    <div class="section-header">
                        <h2 class="title">SIGN UP</h2>
                        <p>We're happy you're here!</p>
                    </div>
                    <ul class="login-with">
                        <li>
                            <a href="#0"><i class="fab fa-facebook"></i>Log in with Facebook</a>
                        </li>
                        <li>
                            <a href="#0"><i class="fab fa-google-plus"></i>Log in with Google</a>
                        </li>
                    </ul>
                    <div class="or">
                        <span>Or</span>
                    </div>
                    <form class="login-form" method="post" enctype="multipart/form-data" novalidate>
                        <div class="form-group mb-30">
                            <?php if ($is_invalid): ?>
                                <em style="color: red;font-size: 14px;font-weight: bold">Your Sign up Form Contains Mistakes .</em>
                            <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <label for="email"><i class="far fa-envelope"></i></label>
                            <input type="email" name="email" id="email" placeholder="Email Address">
                            <?php if ($invalid_email): ?>
                                <em style="color: red;font-size: 11px;font-weight: bold">Please Enter A Valid Email (example@user.com) !.</em>
                            <?php endif; ?>
                            <?php if ($is_taken): ?>
                                <em style="color: red;font-size: 11px;font-weight: bold">This Email Address Is Already Taken !</em>
                            <?php endif; ?>
                        </div>
                        <div class="form-group mb-30">
                            <label for="login-pass"><i class="fas fa-lock"></i></label>
                            <input type="password" name="password" id="login-pass" placeholder="Password">
                            <span class="pass-type"><i class="fas fa-eye"></i></span>
                            <?php if ($invalid_psw): ?>
                                <em style="color: red;font-size: 11px;font-weight: bold">Please Enter A Valid Password(Must Contain At Least One Letter Or Number And Be 8 Digits Long) !</em>
                            <?php endif; ?>
                        </div>
                        <div class="form-group mb-30">
                            <label for="password_confirmation"><i class="fas fa-lock"></i></label>
                            <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirm Password">
                            <?php if ($invalid_pswconf): ?>
                                <em style="color: red;font-size: 11px;font-weight: bold">Passwords Do Not Match !</em>
                            <?php endif; ?>
                        </div>
                        <div class="form-group mb-30">
                            <label for="pic" class="fab" ><i class="flaticon-pencil"></i></label>
                            <input class="d-none" type="file" name="pic" id="pic" onclick="triggerFileInput()">
                            <span name="txt" id="txt">Choose An Avatar...</span>
                            <?php if ($invalid_ex): ?>
                                <em style="color: red;font-size: 11px;font-weight: bold">These Are The Only Allowed Extensions : (.jpg | .jpeg | .png) !</em>
                            <?php endif; ?>
                        </div>
                        <div class="form-group checkgroup mb-30">
                            <input type="checkbox" name="terms" id="check"><label for="check">The SmartAuc Terms of Use apply</label>
                        </div>
                        <div class="form-group mb-0">
                            <button type="submit" class="custom-button">LOG IN</button>
                        </div>
                    </form>
                    <script>
                                /*function submitForm() {
                                    var form = document.getElementById("imgform");
                                    var formData = new FormData(form);

                                    fetch('Server/updateimage.php', {
                                        method: 'POST',
                                        body: formData
                                    })
                                    .then(response => response.text())
                                    .then(data => {
                                        console.log(data);
                                    })
                                    .catch(error => {
                                        console.error('Error:', error);
                                    });
                                }*/

                                function triggerFileInput(event) {
                                    event.stopPropagation();
                                    document.getElementById("pic").click();
                                }
                    </script>
                </div>
                <div class="right-side cl-white">
                    <div class="section-header mb-0">
                        <h3 class="title mt-0">ALREADY HAVE AN ACCOUNT?</h3>
                        <p>Log in and go to your Dashboard.</p>
                        <a href="sign-in.php" class="custom-button transparent">Login</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--============= Account Section Ends Here =============-->


    <!--============= Footer Section Starts Here =============-->
    <footer class="bg_img padding-top oh" data-background="assets/images/footer/footer-bg.jpg">
        <div class="footer-top-shape">
            <img src="assets/css/img/footer-top-shape.png" alt="css">
        </div>
        <div class="anime-wrapper">
            <div class="anime-1 plus-anime">
                <img src="assets/images/footer/p1.png" alt="footer">
            </div>
            <div class="anime-2 plus-anime">
                <img src="assets/images/footer/p2.png" alt="footer">
            </div>
            <div class="anime-3 plus-anime">
                <img src="assets/images/footer/p3.png" alt="footer">
            </div>
            <div class="anime-5 zigzag">
                <img src="assets/images/footer/c2.png" alt="footer">
            </div>
            <div class="anime-6 zigzag">
                <img src="assets/images/footer/c3.png" alt="footer">
            </div>
            <div class="anime-7 zigzag">
                <img src="assets/images/footer/c4.png" alt="footer">
            </div>
        </div>
        <div class="newslater-wrapper">
            <div class="container">
                <div class="newslater-area">
                    <div class="newslater-thumb">
                        <img src="assets/images/footer/newslater.png" alt="footer">
                    </div>
                    <div class="newslater-content">
                        <div class="section-header left-style mb-low">
                            <h5 class="cate">Subscribe to SmartAuc</h5>
                            <h3 class="title">To Get Exclusive Benefits</h3>
                        </div>
                        <form class="subscribe-form">
                            <input type="text" placeholder="Enter Your Email" name="email">
                            <button type="submit" class="custom-button">Subscribe</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-top padding-bottom padding-top">
            <div class="container">
                <div class="row mb--60">
                    <div class="col-sm-6 col-lg-3">
                        <div class="footer-widget widget-links">
                            <h5 class="title">Auction Categories</h5>
                            <ul class="links-list">
                                <li>
                                    <a href="#0">Ending Now</a>
                                </li>
                                <li>
                                    <a href="#0">Vehicles</a>
                                </li>
                                <li>
                                    <a href="#0">Watches</a>
                                </li>
                                <li>
                                    <a href="#0">Electronics</a>
                                </li>
                                <li>
                                    <a href="#0">Real Estate</a>
                                </li>
                                <li>
                                    <a href="#0">Jewelry</a>
                                </li>
                                <li>
                                    <a href="#0">Art</a>
                                </li>
                                <li>
                                    <a href="#0">Sports & Outdoor</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="footer-widget widget-links">
                            <h5 class="title">About Us</h5>
                            <ul class="links-list">
                                <li>
                                    <a href="#0">About SmartAuc</a>
                                </li>
                                <li>
                                    <a href="#0">Help</a>
                                </li>
                                <li>
                                    <a href="#0">Affiliates</a>
                                </li>
                                <li>
                                    <a href="#0">Jobs</a>
                                </li>
                                <li>
                                    <a href="#0">Press</a>
                                </li>
                                <li>
                                    <a href="#0">Our blog</a>
                                </li>
                                <li>
                                    <a href="#0">Collectors' portal</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="footer-widget widget-links">
                            <h5 class="title">We're Here to Help</h5>
                            <ul class="links-list">
                                <li>
                                    <a href="#0">Your Account</a>
                                </li>
                                <li>
                                    <a href="#0">Safe and Secure</a>
                                </li>
                                <li>
                                    <a href="#0">Shipping Information</a>
                                </li>
                                <li>
                                    <a href="#0">Contact Us</a>
                                </li>
                                <li>
                                    <a href="#0">Help & FAQ</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="footer-widget widget-follow">
                            <h5 class="title">Follow Us</h5>
                            <ul class="links-list">
                                <li>
                                    <a href="#0"><i class="fas fa-phone-alt"></i>(646) 663-4575</a>
                                </li>
                                <li>
                                    <a href="#0"><i class="fas fa-blender-phone"></i>(646) 968-0608</a>
                                </li>
                                <li>
                                    <a href="#0"><i class="fas fa-envelope-open-text"></i><span class="__cf_email__" data-cfemail="cfa7aaa3bf8faaa1a8a0bba7aaa2aae1aca0a2">[email&#160;protected]</span></a>
                                </li>
                                <li>
                                    <a href="#0"><i class="fas fa-location-arrow"></i>1201 Broadway Suite</a>
                                </li>
                            </ul>
                            <ul class="social-icons">
                                <li>
                                    <a href="#0" class="active"><i class="fab fa-facebook-f"></i></a>
                                </li>
                                <li>
                                    <a href="#0"><i class="fab fa-twitter"></i></a>
                                </li>
                                <li>
                                    <a href="#0"><i class="fab fa-instagram"></i></a>
                                </li>
                                <li>
                                    <a href="#0"><i class="fab fa-linkedin-in"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="container">
                <div class="copyright-area">
                    <div class="footer-bottom-wrapper">
                        <div class="logo">
                            <a href="index.php"><img src="assets/images/logo/footer-logo.png" alt="logo"></a>
                        </div>
                        <ul class="gateway-area">
                            <li>
                                <a href="#0"><img src="assets/images/footer/paypal.png" alt="footer"></a>
                            </li>
                            <li>
                                <a href="#0"><img src="assets/images/footer/visa.png" alt="footer"></a>
                            </li>
                            <li>
                                <a href="#0"><img src="assets/images/footer/discover.png" alt="footer"></a>
                            </li>
                            <li>
                                <a href="#0"><img src="assets/images/footer/mastercard.png" alt="footer"></a>
                            </li>
                        </ul>
                        <div class="copyright"><p>&copy; Copyright 2023 | <a href="#0">SmartAuc</a></p></div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!--============= Footer Section Ends Here =============-->



    <script data-cfasync="false" src="../../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script><script src="assets/js/jquery-3.3.1.min.js"></script>
    <script src="assets/js/modernizr-3.6.0.min.js"></script>
    <script src="assets/js/plugins.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/isotope.pkgd.min.js"></script>
    <script src="assets/js/wow.min.js"></script>
    <script src="assets/js/waypoints.js"></script>
    <script src="assets/js/nice-select.js"></script>
    <script src="assets/js/counterup.min.js"></script>
    <script src="assets/js/owl.min.js"></script>
    <script src="assets/js/magnific-popup.min.js"></script>
    <script src="assets/js/yscountdown.min.js"></script>
    <script src="assets/js/jquery-ui.min.js"></script>
    <script src="assets/js/main.js"></script>
</body>


<!-- Mirrored from pixner.net/SmartAuc/main/sign-up.php by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 25 Nov 2023 04:41:50 GMT -->
</html>