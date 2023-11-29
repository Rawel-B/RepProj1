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
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
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
                    <a href="#0">My Account</a>
                </li>
                <li>
                    <span>Personal profile</span>
                </li>
            </ul>
        </div>
        <div class="bg_img hero-bg bottom_center" data-background="assets/images/banner/hero-bg.png"></div>
    </div>
    <!--============= Hero Section Ends Here =============-->


    <!--============= Dashboard Section Starts Here =============-->
    <section class="dashboard-section padding-bottom mt--240 mt-lg--440 pos-rel">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-sm-10 col-md-7 col-lg-4">
                    <div class="dashboard-widget mb-30 mb-lg-0 sticky-menu">
                        <div class="user">
                            <div class="thumb-area">
                            <form class="dash-pro-body" action="Server/updateimage.php" name="imgform" id="imgform" method="post">
                                <div class="thumb">
                                    <img src="<?php echo $image_src; ?>" alt="user">
                                </div>
                                <label for="pic" class="profile-pic-edit" onclick="triggerFileInput()"><i class="flaticon-pencil"></i></label>
                                <input class="d-none" type="file" name="pic" id="pic" onchange="submitForm()">
                            </form>
                            <script>
                                function submitForm() {
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
                                }

                                function triggerFileInput(event) {
                                    event.stopPropagation();
                                    document.getElementById("pic").click();
                                }
                            </script>
                            </div>
                            <div class="content">
                                <h5 class="title"><a href="#0"><?php echo $user_data['name'].' '.$user_data['surname']; ?></a></h5>
                                <span class="header">
                                    <!--<label for="score">Score :</label>-->
                                    <input type="text" name="score" id="score" value="<?php echo 'Score : '.$user_data['score']; ?>" maxlength="2" disabled />
                                </span>
                            </div>
                        </div>
                        <ul class="dashboard-menu">
                            <li>
                                <a href="dashboard.php"><i class="flaticon-dashboard"></i>Dashboard</a>
                            </li>
                            <li>
                                <a href="#0" class="active"><i class="flaticon-settings"></i>Personal Profile </a>
                            </li>
                            <li>
                                <a href="my-bid.php"><i class="flaticon-auction"></i>My Bids</a>
                            </li>
                            <li>
                                <a href="winning-bids.php"><i class="flaticon-best-seller"></i>Winning Bids</a>
                            </li>
                            <li>
                                <a href="notifications.php"><i class="flaticon-alarm"></i>My Alerts</a>
                            </li>
                            <li>
                                <a href="my-favorites.php"><i class="flaticon-star"></i>My Favorites</a>
                            </li>
                            <li>
                                <a href="referral.php"><i class="flaticon-shake-hand"></i>Referrals</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="row">
                        <div class="col-12"><!--Must Fill Information Fields To Be Able To Participate In Auctions -->
                            <div class="dash-pro-item mb-30 dashboard-widget">
                                <div class="header">
                                    <h4 class="title">Personal Details</h4>
                                    <span class="edit edit1"><i class="flaticon-edit"></i> Edit</span>
                                </div>
                                <form class="dash-pro-body" action="Server/updatedetails.php" method="post">
                                    <li>
                                        <div class="info-name">Name</div>
                                        <div class="info-value">
                                            <input type="text" class="view-mode1" value="<?php echo $user_data['name']; ?>" disabled>
                                            <div><input class="edit-mode1" type="text" name="name" id="name" style="display: none;" value="<?php echo $user_data['name']; ?>" required></div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="info-name">Surname</div>
                                        <div class="info-value">
                                            <input type="text" class="view-mode1" value="<?php echo $user_data['surname']; ?>" disabled>
                                            <div><input input class="edit-mode1" type="text" name="surname" id="surname" style="display: none;" value="<?php echo $user_data['surname']; ?>" required></div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="info-name">National ID</div>
                                        <div class="info-value">
                                            <input type="text" class="view-mode1" value="<?php echo $user_data['cin']; ?>" disabled>
                                            <div><input class="edit-mode1" type="text" name="cin" id="cin" style="display: none;" required></div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="info-name">Account Status</div>
                                        <div class="info-value">
                                            <input type="text" class="view-mode1" value="<?php echo $user_data['status']; ?>" disabled>
                                            <div>
                                                <select class="edit-mode1" type="text" name="accountstatus" id="accountstatus" style="display: none;" value="<?php echo $user_data['status']; ?>" required>
                                                    <?php
                                                        if($user_data["status"]=="viewer")
                                                        
                                                            echo "<option value='viewer' selected='selected'>viewer</option>
                                                            <option value='creator'>creator</option>";
                                                        else
                                                            echo "<option value='viewer'>viewer</option>
                                                            <option value='creator' selected='selected'>creator</option>";
                                                        
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <button class="custom-button" type="submit" name="save1" id="save1" disabled>Save Changes</button>
                                    </li>
                                </form>
                                <script>
                                    $(document).ready(function () {
                                        $('.edit1').on('click', function () {
                                            $('.view-mode1').toggle();
                                            $('.edit-mode1').toggle();
                                            $('#name').focus();
                                            $('#surname').focus();
                                            $('#cin').focus();
                                            $('#accountstatus').focus();
                                            $('#save1').prop('disabled', false);
                                        });
                                    });
                                </script>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="dash-pro-item mb-30 dashboard-widget">
                                <div class="header">
                                    <h4 class="title">Email Address</h4>
                                    <span class="edit edit2"><i class="flaticon-edit"></i> Edit</span>
                                </div>
                                <form class="dash-pro-body" action="Server/updateemail.php" method="post">
                                    <li>
                                        <div class="info-name">Email</div>
                                        <div class="info-value">
                                            <input type="text" class="view-mode2" value="<?php echo $user_data['email']; ?>" disabled>
                                            <div><input class="edit-mode2" type="email" name="email" id="email" style="display: none;"  value="<?php echo $user_data['email']; ?>" required></div>
                                        </div>
                                    </li>
                                    <li>
                                        <button class="custom-button" type="submit" name="save2" id="save2" disabled>Save Changes</button>
                                    </li>
                                </form>
                                <script>
                                    $(document).ready(function () {
                                        $('.edit2').on('click', function () {
                                            $('.view-mode2').toggle();
                                            $('.edit-mode2').toggle();
                                            $('#email').focus();
                                            $('#save2').prop('disabled', false);
                                        });
                                    });
                                </script>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="dash-pro-item mb-30 dashboard-widget">
                                <div class="header">
                                    <h4 class="title">Phone</h4>
                                    <span class="edit edit3"><i class="flaticon-edit"></i> Edit</span>
                                </div>
                                <form class="dash-pro-body" action="Server/updatephone.php" method="post">
                                    <li>
                                        <div class="info-name">Mobile</div>
                                        <div class="info-value">
                                            <input type="text" class="view-mode3" value="<?php echo $user_data['phone']; ?> " disabled>
                                            <div><input input class="edit-mode3" type="text" name="phone" id="phone" style="display: none;" value="<?php echo $user_data['phone']; ?>" required placeholder="(+???) 000-000-000"></div>
                                        </div>
                                    </li>
                                    <li>
                                        <button class="custom-button" type="submit" name="save3" id="save3" disabled>Save Changes</button>
                                    </li>
                                </form>
                                <script>
                                    $(document).ready(function () {
                                        $('.edit3').on('click', function () {
                                            $('.view-mode3').toggle();
                                            $('.edit-mode3').toggle();
                                            $('#phone').focus();
                                            $('#save3').prop('disabled', false);
                                        });
                                    });
                                </script>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="dash-pro-item dashboard-widget">
                                <div class="header">
                                    <h4 class="title">Security</h4>
                                    <span class="edit edit4"><i class="flaticon-edit"></i> Edit</span>
                                </div>
                                <form class="dash-pro-body" action="Server/updatepassword.php" method="post">
                                    <li>
                                        <div class="info-name">Password</div>
                                        <div class="info-value">
                                            <input type="password" class="view-mode4" value="<?php echo $user_data['password']; ?> " disabled>
                                            <div><input input class="edit-mode4" type="password" name="password" id="phone" style="display: none;" required placeholder="New Password"></div>
                                            <div><input input class="edit-mode4" type="password" name="password_confirmation" id="password_confirmation" style="display: none;" required placeholder="Confirm New Password"></div>
                                        </div>
                                    </li>
                                    <li>
                                        <button class="custom-button" type="submit" name="save4" id="save4" disabled>Save Changes</button>
                                    </li>
                                </form>
                                <script>
                                    $(document).ready(function () {
                                        $('.edit4').on('click', function () {
                                            $('.view-mode4').toggle();
                                            $('.edit-mode4').toggle();
                                            $('#password').focus();
                                            $('#password_confirmation').focus();
                                            $('#save4').prop('disabled', false);
                                        });
                                    });
                                </script>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="dash-pro-item dashboard-widget">
                                <div class="header">
                                    <h4 class="title">Session</h4>
                                </div>
                                <form class="dash-pro-body" action="Server/deleteuser.php" method="post" onsubmit="return confirmDelete()">
                                    <li>
                                        <button class="fab fa-envelope-open-text" type="submit" name="delete" id="delete">Delete Account</button>
                                    </li>
                                </form>
                                <form class="dash-pro-body" action="Server/logout.php" method="post" onsubmit="return confirmLogout()">
                                    <li>
                                        <button class="fab fa-envelope-open-text" type="submit" name="logout" id="logout">Logout</button>
                                    </li>
                                </form>
                                <script>
                                    function confirmDelete() {
                                        return confirm("Are you sure you want to delete your account?");
                                    }

                                    function confirmLogout() {
                                        return confirm("Are you sure you want to log out?");
                                    }
                                </script>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--============= Dashboard Section Ends Here =============-->


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
                                    <a href="#0"><i class="fas fa-envelope-open-text"></i><span class="__cf_email__" data-cfemail="432b262f3303262d242c372b262e266d202c2e">[email&#160;protected]</span></a>
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


<!-- Mirrored from pixner.net/SmartAuc/main/profile.php by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 25 Nov 2023 04:41:51 GMT -->
</html>