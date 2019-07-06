<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: welcome.php");
    exit;
}
 
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT id, username, password FROM users WHERE username = ?";
        
        if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $param_username);
            
            // Set parameters
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Store result
                $stmt->store_result();
                
                // Check if username exists, if yes then verify password
                if($stmt->num_rows == 1){                    
                    // Bind result variables
                    $stmt->bind_result($id, $username, $hashed_password);
                    if($stmt->fetch()){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;                            
                            
                            // Redirect user to welcome page
                            header("location: welcome.php");
                        } else{
                            // Display an error message if password is not valid
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } else{
                    // Display an error message if username doesn't exist
                    $username_err = "No account found with that username.";
                }
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
<title>LOGIN</title>
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
  <p class="page_name">HOME&nbsp;/&nbsp;LOGIN</p>
</div> 
    <div class="wrapper">
        <h2>Login</h2>
        <p>Please fill in your credentials to login.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Username</label>
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" name="password" class="form-control">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
            <p>Don't have an account? <a href="register.php">Sign up now</a>.</p>
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