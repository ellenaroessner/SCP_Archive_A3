<?php

include 'credentials.php';

$conn = new mysqli('localhost', $user, $pw, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$tables = $conn->query("SHOW TABLES");

if ($tables->num_rows === 0) {
    echo "No tables found in the database.";
    $conn->close();
    exit;
}

while ($tableRow = $tables->fetch_array()) {
    $tableName = $tableRow[0];

    echo "=================================<br>";
    echo "Table: " . $tableName . "<br>";
    echo "=================================<br>";

    $fields = $conn->query("DESCRIBE `$tableName`");

    while ($field = $fields->fetch_assoc()) {
        echo "  Field:   " . $field['Field'] . "<br>";
        echo "  Type:    " . $field['Type'] . "<br>";
        echo "  Null:    " . $field['Null'] . "<br>";
        echo "  Key:     " . $field['Key'] . "<br>";
        echo "  Default: " . ($field['Default'] ?? 'NULL') . "<br>";
        echo "  Extra:   " . $field['Extra'] . "<br>";
        echo "---------------------------------<br>";
    }

    echo "<br>";
}

$conn->close();
