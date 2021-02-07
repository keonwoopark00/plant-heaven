<?php

# Revision History
# DEVELOPER                     DATE            COMMENTS
#
# Keon Woo Park (1831319)       2020-04-20      Created registerFunctions.php file
#
# Keon Woo Park (1831319)       2020-04-28      Changed file name into formFunctions.php
#                                               and modified functions
#                                               
# Keon Woo Park (1831319)       2020-04-30      debug and check
#
#


define("_FUNCTION_FOLDER", "Functions/");
define("_COMMON_FUNCTIONS", _FUNCTION_FOLDER . "commonFunctions.php");

require_once _COMMON_FUNCTIONS;

function openForm($id, $action){
    ?>
    <div class="<?php echo _CLASS_CONTAINER; ?>">
        <form id="<?php echo $id; ?>" action="<?php echo $action; ?>" method="post">
            <label class="<?php echo _CLASS_RED ?>">* = Required</label>
    <?php
}

function closeForm($name, $value){
    ?>
            <p>
                <input type="submit" name="<?php echo $name; ?>" value="<?php echo $value; ?>" />
            </p>
        </form>
    </div>
    <?php
}

function createFormTextbox($fieldName, $name, $errorText, $value="") {
    # use global variable to track errors
    global $errorFound;
    ?>
    <p>
        <label class="<?php echo _CLASS_FORM_LABEL ?>"><?php echo $fieldName . 
                "<span class=" . _CLASS_RED . "> * </span>:"; ?></label>
        <input type="text" name="<?php echo $name; ?>" 
               value="<?php
                # if value is passed as a parameter
                if($value != "" && !$errorFound){
                    echo $value;
                }
                # if there is error - display the content / else - clear the textbox
                if ($errorFound) {
                    displayPOSTValue($name);
                }
        ?>"/>
        <?php displayErrorMessage($errorText) ?>
    </p>
    <?php
}

function createFormPasswordBox($fieldName, $name, $errorText) {
    # use global variable to track errors
    global $errorFound;
    ?>
    <p>
        <label class="<?php echo _CLASS_FORM_LABEL ?>"><?php echo $fieldName . 
                "<span class=" . _CLASS_RED . "> * </span>:"; ?></label>
        <input type="password" name="<?php echo $name; ?>" 
               value="<?php
               // if there is error - display the content / else - clear the textbox
                if ($errorFound) {
                    displayPOSTValue($name);
                }
        ?>"/>
        <?php displayErrorMessage($errorText) ?>
    </p>
    <?php
}