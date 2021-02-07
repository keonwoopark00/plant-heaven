<?php

# Revision History

# DEVELOPER                     DATE            COMMENTS
#
# Keon Woo Park (1831319)       2020-04-22      Created register.php file
#
# Keon Woo Park (1831319)       2020-04-30      Debug and check
#
#

define("_FUCNTION_TO_IMPORT", "Functions/formFunctions.php");

require_once _FUCNTION_TO_IMPORT;


# create an instance of customer object
$customer = new customer();

# declare error-related variables
$firstnameError = "";
$lastnameError = "";
$addressError = "";
$cityError = "";
$provinceError = "";
$postalCodeError = "";
$usernameError = "";
$passwordError = "";
global $errorFound;

# if user tries to register
if(isset($_POST["register"])){
    # fill the error variables (no error -> null) -> verification using setters
    $firstnameError = $customer->setCusFirstname(htmlspecialchars($_POST["firstname"]));
    $lastnameError = $customer->setCusLastname(htmlspecialchars($_POST["lastname"]));
    $addressError = $customer->setCusAddress(htmlspecialchars($_POST["address"]));
    $cityError = $customer->setCusCity(htmlspecialchars($_POST["city"]));
    $provinceError = $customer->setCusProvince(htmlspecialchars($_POST["province"]));
    $postalCodeError = $customer->setCusPostalCode(htmlspecialchars($_POST["postalcode"]));
    $usernameError = $customer->setCusUsername(htmlspecialchars($_POST["username"]));
    $passwordError = $customer->setCusPassword(htmlspecialchars($_POST["password"]));
    
    # if any error is found
    if($firstnameError != null || $lastnameError != null || $addressError != null ||
            $cityError != null || $provinceError != null || $postalCodeError != null ||
            $usernameError != null || $passwordError != null){
        $errorFound = true;
    }
    
    # if there is no error
    if(!$errorFound){
        # save the customer information in database
        $customer->saveCustomer();
        # move to homepage
        header('location: ' . _HOMEPAGE_PHP);
        exit();
    }
}


createPageHeader(_COMPANY_NAME . " - Register");
    openForm("register-form", _REGISTER_PHP);
        # form contents
        createFormTextbox("Firstname", "firstname", $firstnameError);
        createFormTextbox("Lastname", "lastname", $lastnameError);
        createFormTextbox("Address", "address", $addressError);
        createFormTextbox("City", "city", $cityError);
        createFormTextbox("Province", "province", $provinceError);
        createFormTextbox("Postal code", "postalcode", $postalCodeError);
        createFormTextbox("Username", "username", $usernameError);
        createFormPasswordbox("Password", "password", $passwordError);
    closeForm("register", "Register");
createPageFooter();