<?php

# Revision History
# DEVELOPER                     DATE            COMMENTS
#
# Keon Woo Park (1831319)       2020-04-20      Created purchase.php file
#
# Keon Woo Park (1831319)       2020-04-30      Debug and check
#
#

# define constants
define("__DB__CONNECTION", "database_connection.php");

define("_COMMENTS_MAX_LENGTH", 200);
define("_MAX__PRICE", 10000.00);
define("_MIN__PRICE", 0.00);
define("_MAX_QUANTITY", 99);
define("_MIN_QUANTITY", 1);

define("_TAX_RATE", 0.152);

require_once __DB__CONNECTION;




class purchase{
    # members for each column
    private $pur_uuid = "";
    private $cus_uuid = "";
    private $pro_uuid = "";
    private $pur_quantity = "";
    private $pur_price = "";
    private $pur_comments = "";
    private $pur_subtotal = "";
    private $pur_taxes_amount = "";
    private $pur_grandtotal = "";
    
    # constructor
    function __construct($pur_uuid = "", $cus_uuid = "", $pro_uuid= "", 
            $quantity = "", $price = "", $comments = "", $subtotal = "", 
            $taxes_amount = "", $grandtotal = "")
    {
        # if parameters are passed
        if($pur_uuid != "")
        {
            $this->pur_uuid = $pur_uuid;
            $this->cus_uuid = $cus_uuid;
            $this->pro_uuid = $pro_uuid;
            $this->pur_quantity = $quantity;
            $this->pur_price = $price;
            $this->pur_comments = $comments;
            $this->pur_subtotal = $subtotal;
            $this->pur_taxes_amount = $taxes_amount;
            $this->pur_grandtotal = $grandtotal;
        }
    }
    
    # getters and setters
    public function getPurUuid(){
        return $this->pur_uuid;
    }
    
    public function getCusUuid(){
        return $this->cus_uuid;
    }
    
    public function setCusUuid($cus_uuid){
        if(mb_strlen($cus_uuid) == 0){
            return "The customer uuid cannot be empty.";
        }
        else if (mb_strlen($cus_uuid) != 36){
            return "The customer uuid should contain 36 characters.";
        }
        else{
            $this->cus_uuid = $cus_uuid;
            return null;
        }
    }
    
    public function getProUuid(){
        return $this->pro_uuid;
    }
    
    public function setProUuid($pro_uuid){
        if(mb_strlen($pro_uuid) == 0){
            return "The product uuid cannot be empty.";
        }
        else if (mb_strlen($pro_uuid) != 36){
            return "The product uuid should contain 36 characters.";
        }
        else{
            $this->pro_uuid = $pro_uuid;
            return null;
        }
    }
    
    public function getPurQuantity(){
        return $this->pur_quantity;
    }
    
    public function setPurQuantity($quantity){
        if ($quantity == "") {
            return "Quantity cannot be empty.";
        }
        # if the field is not a number
        else if (!is_numeric($quantity)) {
            return "Quantity must be a number.";
        }
        # if quantity is not an integer
        else if (intval($quantity) <> floatval($quantity)) {
            return "Quantity must be integer.";
        }
        # check if quantity is invalid in amount
        else if ((int) $quantity > _MAX_QUANTITY || (int) $quantity < _MIN_QUANTITY) {
            return "Quantity should be between " . _MIN_QUANTITY . " and " . _MAX_QUANTITY .".";
        }
        else{
            $this->pur_quantity = $quantity;
            return null;
        }
    }
    
    public function getPurPrice(){
        return $this->pur_price;
    }
    
    public function setPurPrice($price){
        if ($price == "") {
            return "Price cannot be empty.";
        }
        # if the price is not a number
        else if (!is_numeric($price)) {
            return "Price must be a number.";
        }
        # if the price is in invalid range
        else if ($price > _MAX__PRICE || $price < _MIN__PRICE) {
            return "Price should be between $" . _MAX__PRICE . " and $" . _MIN__PRICE . ".";
        }
        else{
            $this->pur_price = $price;
            return null;
        }
    }
    
    public function getPurComments(){
        return $this->pur_comments;
    }
    
    public function setPurComments($comments){
        
        # if comments are longer than max length
        if (mb_strlen($comments) > _COMMENTS_MAX_LENGTH){
            return "Comments cannot be longer than " . _COMMENTS_MAX_LENGTH . " characters.";
        }
        else{
            $this->pur_comments = $comments;
            return null;
        }
    }
    
    public function getPurSubtotal(){
        return $this->pur_subtotal;
    }
    
