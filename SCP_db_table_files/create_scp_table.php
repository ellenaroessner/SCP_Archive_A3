<?php

include 'credentials.php';

$conn = new mysqli('localhost', $user, $pw, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "CREATE TABLE IF NOT EXISTS scp_entries (
    id              INT AUTO_INCREMENT PRIMARY KEY,
    subject         VARCHAR(255)    NOT NULL,
    item            VARCHAR(50)     NOT NULL,
    class           VARCHAR(100)    NOT NULL,
    image           VARCHAR(500),
    description     TEXT            NOT NULL,
    containment     TEXT            NOT NULL
)";

if ($conn->query($sql) === TRUE) {
    echo "Table 'scp_entries' created successfully.";
} else {
    echo "Error creating table: " . $conn->error;
}

$conn->close();

?>