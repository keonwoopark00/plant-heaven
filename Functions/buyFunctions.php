<?php
# Revision History
# DEVELOPER                     DATE            COMMENTS
#
# Keon Woo Park (1831319)       2020-03-03      Created buyFunctions.php file
#
# Keon Woo Park (1831319)       2020-03-10      Debug and check
#
# Keon Woo Park (1831319)       2020-04-22      Add functions
#
# Keon Woo Park (1831319)       2020-04-30      Debug and check
#
#


define("_FUNCTION_FOLDER", "Functions/");
define("_COMMON_FUNCTIONS", _FUNCTION_FOLDER . "commonFunctions.php");

require_once _COMMON_FUNCTIONS;
require_once _PRODUCT_CLASS;
require_once _PRODUCTS_CLASS;
require_once _PURCHASE_CLASS;



function openBuyForm(){
    ?>
    <div class="<?php echo _CLASS_CONTAINER; ?>">
        <form id="buy-form" action="<?php echo _BUY_PHP; ?>" method="POST">
            <label class="<?php echo _CLASS_RED ?>">* = Required</label>
    <?php
}

function closeBuyForm(){
    ?>
            <p>
                <input type="submit" name="buy" value="Buy" />
            </p>
        </form>
    </div>
    <?php
}

function createProductDropdown($errorText){
    # declare a plural class of products
    $products = new products();
    ?>
    <p>
        <label class="<?php echo _CLASS_FORM_LABEL ?>">Product Code 
            <span class="<?php echo _CLASS_RED; ?>">*</span> : </label>
    <select name="pcode">
        <option value=""></option>
        <?php
        # for each product
        foreach($products->items as $product){
            echo "<option value=" . $product->getProUuid() . ">" . 
                    $product->getProCode() . " - " . $product->getProDescription() . "</option>";
        }
    echo "</select>";
    # null will be passed if there is no error
    displayErrorMessage($errorText);
    echo "</p>";
}

function createFormTextbox($fieldName, $name, $errorText, $mandatory = false) {
    # use global variable to track errors
    global $errorFound;
    ?>
    <p>
        <label class="<?php echo _CLASS_FORM_LABEL ?>">
            <?php echo $fieldName; 
                # if the field is mandatory
                if($mandatory){
                    # display *
                    echo "<span class=" . _CLASS_RED . "> * </span>";
                } 
                ?>: </label>
        <input type="text" name="<?php echo $name; ?>" 
               value="<?php
               # if there is error - display the content / else - clear the textbox
                if ($errorFound) {
                    displayPOSTValue($name);
                }
        ?>"/>
        <?php displayErrorMessage($errorText) ?>
    </p>
    <?php
}