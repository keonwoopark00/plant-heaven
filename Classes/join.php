<?php

# join class to get the joined value from database
#
# Revision History
# DEVELOPER                     DATE            COMMENTS
#
# Keon Woo Park (1831319)       2020-04-20      Created join.php file
#
# Keon Woo Park (1831319)       2020-04-30      Debug and check
#
#


class join{
    # members from the joined select that are not contained in table purchase 
    private $pro_code = "";
    private $cus_firstname = "";
    private $cus_lastname = "";
    private $cus_city = "";

    public function __construct($pcode, $firstname, $lastname, $city){
        $this->pro_code = $pcode;
        $this->cus_firstname = $firstname;
        $this->cus_lastname = $lastname;
        $this->cus_city = $city;
    }
    
    public function getProCode(){
        return $this->pro_code;
    }

    public function getCusFirstname(){
        return $this->cus_firstname;
    }

    public function getCusLastname(){
        return $this->cus_lastname;
    }

    public function getCusCity(){
        return $this->cus_city;
    }
}