<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
 
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$new_password = $confirm_password = "";
$new_password_err = $confirm_password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate new password
    if(empty(trim($_POST["new_password"]))){
        $new_password_err = "Please enter the new password.";     
    } elseif(strlen(trim($_POST["new_password"])) < 6){
        $new_password_err = "Password must have atleast 6 characters.";
    } else{
        $new_password = trim($_POST["new_password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm the password.";
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($new_password_err) && ($new_password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
        
    // Check input errors before updating the database
    if(empty($new_password_err) && empty($confirm_password_err)){
        // Prepare an update statement
        $sql = "UPDATE users SET password = ? WHERE id = ?";
        
        if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("si", $param_password, $param_id);
            
            // Set parameters
            $param_password = password_hash($new_password, PASSWORD_DEFAULT);
            $param_id = $_SESSION["id"];
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Password updated successfully. Destroy the session, and redirect to login page
                session_destroy();
                header("location: login.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        $stmt->close();
    }
    
    // Close connection
    $mysqli->close();
}
?>
 <!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>APPLE&nbsp;ROSE&nbsp;PUFF&nbsp;PASTRY</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="css/style.css" rel="stylesheet">
<link rel="stylesheet" href="css/jquery.bxslider.css">
<link href="css/bootstrap.min.css" rel="stylesheet">
<!--[if lt IE 9]>
    <script src="/js/html5shiv.js"></script>
  <![endif]-->
  <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>
<header>
  <h5>Free&nbsp;Shipping&nbsp;on&nbsp;orders&nbsp;over&nbsp;Rs/-&nbsp;500&nbsp;/&nbsp;365&nbsp;days&nbsp;easy&nbsp;return</h5>
  <div class="social">
    <ul>
      <li><a href="#"><img src="images/facebook_icon.png" width="25" height="25" alt="facebook"></a></li>
      <li><a href="#"><img src="images/twitter.png" width="25" height="25"></a></li>
      <li><a href="#"><img src="images/youtube.png" width="25" height="25" alt="youtube"></a></li>
      <li><a href="#"><img src="images/pininteresr.png" width="25" height="25" alt="pininterest"></a></li>
      <li><a href="#"><img src="images/google_plus.png" width="25" height="25" alt="google_plus"></a></li>
    </ul>
  </div>
  <div class="login">
    <ul>
      <li><a href="#"><img src="images/lock.png" width="12" height="12" alt="login" /class="logins">Login</a></li>
      <li>|</li>
      <li><a href="#"><img src="images/profile.png" width="12" height="12" alt="profile" /class="logins">Create&nbsp;an&nbsp;Account</a></li>
      <li>|</li>
      <li><a href="#">Cart</a></li>
      <li>|</li>
      <li><a href="#">Check&nbsp;Out<img src="images/rightarrow.png" width="12" height="12" alt="arrow" /class="loginsr"></a></li>
      <li>|</li>
      <li><a href="#">USD</a></li>
    </ul>
  </div>
  <div class="main">
    <div class="matter">
      <h2><a href="index.html">FOOD&nbsp;SHOP</a></h2>
      <nav class="menu">
        <ul>
          <li><a href="index.html">HOME</a></li>
          <li class="catlogs"><a href="#">CATALOG+</a>
            <section class="catlog_list">
              <ul class="appet">
                <li class="appmain"><a href="#">STARTERS</a></li>
                <li><a href="stater.html">Indian&nbsp;Starters</a></li>
                <li><a href="chinese_starters.html">Chinese&nbsp;Starters</a></li>
                <li><a href="italy_starters.html">Italian&nbsp;Starters</a></li>
                <li><a href="japanese_starters.html">Japanese&nbsp;Starters</a></li>
                <li><a href="thailand_starters.html">Thailand&nbsp;Starters</a></li>
                <li><a href="american_starters.html">American&nbsp;Starters</a></li>
              </ul>
              <ul class="deserts">
                <li class="desmain"><a href="#">DESSERTS</a></li>
                <li><a href="cakes.html">Cakes</a></li>
                <li><a href="cookies.html">Cookies</a></li>
                <li><a href="gelatin.html">Gelatins</a></li>
                <li><a href="pastries.html">Pastries</a></li>
                <li><a href="icecreams.html">Ice&nbsp;creams</a></li>
              </ul>
              <ul class="fruits">
                <li class="frumain"><a href="#">FRUITS</a></li>
                <li><a href="orange.html">Orange</a></li>
                <li><a href="pineapple.html">Pineapple</a></li>
                <li><a href="grapes.html">Grapes</a></li>
                <li><a href="mango.html">Mango</a></li>
                <li><a href="banana.html">Banana</a></li>
              </ul>
              <ul class="meats">
                <li class="meatmain"><a href="#">MEAT</a></li>
                <li><a href="red_meat.html">Red&nbsp;Meat</a></li>
                <li><a href="poultry_meat.html">Poultry</a></li>
                <li><a href="pork_meat.html">Pork</a></li>
                <li><a href="sea_meat.html">Sea&nbsp;Food</a></li>
              </ul>
            </section>
          </li>
          <li><a href="blog.html">BLOG+</a></li>
          <li><a href="#">SALE+</a></li>
          <li><a href="about_us.html">ABOUT&nbsp;US</a></li>
          <li><a href="contact_us.html">CONTACT&nbsp;US</a></li>
        </ul>
      </nav>
    </div>
  </div>
</header>
<div class="sub_page">
  <p class="page_name">HOME&nbsp;/&nbsp;DESSERTS&nbsp;/&nbsp;PASTRIES&nbsp;/&nbsp;APPLE&nbsp;ROSE&nbsp;PUFF&nbsp;PASTRY</p>
</div>
    <div class="wrapper">
        <h2>Reset Password</h2>
        <p>Please fill out this form to reset your password.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"> 
            <div class="form-group <?php echo (!empty($new_password_err)) ? 'has-error' : ''; ?>">
                <label>New Password</label>
                <input type="password" name="new_password" class="form-control" value="<?php echo $new_password; ?>">
                <span class="help-block"><?php echo $new_password_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control">
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <a class="btn btn-link" href="welcome.php">Cancel</a>
            </div>
        </form>
    </div>  
  <footer>
  <section class="total_footer">
    <div class="information_block">
      <p class="information_heading">Information</p>
      <ul>
        <li><a href="index.html">Home</a></li>
        <li><a href="#">Search</a></li>
        <li><a href="blog.html">Blog</a></li>
        <li><a href="about_us.html">About&nbsp;Us</a></li>
        <li><a href="contact_us.html">Contact&nbsp;Us</a></li>
      </ul>
    </div>
    <div class="catalog_block">
      <p class="catalog_heading">Catalog</p>
      <ul>
        <li><a href="desserts.html">Desserts</a></li>
        <li><a href="fruits_all.html">Fruits</a></li>
        <li><a href="meat_all.html">Meat</a></li>
        <li><a href="pizza_pasta_all.html">Pizza&nbsp;-&nbsp;Pasta</a></li>
        <li><a href="hot_chips.html">Hot&nbsp;Chips</a></li>
        <li><a href="sea_foods_all.html">Seafoods</a></li>
      </ul>
    </div>
    <div class="myaccount_block">
      <p class="account_heading">My&nbsp;Account</p>
      <ul>
        <li><a href="#">My&nbsp;Account</a></li>
        <li><a href="#">My&nbsp;Address</a></li>
        <li><a href="#">My&nbsp;Cart</a></li>
      </ul>
    </div>
  </section>
</footer>
<script src="js/jquery.min.js" type="text/javascript"></script> 
<script src="js/bootstrap.min.js" type="text/javascript"></script> 
<script src="js/jquery.bxslider.min.js" type="text/javascript"></script> 
<script src="js/own.js"></script>
</body>
</html>