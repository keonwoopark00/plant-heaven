<?php


# Revision History
#
# DEVELOPER                     DATE            COMMENTS
#
# Keon Woo Park (1831319)       2020-04-24      Created searchPurchases.php file
#
# Keon Woo Park (1831319)       2020-04-30      Debug and check
#
#


define("CLASS_FOLDER", "Classes/");
define("CLASS_PURCHASES", CLASS_FOLDER . "purchases.php");
define("CLASS_PURCHASE", CLASS_FOLDER . "purchase.php");


require_once CLASS_PURCHASES;
require_once CLASS_PURCHASE;

# if we received a searchQuery as a paremeter
if(isset($_POST["searchQuery"])){
    # get the parameter and get out of html injection
    $searchQuery = "";
    # if the date is invlalid
    if(!strtotime(htmlspecialchars($_POST["searchQuery"]))){
        $searchQuery = null; 
    }
    else{
        $searchQuery = htmlspecialchars($_POST["searchQuery"]);
    }

    $purchases = new purchases();
    $purchases->searchBydate($searchQuery);
    
    ?>
    <!--Generate HTML table-->
    <section id ='tab'>
        <div class="container">
            <table>
                <!--table head-->
                <thead>
                    <tr>
                        <th>Delete</th>
                        <th>Product Code</th>
                        <th>First name</th>
                        <th>Last name</th>
                        <th>City</th>
                        <th>Comments</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                        <th>Taxes</th>
                        <th>Grand total</th>
                    </tr>
                </thead> 
                <tbody>
    <?php
                foreach($purchases->items as $purchase){
                    echo "<tr>";
                        echo "<td>";
                            echo '<form method="POST" action="searchPurchases.php">';
                                echo '<input name="purUuid" type="hidden" value="' . $purchase->getPurUuid() . '" />';
                                echo '<input type="submit" name="delete" value="Delete" />';
                            echo '</form>';
                        echo "</td>";
                        echo "<td>" . $purchases->joinedValues[$purchase->getPurUuid()]->getProCode() . "</td>";
                        echo "<td>" . $purchases->joinedValues[$purchase->getPurUuid()]->getCusFirstname() . "</td>";
                        echo "<td>" . $purchases->joinedValues[$purchase->getPurUuid()]->getCusLastname() . "</td>";
                        echo "<td>" . $purchases->joinedValues[$purchase->getPurUuid()]->getCusCity() . "</td>";
                        echo "<td>" . $purchase->getPurComments() . "</td>";
                        echo "<td>$" . $purchase->getPurPrice() . "</td>";
                        echo "<td>" . $purchase->getPurQuantity() . "</td>";
                        echo "<td>$" . $purchase->getPurSubtotal() . "</td>";
                        echo "<td>$" . $purchase->getPurTaxesAmount() . "</td>";
                        echo "<td>$" . $purchase->getPurGrandtotal() . "</td>";
                    echo "</tr>";
                }
    ?>
        <!--close table-->
                </tbody>
            </table>
        </div>
    </section>
    <?php
}



if(isset($_POST["delete"])){
    $pur = new purchase();
    # load purchase data of corresponding row from database
    $pur->loadPurchase($_POST["purUuid"]);
    # delete the purchase
    $pur->deletePurchase();

    # relocate
    header("location: purchases.php");
    exit();
}