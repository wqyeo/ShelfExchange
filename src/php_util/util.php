<?php

/**
 * Create a database connection with the given config file path.
 * @param String $dbConfigFilePath Configuration path containing 'servername', 'username', 'password' and 'dbname'. Should be located in the server.
 *
* Returns the database connection
*/

function createDatabaseConnection()
{
    $config = parse_ini_file('../../private/db-config.ini');
    return new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);
}

function getCurrentDate()
{
    date_default_timezone_set('Asia/Singapore');
    return date('Y-m-d');
}


?>
