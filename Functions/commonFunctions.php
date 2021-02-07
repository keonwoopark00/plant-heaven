<?php
# Revision History
# DEVELOPER                     DATE            COMMENTS
#
# Keon Woo Park (1831319)       2020-02-18      Created functions.php file
#
# Keon Woo Park (1831319)       2020-02-22      Added functions
#
# Keon Woo Park (1831319)       2020-03-01      Added functions
#
# Keon Woo Park (1831319)       2020-03-03      Changed the file name into commonFuncions.php
#                                               and divided the file into four files
#
# Keon Woo Park (1831319)       2020-03-10      Debug and check
#
# Keon Woo Park (1831319)       2020-03-10      Debug and check
#
# Keon Woo Park (1831319)       2020-04-22      Add some functions
#
# Keon Woo Park (1831319)       2020-04-28      Modified navigation menu to add account page
#
# Keon Woo Park (1831319)       2020-04-30      Debug and check
#
#

# CSS and JS-related constants
define("_CSS_FOLDER", "CSS/");
define("_CSS_STYLESHEET", _CSS_FOLDER . "stylesheet.css");
define("_JS_FOLDER", "JS/");
define("_AJAX_JS", _JS_FOLDER . "ajax.js");

# CSS-class-related constants
define("_CLASS_INTRO", "intro");
define("_CLASS_CONTAINER", "container");
define("_CLASS_AD_IMG", "ad-img");
define("_CLASS_BIG", "big");
define("_CLASS_REQUIRED", "required");
define("_CLASS_RED", "red");
define("_CLASS_FORM_LABEL", "form-label");
define("_CLASS_RIGHT_ALIGN", "right");
define("_CLASS_LOGIN", "login");

# Image-related constants
define("_IMAGE_FOLDER", "IMAGE/");
define("_COMPANY_LOGO", _IMAGE_FOLDER . "logo.png");
define("_ORANGE_JASMINE_IMAGE", _IMAGE_FOLDER . "orangejasmine.jpg");
define("_PEPEROMIA_IMAGE", _IMAGE_FOLDER . "peperomia.jpg");
define("_ROSE_IMAGE", _IMAGE_FOLDER . "rose.jpg");
define("_SUCCULENT_IMAGE", _IMAGE_FOLDER . "succulent.jpg");
define("_SUNFLOWER_IMAGE", _IMAGE_FOLDER . "sunflower.jpg");

# Object-related constants
define("_CLASSES_FOLDER", "Classes/");
define("_CUSTOMER_CLASS", _CLASSES_FOLDER . "customer.php");
define("_PRODUCT_CLASS", _CLASSES_FOLDER . 'product.php');
define("_PRODUCTS_CLASS", _CLASSES_FOLDER . 'products.php');
define("_PURCHASE_CLASS", _CLASSES_FOLDER . 'purchase.php');

# Debug-related
define("_DEBUG_FOLDER", "../debug/");
define("_LOG_FILE", _DEBUG_FOLDER . "logs.txt");

# Page-related
define("_HOMEPAGE_PHP", "index.php");
define("_BUY_PHP", "buy.php");
define("_PURCHASES_PHP", "purchases.php");
define("_REGISTER_PHP", "register.php");
define("_ACCOUNT_PHP", "account.php");

define("_COMPANY_NAME", "Plant Heaven");



require_once _CUSTOMER_CLASS;


# error and exception management functions
function manageError($errorCode, $errorMessage, $errorFile, $errorLine){
    // declare current datetime
    $currentDate = new DateTime("now");
    // put error messages into the log file
    file_put_contents(_LOG_FILE, "An error occured at " . $currentDate->format("Y/M/d H:i:s") . "\r\n", FILE_APPEND);
    file_put_contents(_LOG_FILE, "Error code: " . $errorCode . "\r\n", FILE_APPEND);
    file_put_contents(_LOG_FILE, "Error message: " . $errorMessage . "\r\n", FILE_APPEND);
    file_put_contents(_LOG_FILE, "File name: " . $errorFile . "\r\n", FILE_APPEND);
    file_put_contents(_LOG_FILE, "Line: " . $errorLine . "\r\n", FILE_APPEND);
    file_put_contents(_LOG_FILE, "Browser Information:  " . 
            $_SERVER["HTTP_USER_AGENT"] . "\r\n\r\n", FILE_APPEND);
}

function manageException($exception){
    // declare current datetime
    $currentDate = new DateTime("now");
    // put exception messages into the log file
    file_put_contents(_LOG_FILE, "An exception occured at " . $currentDate->format("Y M d") . "\r\n", FILE_APPEND);
    file_put_contents(_LOG_FILE, "Exception code: " . $exception->getCode() . "\r\n", FILE_APPEND);
    file_put_contents(_LOG_FILE, "Exception message: " . $exception->getMessage() . "\r\n", FILE_APPEND);
    file_put_contents(_LOG_FILE, "File name: " . $exception->getFile() . "\r\n", FILE_APPEND);
    file_put_contents(_LOG_FILE, "Line: " . $exception->getLine() . "\r\n", FILE_APPEND);
    file_put_contents(_LOG_FILE, "Browser Information:  " . 
            $_SERVER["HTTP_USER_AGENT"] . "\r\n\r\n", FILE_APPEND);
}


