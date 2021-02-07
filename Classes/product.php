<?php

# Revision History
# DEVELOPER                     DATE            COMMENTS
#
# Keon Woo Park (1831319)       2020-04-20      Created product.php file
# 
# Keon Woo Park (1831319)       2020-04-22      Added login function
#
# Keon Woo Park (1831319)       2020-04-30      Debug and check
#
#

# define constants
define("_DB__CONNECTION", "database_connection.php");

define("_PRODUCT_CODE_MAX_LENGTH", 12);
define("_DESCRIPTION_MAX_LENGTH", 100);
define("_MAX_PRICE", 10000.00);
define("_MIN_PRICE", 0.00);

require_once _DB__CONNECTION;



class product{
    # members for each column
    private $pro_uuid = "";
    private $pro_code = "";
    private $pro_description = "";
    private $pro_price = "";
    private $pro_cost_price = "";
    
    # constructor
    function __construct($uuid = "", $code = "", $desc= "", $price = "", $cost_price = "")
    {
        # if parameters are passed
        if($uuid != "")
        {
            $this->pro_uuid = $uuid;
            $this->pro_code = $code;
            $this->pro_description = $desc;
            $this->pro_price = $price;
            $this->pro_cost_price = $cost_price;
        }
    }
    
    # getters and setters
    public function getProUuid(){
        return $this->pro_uuid;
    }
    
    public function getProCode(){
        return $this->pro_code;
    }
    
    public function setProCode($code){
        if(mb_strlen($code) == 0){
            return "The product code cannot be empty.";
        }
        else if (mb_strlen($code) > _PRODUCT_CODE_MAX_LENGTH){
            return "The product code cannot be longer than " . _PRODUCT_CODE_MAX_LENGTH . " characters.";
        }
        else if (strtolower($Code)[0] != "p") {
            return "The product code must start with the letter 'P'.";
        }
        else{
            $this->pro_code = $code;
            return null;
        }
    }
    
    public function getProDescription(){
        return $this->pro_description;
    }
    
    public function setProDescription($description){
        if(mb_strlen($description) == 0){
            return "The description cannot be empty.";
        }
        else if (mb_strlen($description) > _DESCRIPTION_MAX_LENGTH){
            return "The description cannot be longer than " . _DESCRIPTION_MAX_LENGTH . " characters.";
        }
        else{
            $this->pro_description = $description;
            return null;
        }
    }
    
    public function getProPrice(){
        return $this->pro_price;
    }
    
    public function setProPrice($price){
        if ($price == "") {
            return "Price cannot be empty.";
        }
        # if the price is not a number
        else if (!is_numeric($price)) {
            return "Price must be a number.";
        }
        # if the price is in invalid range
        else if ($price > _MAX_PRICE || $price < _MIN_PRICE) {
            return "Price should be between $" . _MAX_PRICE . " and $" . _MIN_PRICE . ".";
        }
        else{
            $this->pro_price = $price;
            return null;
        }
    }
    
    public function getProCostPrice(){
        return $this->pro_cost_price;
    }
    
    public function setProCostPrice($cost_price){
        
        # if the cost price is not a number
        if (!is_numeric($cost_price)) {
            return "Cost price must be a number.";
        }
        # if the cost price is in invalid range
        else if ($cost_price > _MAX_PRICE || $cost_price < _MIN_PRICE) {
            return "Cost price should be between $" . _MAX_PRICE . " and $" . _MIN_PRICE . ".";
        }
        else{
            $this->pro_cost_price = $cost_price;
            return null;
        }
    }
    
    
    # load from the database
    public function loadProduct($product_uuid){
        # call db connection
        global $connection;
        
        # create sql query
        $sql = "CALL product_load(:product_uuid)";
        
        # prepare the sql query
        $PDOStatement = $connection->prepare($sql);
        
        # bind the parameter
        $PDOStatement->bindParam(":product_uuid", $product_uuid);
        
        # execute
        $PDOStatement->execute();
        
        # if the customer with parameter uuid exists
        if($row = $PDOStatement->fetch(PDO::FETCH_ASSOC)){
            # assign the values from database to the variables of the instance
            $this->pro_uuid = $row["pro_uuid"];
            $this->pro_code = $row["pro_code"];
            $this->pro_description = $row["pro_description"];
            $this->pro_price = $row["pro_price"];
            $this->pro_code = $row["pro_cost_price"];
        }
    }
    
    # save current object to the database
    public function saveProduct(){
        # call db connection
        global $connection;
        
        # if current object is new
        if($this->pro_uuid ==""){
            # insert new product into the databse
            
            # create sql query
            $sql = "CALL product_insert(:code, :desc, :price, :cost_price)";

            # prepare the sql query
            $PDOStatement = $connection->prepare($sql);

            # bind the parameter
            $PDOStatement->bindParam(":code", $this->pro_code);
            $PDOStatement->bindParam(":desc", $this->pro_description);
            $PDOStatement->bindParam(":price", $this->pro_price);
            $PDOStatement->bindParam(":cost_price", $this->pro_cost_price);

            # execute
            $PDOStatement->execute();
        }
        # if current object is already in the database
        else{
            # update the purchase data
            
            # create sql query
            $sql = "CALL product_update(:uuid, :code, :desc, :price, :cost_price)";

            # prepare the sql query
            $PDOStatement = $connection->prepare($sql);

            # bind the parameter
            $PDOStatement->bindParam(":uuid", $this->pro_uuid);
            $PDOStatement->bindParam(":code", $this->pro_code);
            $PDOStatement->bindParam(":desc", $this->pro_description);
            $PDOStatement->bindParam(":price", $this->pro_price);
            $PDOStatement->bindParam(":cost_price", $this->pro_cost_price);

            # execute
            $PDOStatement->execute();
        }
    }
    
    # delete the current object from the database
    public function deleteProduct()
    {
        # call db connection
        global $connection;

        # create sql query
        $sql = "CALL product_delete(:uuid)";

        # prepare the SQL query
        $PDOStatement = $connection->prepare($sql);

        # bind the parameters
        $PDOStatement->bindParam(":uuid", $this->pro_uuid);

        # execute the query
        $PDOStatement->execute();
    }
}
    