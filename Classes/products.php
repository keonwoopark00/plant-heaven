<?php

# Revision History
# DEVELOPER                     DATE            COMMENTS
#
# Keon Woo Park (1831319)       2020-04-20      Created products.php file
#
# Keon Woo Park (1831319)       2020-04-30      Debug and check   
#



# define constants
define("_COLLECTION_PARENT_CLASS", "collection.php");
define("__DB_CONNECTION", "database_connection.php");
define("__PRODUCT_CLASS", "product.php");

require_once _COLLECTION_PARENT_CLASS;
require_once __DB_CONNECTION;
require_once __PRODUCT_CLASS;



# create class derives from the class collection
class products extends collection
{
    # constructor
    public function __construct()
    {
        # call db connection
        global $connection;
        
        # write an sql query
        $sql = "CALL products_select()";
        
        # prepare the sql
        $PDOStatement = $connection->prepare($sql);
        
        # execute
        $PDOStatement->execute();
        
        # while the row exists
        while($row = $PDOStatement->fetch(PDO::FETCH_ASSOC))
        {
            # declare new product from the row
            $product = new product($row["pro_uuid"], $row["pro_code"], 
                    $row["pro_description"], $row["pro_price"], $row["pro_cost_price"]);
            
            # add the product to the collection
            $this->add($row["pro_uuid"], $product);
        }
    }
}