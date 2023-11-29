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
                        <?php echo $user_info_html;?>                 
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
    <div class="hero-section style-2">
        <div class="container">
            <ul class="breadcrumb">
                <li>
                    <a href="index.php">Home</a>
                </li>
                <li>
                    <a href="#0">Pages</a>
                </li>
                <li>
                    <span>Faqs</span>
                </li>
            </ul>
        </div>
        <div class="bg_img hero-bg bottom_center" data-background="assets/images/banner/hero-bg.png"></div>
    </div>
    <!--============= Hero Section Ends Here =============-->


    <!--============= Faq Section Starts Here =============-->
    <section class="faq-section padding-bottom mt--240 mt-lg--440 pos-rel">
        <div class="container">
            <div class="section-header cl-white mw-100 left-style">
                <h2 class="title">FAQ</h2>
                <p>Do not hesitate to send us an email if you can't find what you're looking for.</p>
            </div>
            <div class="row mb--50">
                <div class="col-lg-8 mb-50">
                    <div class="faq-wrapper">
                        <div class="faq-item">
                            <div class="faq-title">
                                <img src="assets/css/img/faq.png" alt="css"><span class="title">How to start bidding?</span><span class="right-icon"></span>
                            </div>
                            <div class="faq-content">
                                <p>All successful bidders can confirm their winning bid by checking the “SmartAuc”. In addition, all successful bidders will receive an email notifying them of their winning bid after the auction closes.</p>
                            </div>
                        </div>
                        <div class="faq-item">
                            <div class="faq-title">
                                <img src="assets/css/img/faq.png" alt="css"><span class="title">Security Deposit / Bidding Power </span><span class="right-icon"></span>
                            </div>
                            <div class="faq-content">
                                <p>All successful bidders can confirm their winning bid by checking the “SmartAuc”. In addition, all successful bidders will receive an email notifying them of their winning bid after the auction closes.</p>
                            </div>
                        </div>
                        <div class="faq-item">
                            <div class="faq-title">
                                <img src="assets/css/img/faq.png" alt="css"><span class="title">Delivery time to the destination port </span><span class="right-icon"></span>
                            </div>
                            <div class="faq-content">
                                <p>All successful bidders can confirm their winning bid by checking the “SmartAuc”. In addition, all successful bidders will receive an email notifying them of their winning bid after the auction closes.</p>
                            </div>
                        </div>
                        <div class="faq-item">
                            <div class="faq-title">
                                <img src="assets/css/img/faq.png" alt="css"><span class="title">How to register to bid in an auction?</span><span class="right-icon"></span>
                            </div>
                            <div class="faq-content">
                                <p>All successful bidders can confirm their winning bid by checking the “SmartAuc”. In addition, all successful bidders will receive an email notifying them of their winning bid after the auction closes.</p>
                            </div>
                        </div>
                        <div class="faq-item open active">
                            <div class="faq-title">
                                <img src="assets/css/img/faq.png" alt="css"><span class="title">How will I know if my bid was successful?</span><span class="right-icon"></span>
                            </div>
                            <div class="faq-content">
                                <p>All successful bidders can confirm their winning bid by checking the “SmartAuc”. In addition, all successful bidders will receive an email notifying them of their winning bid after the auction closes.</p>
                            </div>
                        </div>
                        <div class="faq-item">
                            <div class="faq-title">
                                <img src="assets/css/img/faq.png" alt="css"><span class="title">What happens if I bid on the wrong lot?</span><span class="right-icon"></span>
                            </div>
                            <div class="faq-content">
                                <p>All successful bidders can confirm their winning bid by checking the “SmartAuc”. In addition, all successful bidders will receive an email notifying them of their winning bid after the auction closes.</p>
                            </div>
                        </div>
                        <div class="faq-item">
                            <div class="faq-title">
                                <img src="assets/css/img/faq.png" alt="css"><span class="title">What happens if I bid on the wrong lot?</span><span class="right-icon"></span>
                            </div>
                            <div class="faq-content">
                                <p>All successful bidders can confirm their winning bid by checking the “SmartAuc”. In addition, all successful bidders will receive an email notifying them of their winning bid after the auction closes.</p>
                            </div>
                        </div>
                        <div class="faq-item">
                            <div class="faq-title">
                                <img src="assets/css/img/faq.png" alt="css"><span class="title">How to leave an absentee bid</span><span class="right-icon"></span>
                            </div>
                            <div class="faq-content">
                                <p>All successful bidders can confirm their winning bid by checking the “SmartAuc”. In addition, all successful bidders will receive an email notifying them of their winning bid after the auction closes.</p>
                            </div>
                        </div>
                        <div class="faq-item">
                            <div class="faq-title">
                                <img src="assets/css/img/faq.png" alt="css"><span class="title">How do I know if I won an item?</span><span class="right-icon"></span>
                            </div>
                            <div class="faq-content">
                                <p>All successful bidders can confirm their winning bid by checking the “SmartAuc”. In addition, all successful bidders will receive an email notifying them of their winning bid after the auction closes.</p>
                            </div>
                        </div>
                        <div class="faq-item">
                            <div class="faq-title">
                                <img src="assets/css/img/faq.png" alt="css"><span class="title">How do I know if I'm the high bidder?</span><span class="right-icon"></span>
                            </div>
                            <div class="faq-content">
                                <p>All successful bidders can confirm their winning bid by checking the “SmartAuc”. In addition, all successful bidders will receive an email notifying them of their winning bid after the auction closes.</p>
                            </div>
                        </div>
                        <div class="faq-item">
                            <div class="faq-title">
                                <img src="assets/css/img/faq.png" alt="css"><span class="title">Can I bid using my mobile device?</span><span class="right-icon"></span>
                            </div>
                            <div class="faq-content">
                                <p>All successful bidders can confirm their winning bid by checking the “SmartAuc”. In addition, all successful bidders will receive an email notifying them of their winning bid after the auction closes.</p>
                            </div>
                        </div>
                        <div class="faq-item">
                            <div class="faq-title">
                                <img src="assets/css/img/faq.png" alt="css"><span class="title">Where do I access my saved items?</span><span class="right-icon"></span>
                            </div>
                            <div class="faq-content">
                                <p>All successful bidders can confirm their winning bid by checking the “SmartAuc”. In addition, all successful bidders will receive an email notifying them of their winning bid after the auction closes.</p>
                            </div>
                        </div>
                        <div class="faq-item">
                            <div class="faq-title">
                                <img src="assets/css/img/faq.png" alt="css"><span class="title">Cancellations and returns</span><span class="right-icon"></span>
                            </div>
                            <div class="faq-content">
                                <p>All successful bidders can confirm their winning bid by checking the “SmartAuc”. In addition, all successful bidders will receive an email notifying them of their winning bid after the auction closes.</p>
                            </div>
                        </div>
                        <div class="faq-item">
                            <div class="faq-title">
                                <img src="assets/css/img/faq.png" alt="css"><span class="title">How to start bidding?</span><span class="right-icon"></span>
                            </div>
                            <div class="faq-content">
                                <p>All successful bidders can confirm their winning bid by checking the “SmartAuc”. In addition, all successful bidders will receive an email notifying them of their winning bid after the auction closes.</p>
                            </div>
                        </div>
                        <div class="faq-item">
                            <div class="faq-title">
                                <img src="assets/css/img/faq.png" alt="css"><span class="title">Security Deposit / Bidding Power </span><span class="right-icon"></span>
                            </div>
                            <div class="faq-content">
                                <p>All successful bidders can confirm their winning bid by checking the “SmartAuc”. In addition, all successful bidders will receive an email notifying them of their winning bid after the auction closes.</p>
                            </div>
                        </div>
                        <div class="faq-item">
                            <div class="faq-title">
                                <img src="assets/css/img/faq.png" alt="css"><span class="title">Delivery time to the destination port </span><span class="right-icon"></span>
                            </div>
                            <div class="faq-content">
                                <p>All successful bidders can confirm their winning bid by checking the “SmartAuc”. In addition, all successful bidders will receive an email notifying them of their winning bid after the auction closes.</p>
                            </div>
                        </div>
                        <div class="faq-item">
                            <div class="faq-title">
                                <img src="assets/css/img/faq.png" alt="css"><span class="title">How to register to bid in an auction?</span><span class="right-icon"></span>
                            </div>
                            <div class="faq-content">
                                <p>All successful bidders can confirm their winning bid by checking the “SmartAuc”. In addition, all successful bidders will receive an email notifying them of their winning bid after the auction closes.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mb-50">
                    <aside class="sticky-menu">
                        <div class="faq-menu bg_img mb-30" data-background="./assets/images/faq/faq-menu.png" style="background-image: url(_/assets/images/faq/faq-menu.php);">
                            <ul id="faq-menu">
                                <li class="nav-item">
                                    <a class="nav-link active" href="#company">For Companies</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#freelancer">For Freelancers</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#account">Your Account</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#pricing">Pricing Plans</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#tec">Technical</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#security">Security</a>
                                </li>
                            </ul>
                        </div>
                        <div class="faq-video mb-30">
                            <a href="https://www.youtube.com/watch?v=Mj3QejzYZ70" class="video-area popup">
                                <img src="assets/images/faq/video.png" alt="faq">
                                <div class="video-button-2">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                    <i class="fas fa-play"></i>
                                </div>
                            </a>
                            <h5 class="title">Watch Video Tour</h5>
                        </div>
                        <div class="popular-article pt-30 mb--20">
                            <h4 class="title mb-20">Most Popular Articles</h4>
                            <div class="popular-article-item">
                                <a href="#0" class="right-con"><i class="flaticon-right-arrow"></i></a>
                                <h5 class="title"><a href="#0">Tips for winning</a></h5>
                                <p>Found an item you love? Here are some tips for winning your next item:</p>
                            </div>
                            <div class="popular-article-item">
                                <a href="#0" class="right-con"><i class="flaticon-right-arrow"></i></a>
                                <h5 class="title"><a href="#0">How to bid at an Auction</a></h5>
                                <p>Bidding at auction can be terrifying,
                                    especially your first time.</p>
                            </div>
                            <div class="popular-article-item">
                                <a href="#0" class="right-con"><i class="flaticon-right-arrow"></i></a>
                                <h5 class="title"><a href="#0">Bid increments</a></h5>
                                <p>Each auction house sets their own
                                    bidding increments</p>
                            </div>
                        </div>
                    </aside>
                </div>
            </div>
        </div>
    </section>
    <!--============= Faq Section Ends Here =============-->


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
                                    <a href="#0"><i class="fas fa-envelope-open-text"></i><span class="__cf_email__" data-cfemail="7018151c0030151e171f0418151d155e131f1d">[email&#160;protected]</span></a>
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


<!-- Mirrored from pixner.net/SmartAuc/main/faqs.php by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 25 Nov 2023 04:41:55 GMT -->
</html>