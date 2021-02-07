<?php

# Revision History

# DEVELOPER                     DATE            COMMENTS
#
# Keon Woo Park (1831319)       2020-02-19      Created purchases.php file
#
# Keon Woo Park (1831319)       2020-03-01      Created table
# 
# Keon Woo Park (1831319)       2020-03-10      Debug and check
#
# Keon Woo Park (1831319)       2020-04-24      Modified for project 3
#
# Keon Woo Park (1831319)       2020-04-30      Debug and check
#
#

define("_FUCNTION_TO_IMPORT", "Functions/purchasesFunctions.php");

require_once _FUCNTION_TO_IMPORT;


createPageHeader(_COMPANY_NAME . " - Purchases");
loginLogout();
#if user is logged-in
if(isset($_SESSION["cusUuid"])){
    createSearchButton();
    
    displaySearchResults();
}
else{
    createInaccessibleMessage();
}
createPageFooter(); 