# start the session 
session_start();

function createPageHeader($title) {
    // send UTF-8 network header
    header("Content-Type: text/html; charset='UTF-8");
    // send caching preventing header
    header("Expires: Thu, 01 Dec 194 16:00:00 GMT");
    header("Cache-Control: no-cache");
    header("Pragma: no-cache");
    // set error and exception handler
    set_error_handler("manageError");
    set_exception_handler("manageException");
    ?>
    <!DOCTYPE html>
    <html>
        <head>
            <meta charset="UTF-8">
            <link rel="stylesheet" type="text/css" href="<?php echo _CSS_STYLESHEET ?>">
            <?php
            if(basename(htmlentities($_SERVER["PHP_SELF"])) == _PURCHASES_PHP){
                ?>
                <script language="javascript" type="text/javascript" src="<?php echo _AJAX_JS; ?>"></script>
            <?php
            }
            ?>
            <title><?php echo $title ?></title>
        </head>
        <body>
    <?php
    createHeader();
}

function createPageFooter() {
    // declare current date
    $currentDate = new DateTime("now");
    // formatting current date to display just a year
    $formattedDate = $currentDate->format("Y");
    ?>
            <footer>
                <div class="<?php echo _CLASS_CONTAINER; ?>">
                    <?php echo 'Copyright Keon Woo Park (1831319) ' . $formattedDate . '.'; ?>
                </div>
            </footer>
        </body>
    </html>
    <?php
}

function createHeader() {
    echo "<header>";
        echo "<div class='" . _CLASS_CONTAINER . "'>";
            createCompanyLogo();
            echo "<h1>" . _COMPANY_NAME . "</h1>";
            createNavigationMenu();
        echo "</div>";
    echo "</header>";
}

function createCompanyLogo() {
    echo "<a href='" . _HOMEPAGE_PHP . "'>";
        echo "<img src='" . _COMPANY_LOGO . "'>";
    echo"</a>";
}

function createNavigationMenu() {
    // declare list of menus
    $phps = array(_HOMEPAGE_PHP, _BUY_PHP, _PURCHASES_PHP, _ACCOUNT_PHP);
    $menus = array("Home", "Buy", "Purchases", "Account");

    // navigation bar
    echo "<ul>";
        for($position = 0; $position < count($menus); $position++) {
            echo "<li><a href='" . $phps[$position] . "'>" . $menus[$position] . "</a></li>";
        }
    echo "</ul>";
}

function displayPOSTValue($name) {
    if (isset($_POST[$name])) {
        echo $_POST[$name];
    }
}

function displayErrorMessage($errorText) {
    echo "<label class='" . _CLASS_RED . "'>" . $errorText . "</label>";
}

function loginLogout(){
    # if user is logged-in
    if(isset($_SESSION["cusUuid"])){
        $customer = new customer();
        # load the customer info of the logged-in customer
        $customer->loadCustomer($_SESSION["cusUuid"]);
        # create logout button
        echo "<div class='" . _CLASS_LOGIN . "'>";
            echo "<div class='" . _CLASS_CONTAINER . "'>";
                echo "<p id='welcometext'>Welcome " . $customer->getCusFirstname() . " " . 
                    $customer->getCusLastname() . ".</p>";
            ?>
            <form action="<?php echo _HOMEPAGE_PHP; ?>" method="post">
                <input type="submit" name="logout" value="Logout" />
            </form>
            <?php
            echo "</div>";
        echo "</div>";
    }
    # if no user is logged-in
    else{
        # display the login form
        createLoginForm();
    }
}

function createLoginForm(){
    echo "<div class='" . _CLASS_LOGIN . "'>";
        echo "<div class='" . _CLASS_CONTAINER . "'>";
    ?>
            <form action="<?php _HOMEPAGE_PHP ?>" method="post">
                <form action="index.php" method="post">
                <p>
                    <label>Username: </label>
                    <input type="text" name="username" />
                </p>
                <p>
                    <label>Password: </label>
                    <input type="password" name="password" />
                </p>
                <input type="submit" name="login" value="Login" />
            </form>
            <p>
                Need a user account? <a href="<?php echo _REGISTER_PHP; ?>">Register</a>
            </p>
            </form>
    <?php
        echo "</div>";
    echo "</div>";
}


# set login logout thing
# if a user tries to login
if(isset($_POST["login"])){
    ## verify password
    $customer = new customer();
    # if the login information is correct
    if($customer->login($_POST["username"], $_POST["password"])){
        # store the primary key into session variable
        $_SESSION["cusUuid"] = $customer->getCusUuid();
        # reload the page
        header('Location: ' . basename(htmlentities($_SERVER["PHP_SELF"])));
        exit();
    }
    # if username/password is incorrect
    else{
        ?>
        <script>alert('Invalid username/password')</script>
        <?php
    }
}

# if a user tries to logout
if(isset($_POST["logout"])){
    # destroy session variables
    session_destroy();
    # reload the user to homepage
    header('Location: ' . _HOMEPAGE_PHP);
    exit();
}


function createInaccessibleMessage(){
    ?>
    <div class="<?php echo _CLASS_CONTAINER; ?>">
        <h2>You must login to see this page.</h2>
    </div>
    <?php
}