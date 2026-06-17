<?php

    include "credentials.php";
    
    // Create an object of the mysqli class (this enables connection to a sql database)
    $connection = new mysqli("localhost", $user, $pw, $db);

    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }
        
    // Select all records from our table scp_entries
    $records = $connection->prepare("SELECT * FROM scp_entries");
        
    // Run the command
    $records->execute();
        
    // Save the results into a variable
    $result = $records->get_result();

?>

