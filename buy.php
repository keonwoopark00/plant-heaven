<?php

# Revision History

# DEVELOPER                     DATE            COMMENTS
#
# Keon Woo Park (1831319)       2020-02-19      Created buy.php file
#
# Keon Woo Park (1831319)       2020-02-22      Designed the page
#
# Keon Woo Park (1831319)       2020-02-28      Completed the form
# 
# Keon Woo Park (1831319)       2020-03-10      Debug and check
#
# Keon Woo Park (1831319)       2020-04-23      Modify page
#
# Keon Woo Park (1831319)       2020-04-30      Debug and check
#
#

define("_FUCNTION_TO_IMPORT", "Functions/buyFunctions.php");

require_once _FUCNTION_TO_IMPORT;

# declare a global variable - will be used to check if error exists
global $errorFound;

# declare an instance of class purchase
$purchase = new purchase();

# declare error-related variables
$pCodeError = "";
$commentsError = "";
$quantityError = "";

# if the user tries to make a purchase
if (isset($_POST["buy"])) {
    # if user does not choose the product code
    if($_POST["pcode"] == ""){
        $pCodeError = " Product code should be chosen.";
    }
    # verify the user inputs using setters
    $commentsError = $purchase->setPurComments(htmlspecialchars($_POST["comments"]));
    $quantityError = $purchase->setPurQuantity(htmlspecialchars($_POST["quantity"]));
    
    # if there exists an error
    if($pCodeError != "" || $commentsError != null || $quantityError != null){
        $errorFound = true;
    }
    
    # if validation is ok
    if(!$errorFound){
        # declare and load product with product uuid in order to get price
        $product = new product();
        $product->loadProduct($_POST["pcode"]);
        $purchase->setCusUuid($_SESSION["cusUuid"]);
        $purchase->setProUuid($_POST["pcode"]);
        $purchase->setPurPrice($product->getProPrice());
        $purchase->setPurSubtotal();
        $purchase->setPurTaxesAmount();
        $purchase->setPurGrandtotal();
        $purchase->savePurchase();
    }
}


createPageHeader(_COMPANY_NAME . " - Buy");
loginLogout();

# if user is logged-in
if(isset($_SESSION["cusUuid"])){
    openBuyForm();
        createProductDropdown($pCodeError);
        createFormTextbox("Comments", "comments", $commentsError);
        createFormTextbox("Quantity", "quantity", $quantityError, true);
    closeBuyForm();
}
else{
    createInaccessibleMessage();
}

createPageFooter();