<?php

# Revision History
# DEVELOPER                     DATE            COMMENTS
#
# Keon Woo Park (1831319)       2020-04-20      Created purchases.php file
#
# Keon Woo Park (1831319)       2020-04-24      Added search function
#
# Keon Woo Park (1831319)       2020-04-30      Debug and check   
#



# define constants
define("_COLLECTION_PARENT_CLASS", "collection.php");
define("_DB_CONNECTION", "database_connection.php");
define("_PURCHASE_CLASS", "purchase.php");
define("_JOIN_CLASS", "join.php");

require_once _COLLECTION_PARENT_CLASS;
require_once _DB_CONNECTION;
require_once _PURCHASE_CLASS;
require_once _JOIN_CLASS;

# start session to get customer uuid value
session_start();

# create class derives from the class collection
class purchases extends collection
{
    # array to store joined values
    public $joinedValues = array();
    
    # constructor
    public function __construct()
    {
        # call db connection
        global $connection;
        
        # write an sql query
        $sql = "CALL purchases_select()";
        
        # prepare the sql
        $PDOStatement = $connection->prepare($sql);
        
        # execute
        $PDOStatement->execute();
        
        # while the row exists
        while($row = $PDOStatement->fetch(PDO::FETCH_ASSOC))
        {
            # declare new purchase from the row using constructor
            $purchase = new purchase($row["pur_uuid"], $row["cus_uuid"], $row["pro_uuid"],
                    $row["pur_quantity"], $row["pur_price"], $row["pur_comments"],
                    $row["pur_subtotal"], $row["pur_taxes_amount"], $row["pur_grandtotal"]);
            
            # add the purchase to the collection
            $this->add($row["pur_uuid"], $purchase);
        }
    }
    
    
    # when the purchase is searched by date, this function will be called
    public function searchBydate($searchQuery){
        # empty the array to refill it with new data
        $this->items = array();
        
        # call db connection
        global $connection;
        
        # sql query
        $sql = "CALL filter_purchases(:searchDate, :cusUuid)";
        
        #prepare the sql
        $PDOStatement = $connection->prepare($sql);
        
        # bind parameters
        $PDOStatement->bindParam(":searchDate", $searchQuery);
        $PDOStatement->bindParam(":cusUuid", $_SESSION["cusUuid"]);

        # execute
        $PDOStatement->execute();
        
        # while the row exists
        while($row = $PDOStatement->fetch(PDO::FETCH_ASSOC))
        {
            # declare new purchase from the row
            $purchase = new purchase($row["pur_uuid"], $row["cus_uuid"], $row["pro_uuid"],
                    $row["pur_quantity"], $row["pur_price"], $row["pur_comments"],
                    $row["pur_subtotal"], $row["pur_taxes_amount"], $row["pur_grandtotal"]);
            
            # declare new join from the row (this values don't exist in purchase class)
            $join = new join($row["pro_code"], $row["cus_firstname"], $row["cus_lastname"],
                            $row["cus_city"]);
            
            # add the purchase to the collection
            $this->add($row["pur_uuid"], $purchase);
            
            # add the join to the joinedValues array (access key is the purchase uuid)
            $this->joinedValues[$row["pur_uuid"]] = $join;
        }
    }
}