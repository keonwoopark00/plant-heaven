<?php

# Revision History
# DEVELOPER                     DATE            COMMENTS
#
# Keon Woo Park (1831319)       2020-04-20      Created customers.php file
#
# Keon Woo Park (1831319)       2020-04-30      Debug and check   
#



# define constants
define("_COLLECTION_PARENT_CLASS", "collection.php");
define("_DB_CONNECTION", "database_connection.php");
define("_CUSTOMER_CLASS", "customer.php");

require_once _COLLECTION_PARENT_CLASS;
require_once _DB_CONNECTION;
require_once _CUSTOMER_CLASS;


# create class derives from the class collection
class customers extends collection
{
    # constructor
    public function __construct()
    {
        # call db connection
        global $connection;
        
        # write an sql query
        $sql = "CALL customers_select()";
        
        # prepare the sql
        $PDOStatement = $connection->prepare($sql);
        
        # execute
        $PDOStatement->execute();
        
        # while the row exists
        while($row = $PDOStatement->fetch(PDO::FETCH_ASSOC))
        {
            # declare new customer from the row
            $customer = new customer($row["cus_uuid"], $row["cus_firstname"], 
                    $row["cus_lastname"], $row["cus_city"], $row["cus_province"],
                    $row["cus_postal_code"], $row["cus_username"], $row["cus_password"]);
            
            # add the customer to the collection
            $this->add($row["cus_uuid"], $customer);
        }
    }
}