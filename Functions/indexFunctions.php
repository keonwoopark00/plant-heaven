<?php
# Revision History
# DEVELOPER                     DATE            COMMENTS
#
# Keon Woo Park (1831319)       2020-03-03      Created indexFunctions.php file
#
# Keon Woo Park (1831319)       2020-03-10      Debug and check
#
# Keon Woo Park (1831319)       2020-04-30      debug and check
#
#

define("_FUNCTION_FOLDER", "Functions/");
define("_COMMON_FUNCTIONS", _FUNCTION_FOLDER . "commonFunctions.php");
define("_DATA_FOLDER", "Data/");
define("_CHEAT_SHEET_TXT", _DATA_FOLDER . "CheatSheet.txt");

require_once _COMMON_FUNCTIONS;




function createLinkToDownloadCheatsheet(){
    ?>
    <div class='<?php echo _CLASS_CONTAINER ?>'>
        <p>
            <a href="<?php echo _CHEAT_SHEET_TXT ?>" download>Download Cheat sheet Here!</a>
        </p>
    </div>
    <?php
}

function createIntroduction() {
    // array of strings (introductory sentences)
    $introParagraphs = array(
        "Our company is for plant lover throughout the world.
        We sell many different plants and all the plant accessories.",
        "In addition, we provide tips and recommendations on plants by our plant specialists!",
        "Live a happy life in the Plant Heaven!"
    );
    echo "<main id='main-index'>";
        echo "<div class='" . _CLASS_CONTAINER . "'>";
            echo "<h2>Welcome to Plant Heaven!</h2>";
            // Display the introductory sentences line by line
            for ($position = 0; $position < count($introParagraphs); $position++) {
                createParagraph($introParagraphs[$position], _CLASS_INTRO);
            }
        echo "</div>";
    echo "</main>";
}

function createParagraph($contents, $class = null) {
    // create a paragraph with or without a class
    echo "<p class='" . $class . "'>" . $contents . "</p>";
}

function createAdvertising() {
    // array filled with 5 images
    $listPlants = array(_ORANGE_JASMINE_IMAGE, _PEPEROMIA_IMAGE, _ROSE_IMAGE,
        _SUCCULENT_IMAGE, _SUNFLOWER_IMAGE);
    // change the order of the array
    shuffle($listPlants);
    echo "<section id ='ad'>";
        echo "<div class='" . _CLASS_CONTAINER . "'>";
            echo "<h2>Our Products</h2>";
            // display images from the list
            for ($position = 0; $position < count($listPlants); $position++) {
            ?>
                <a href="https://www.newegg.ca/">
                <img src="<?php echo $listPlants[$position] ?>" class="
                <?php
                echo ($listPlants[$position] == _ROSE_IMAGE) ?
                    _CLASS_AD_IMG . " " . _CLASS_BIG : _CLASS_AD_IMG;
                ?>">
                </a>
            <?php
            }
        echo "</div>";
    echo "</section>";
}