<?php

# Revision History
# DEVELOPER                     DATE            COMMENTS
#
# Keon Woo Park (1831319)       2020-04-20      Created customer.php file
#
# Keon Woo Park (1831319)       2020-04-22      Added login function
#
#

# define constants
define("_DB_CONNECTION", "database_connection.php");

define("_FIRSTNAME_MAX_LENGTH", 20);
define("_LASTNAME_MAX_LENGTH", 20);
define("_ADDRESS_MAX_LENGTH", 25);
define("_CITY_MAX_LENGTH", 25);
define("_PROVINCE_MAX_LENGTH", 25);
define("_POSTAL_CODE_MAX_LENGTH", 7);
define("_USERNAME_MAX_LENGTH", 12);

require_once _DB_CONNECTION;



class customer{
    # members for each column
    private $cus_uuid = "";
    private $cus_firstname = "";
    private $cus_lastname = "";
    private $cus_address = "";
    private $cus_city ="";
    private $cus_province = "";
    private $cus_postal_code = "";
    private $cus_username = "";
    private $cus_password = "";
    
    # constructor
    function __construct($uuid = "", $firstname = "", $lastname = "", $address = "",
            $city = "", $province = "", $postal_code = "", $username = "", $password = "")
    {
        # if parameters are passed
        if($uuid != "")
        {
            $this->cus_uuid = $uuid;
            $this->cus_firstname = $firstname;
            $this->cus_lastname = $lastname;
            $this->cus_address = $address;
            $this->cus_city = $city;
            $this->cus_province = $province;
            $this->cus_postal_code = $postal_code;
            $this->cus_username = $username;
            $this->cus_password = $password;
        }
    }
    
    # getters and setters
    public function getCusUuid(){
        return $this->cus_uuid;
    }
    
     public function getCusFirstname(){
        return $this->cus_firstname;
    }
    
    public function setCusFirstname($firstname){
        if(mb_strlen($firstname) == 0){
            return "The first name cannot be empty.";
        }
        else if (mb_strlen($firstname) > _FIRSTNAME_MAX_LENGTH){
            return "The first name cannot be longer than " . _FIRSTNAME_MAX_LENGTH . " characters.";
        }
        else{
            $this->cus_firstname = $firstname;
            return null;
        }
    }
    
    public function getCusLastname(){
        return $this->cus_lastname;
    }
    
    public function setCusLastname($lastname){
        if(mb_strlen($lastname) == 0){
            return "The last name cannot be empty.";
        }
        else if (mb_strlen($lastname) > _LASTNAME_MAX_LENGTH){
            return "The last name cannot be longer than " . _LASTNAME_MAX_LENGTH . " characters.";
        }
        else{
            $this->cus_lastname = $lastname;
            return null;
        }
    }
    
    public function getCusAddress(){
        return $this->cus_address;
    }
    
    public function setCusAddress($address){
        if(mb_strlen($address) == 0){
            return "The address cannot be empty.";
        }
        else if (mb_strlen($address) > _CITY_MAX_LENGTH){
            return "The address cannot be longer than " . _ADDRESS_MAX_LENGTH . " characters.";
        }
        else{
            $this->cus_address = $address;
            return null;
        }
    }
    
    public function getCusCity(){
        return $this->cus_city;
    }
    
    public function setCusCity($city){
        if(mb_strlen($city) == 0){
            return "The city cannot be empty.";
        }
        else if (mb_strlen($city) > _CITY_MAX_LENGTH){
            return "The city name cannot be longer than " . _CITY_MAX_LENGTH . " characters.";
        }
        else{
            $this->cus_city = $city;
            return null;
        }
    }
    
    public function getCusProvince(){
        return $this->cus_province;
    }
    
    public function setCusProvince($province){
        if(mb_strlen($province) == 0){
            return "The province cannot be empty.";
        }
        else if (mb_strlen($province) > _PROVINCE_MAX_LENGTH){
            return "The province name cannot be longer than " . _PROVINCE_MAX_LENGTH . " characters.";
        }
        else{
            $this->cus_province = $province;
            return null;
        }
    }
    
    public function getCusPostalCode(){
        return $this->cus_postal_code;
    }
    
    public function setCusPostalCode($postal_code){
        if(mb_strlen($postal_code) == 0){
            return "The postal code cannot be empty.";
        }
        else if (mb_strlen($postal_code) > _POSTAL_CODE_MAX_LENGTH){
            return "The postal code cannot be longer than " . _POSTAL_CODE_MAX_LENGTH . " characters.";
        }
        else{
            $this->cus_postal_code = $postal_code;
            return null;
        }
    }
    
    public function getCusUsername(){
        return $this->cus_username;
    }
    
