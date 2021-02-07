<?php

# Revision History

# DEVELOPER                     DATE            COMMENTS
#
# Keon Woo Park (1831319)       2020-04-28      Created account.php file
#
# Keon Woo Park (1831319)       2020-04-30      Debug and check
#


define("_FUCNTION_TO_IMPORT", "Functions/formFunctions.php");

require_once _FUCNTION_TO_IMPORT;

# create an instance of customer object
$customer = new customer();

# load the logged-in customer information from database
if(isset($_SESSION["cusUuid"])){
    $customer->loadCustomer($_SESSION["cusUuid"]);
}

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

# if user tries to update information
if(isset($_POST["update"])){
    # fill the error variables (no error -> null) (verification using setters)
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
        # update the customer information in database
        $customer->saveCustomer();
        # move to homepage
        header('location: ' . _HOMEPAGE_PHP);
        exit();
    }
}


createPageHeader(_COMPANY_NAME . " - Register");
loginLogout();

if(isset($_SESSION["cusUuid"])){
    openForm("update-form", _ACCOUNT_PHP);
        # form contents
        createFormTextbox("Firstname", "firstname", $firstnameError, $customer->getCusFirstname());
        createFormTextbox("Lastname", "lastname", $lastnameError, $customer->getCusLastname());
        createFormTextbox("Address", "address", $addressError, $customer->getCusAddress());
        createFormTextbox("City", "city", $cityError, $customer->getCusCity());
        createFormTextbox("Province", "province", $provinceError, $customer->getCusProvince());
        createFormTextbox("Postal code", "postalcode", $postalCodeError, $customer->getCusPostalCode());
        createFormTextbox("Username", "username", $usernameError, $customer->getCusUsername());
        createFormPasswordbox("Password", "password", $passwordError);
    closeForm("update", "Update Info");
}
else{
    createInaccessibleMessage();
}
createPageFooter();