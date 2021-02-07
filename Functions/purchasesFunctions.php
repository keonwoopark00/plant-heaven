<?php
# Revision History
# DEVELOPER                     DATE            COMMENTS
#
# Keon Woo Park (1831319)       2020-03-03      Created purchasesFunctions.php file
#
# Keon Woo Park (1831319)       2020-04-24      Modified - search button and result
#
# Keon Woo Park (1831319)       2020-04-30      debug and check
#
#

define("_FUNCTION_FOLDER", "Functions/");
define("_COMMON_FUNCTIONS", _FUNCTION_FOLDER . "commonFunctions.php");

require_once _COMMON_FUNCTIONS;

function createSearchButton(){
    ?>
    <div id="searchDiv">
        <div class="<?php echo _CLASS_CONTAINER; ?>">
            <p>
                <label>Enter a date to view only recent purchases: </label>
                <input type="text" id="searchQuery" />
            </p>
            <button onclick="searchPurchases();">Search</button>
        </div>
    </div>
    <?php
}

function displaySearchResults(){
    ?>
    <div id="searchResults">
        <div class="<?php echo _CLASS_CONTAINER; ?>">
        </div>
    </div>
    <?php
}