    public function setPurSubtotal(){
        $this->pur_subtotal = $this->pur_price * $this->pur_quantity;
    }
    
    public function getPurTaxesAmount(){
        return $this->pur_taxes_amount;
    }
    
    public function setPurTaxesAmount(){
        $this->pur_taxes_amount = $this->pur_subtotal * _TAX_RATE;
    }
    
    public function getPurGrandtotal(){
        return $this->pur_grandtotal;
    }
    
    public function setPurGrandtotal(){
        $this->pur_grandtotal = $this->pur_subtotal + $this->pur_taxes_amount;
    }
    
    
    # load from the database
    public function loadPurchase($purchase_uuid){
        # call db connection
        global $connection;
        
        # create sql query
        $sql = "CALL purchase_load(:purchase_uuid)";
        
        # prepare the sql query
        $PDOStatement = $connection->prepare($sql);
        
        # bind the parameter
        $PDOStatement->bindParam(":purchase_uuid", $purchase_uuid);
        
        # execute
        $PDOStatement->execute();
        
        # if the customer with parameter uuid exists
        if($row = $PDOStatement->fetch(PDO::FETCH_ASSOC)){
            # assign the values from database to the variables of the instance
            $this->pur_uuid = $row["pur_uuid"];
            $this->cus_uuid = $row["cus_uuid"];
            $this->pro_uuid = $row["pro_uuid"];
            $this->pur_quantity = $row["pur_quantity"];
            $this->pur_price = $row["pur_price"];
            $this->pur_comments = $row["pur_comments"];
            $this->pur_subtotal = $row["pur_subtotal"];
            $this->pur_taxes_amount = $row["pur_taxes_amount"];
            $this->pur_grandtotal = $row["pur_grandtotal"];
        }
    }
    
    # save current object to the database
    public function savePurchase(){
        # call db connection
        global $connection;
        
        # if current object is new
        if($this->pur_uuid ==""){
            # insert new purchase into the databse
            
            # create sql query
            $sql = "CALL purchase_insert(:cus_uuid, :pro_uuid, :quantity, :price,"
                    . ":comments, :subtotal, :taxes, :grandtotal)";

            # prepare the sql query
            $PDOStatement = $connection->prepare($sql);

            # bind the parameter
            $PDOStatement->bindParam(":cus_uuid", $this->cus_uuid);
            $PDOStatement->bindParam(":pro_uuid", $this->pro_uuid);
            $PDOStatement->bindParam(":quantity", $this->pur_quantity);
            $PDOStatement->bindParam(":price", $this->pur_price);
            $PDOStatement->bindParam(":comments", $this->pur_comments);
            $PDOStatement->bindParam(":subtotal", $this->pur_subtotal);
            $PDOStatement->bindParam(":taxes", $this->pur_taxes_amount);
            $PDOStatement->bindParam(":grandtotal", $this->pur_grandtotal);

            # execute
            $PDOStatement->execute();
        }
        # if current object is already in the database
        else{
            # update the purchase data
            
            # create sql query
             $sql = "CALL purchase_update(:pur_uuid, :cus_uuid, :pro_uuid, :quantity, "
                     . ":price, :comments, :subtotal, :taxes, :grandtotal)";

            # prepare the sql query
            $PDOStatement = $connection->prepare($sql);

            # bind the parameter
            $PDOStatement->bindParam(":pur_uuid", $this->pur_uuid);
            $PDOStatement->bindParam(":cus_uuid", $this->cus_uuid);
            $PDOStatement->bindParam(":pro_uuid", $this->pro_uuid);
            $PDOStatement->bindParam(":quantity", $this->pur_quantity);
            $PDOStatement->bindParam(":price", $this->pur_price);
            $PDOStatement->bindParam(":comments", $this->pur_comments);
            $PDOStatement->bindParam(":subtotal", $this->pur_subtotal);
            $PDOStatement->bindParam(":taxes", $this->pur_taxes_amount);
            $PDOStatement->bindParam(":grandtotal", $this->pur_grandtotal);

            # execute
            $PDOStatement->execute();
        }
    }
    
    # delete the current object from the database
    public function deletePurchase()
    {
        # call db connection
        global $connection;

        # create sql query
        $sql = "CALL purchase_delete(:uuid)";

        # prepare the SQL query
        $PDOStatement = $connection->prepare($sql);

        # bind the parameters
        $PDOStatement->bindParam(":uuid", $this->pur_uuid);

        # execute the query
        $PDOStatement->execute();
    }
}
    