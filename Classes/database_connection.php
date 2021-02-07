<?php

# Revision History
# DEVELOPER                     DATE            COMMENTS
#
# Keon Woo Park (1831319)       2020-04-20      Created database_connection.php file
#
# Keon Woo Park (1831319)       2020-04-30      Debug and check
#
#



define("_SQL_HOST", "localhost");
define("_DB_NAME", "plant_heaven");
define("_USERNAME", "1831319");
define("_PASSWORD", "123");


# create connection on the server
$connection = new PDO("mysql:host=" . _SQL_HOST ."; dbname=" . _DB_NAME, _USERNAME, _PASSWORD);

# configure POD handle all problems as EXCEPTIONS
$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

