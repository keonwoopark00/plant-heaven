<?php

# Revision History

# DEVELOPER                     DATE            COMMENTS
#
# Keon Woo Park (1831319)       2020-02-18      Created home.php file
#
# Keon Woo Park (1831319)       2020-03-10      Debug and check
#
# Keon Woo Park (1831319)       2020-04-30      Debug and check
#
#

define("_FUCNTION_TO_IMPORT", "Functions/indexFunctions.php");

require_once _FUCNTION_TO_IMPORT;

createPageHeader(_COMPANY_NAME . " - Home");
loginLogout();
createIntroduction();
createLinkToDownloadCheatsheet();
createAdvertising();
createPageFooter();