    public function setCusUsername($username){
        if(mb_strlen($username) == 0){
            return "The username cannot be empty.";
        }
        else if (mb_strlen($username) > _USERNAME_MAX_LENGTH){
            return "The username cannot be longer than " . _USERNAME_MAX_LENGTH . " characters.";
        }
        else{
            $this->cus_username = $username;
            return null;
        }
    }
    
    public function getCusPassword(){
        return $this->cus_password;
    }
    
    public function setCusPassword($password){
        if(mb_strlen($password) == 0){
            return "The password cannot be empty.";
        }
        else{
            $this->cus_password = password_hash($password, PASSWORD_DEFAULT);
            return null;
        }
    }
    
    
    # load from the database
    public function loadCustomer($customer_uuid){
        # call db connection
        global $connection;
        
        # create sql query
        $sql = "CALL customer_load(:customer_uuid)";
        
        # prepare the sql query
        $PDOStatement = $connection->prepare($sql);
        
        # bind the parameter
        $PDOStatement->bindParam(":customer_uuid", $customer_uuid);
        
        # execute
        $PDOStatement->execute();
        
        # if the customer with parameter uuid exists
        if($row = $PDOStatement->fetch(PDO::FETCH_ASSOC)){
            # assign the values from database to the corresponding variables of the instance
            $this->cus_uuid = $row["cus_uuid"];
            $this->cus_firstname = $row["cus_firstname"];
            $this->cus_lastname = $row["cus_lastname"];
            $this->cus_address = $row["cus_address"];
            $this->cus_city = $row["cus_city"];
            $this->cus_province = $row["cus_province"];
            $this->cus_postal_code = $row["cus_postal_code"];
            $this->cus_username = $row["cus_username"];
            $this->cus_password = $row["cus_password"];
        }
    }
    
    # save current object to the database
    public function saveCustomer(){
        # call db connection
        global $connection;
        
        # if current object is new
        if($this->cus_uuid ==""){
            ## insert new customer into the databse
            
            # create sql query
            $sql = "CALL customer_insert(:firstname, :lastname, :address, :city, "
                    . ":province, :postal_code, :username, :password)";

            # prepare the sql query
            $PDOStatement = $connection->prepare($sql);

            # bind the parameter
            $PDOStatement->bindParam(":firstname", $this->cus_firstname);
            $PDOStatement->bindParam(":lastname", $this->cus_lastname);
            $PDOStatement->bindParam(":address", $this->cus_address);
            $PDOStatement->bindParam(":city", $this->cus_city);
            $PDOStatement->bindParam(":province", $this->cus_province);
            $PDOStatement->bindParam(":postal_code", $this->cus_postal_code);
            $PDOStatement->bindParam(":username", $this->cus_username);
            $PDOStatement->bindParam(":password", $this->cus_password);

            # execute
            $PDOStatement->execute();
        }
        # if current object is already in the database
        else{
            # update the customer data
            
            # create sql query
            $sql = "CALL customer_update(:uuid, :firstname, :lastname, :address, :city, "
                    . ":province, :postal_code, :username, :password)";

            # prepare the sql query
            $PDOStatement = $connection->prepare($sql);

            # bind the parameter
            $PDOStatement->bindParam(":uuid", $this->cus_uuid);
            $PDOStatement->bindParam(":firstname", $this->cus_firstname);
            $PDOStatement->bindParam(":lastname", $this->cus_lastname);
            $PDOStatement->bindParam(":address", $this->cus_address);
            $PDOStatement->bindParam(":city", $this->cus_city);
            $PDOStatement->bindParam(":province", $this->cus_province);
            $PDOStatement->bindParam(":postal_code", $this->cus_postal_code);
            $PDOStatement->bindParam(":username", $this->cus_username);
            $PDOStatement->bindParam(":password", $this->cus_password);

            # execute
            $PDOStatement->execute();
        }
    }
    
    # delete the current object from the database
    public function deleteCustomer()
    {
        # call db connection
        global $connection;

        # create sql query
        $sql = "CALL customer_delete(:uuid)";

        # prepare the SQL query
        $PDOStatement = $connection->prepare($sql);

        # bind the parameters
        $PDOStatement->bindParam(":uuid", $this->cus_uuid);

        # execute the query
        $PDOStatement->execute();
    }
    
    public function login($username, $password)
    {
       # call db connection
       global $connection;
       
       # create sql query
       $sql = "CALL login(:username)";
       
       # prepare the SQL query
       $PDOStatement = $connection->prepare($sql);

       # bind the parameters
       $PDOStatement->bindParam(":username", $username);
       
       # execute the query
       $PDOStatement->execute();
       
       # if I get the result (if the username exists)
       if($row = $PDOStatement->fetch(PDO::FETCH_ASSOC))
       {
           # if the password is correct
           if(password_verify($password, $row["cus_password"])){
               $this->cus_uuid = $row["cus_uuid"];
               return true;
           }
       }
    }
}
    