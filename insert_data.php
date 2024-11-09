<?php
$servername = "localhost";
$username = "root";   // Default XAMPP MySQL username
$password = "";       // Default XAMPP MySQL password is empty
$dbname = "excel_upload";  // The name of the database

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Step 1: Create the database if it does not exist
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($sql) === TRUE) {
    echo "Database created or already exists\n";
} else {
    die("Error creating database: " . $conn->error);
}

// Switch to the created database
$conn->select_db($dbname);

// Step 2: Create the table if it does not exist
$table_sql = "CREATE TABLE IF NOT EXISTS excel_data (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    column1 VARCHAR(255),
    column2 VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($table_sql) === TRUE) {
    echo "Table 'excel_data' created or already exists\n";
} else {
    die("Error creating table: " . $conn->error);
}

// Step 3: Read data sent from the client (via POST request)
$data = json_decode(file_get_contents('php://input'), true);

// Step 4: Prepare an SQL statement to insert data
if (isset($data['rows'])) {
    $stmt = $conn->prepare("INSERT INTO excel_data (column1, column2) VALUES (?, ?)");
    $stmt->bind_param("ss", $column1, $column2);

    foreach ($data['rows'] as $row) {
        // Bind each row's values
        $column1 = $row[0];
        $column2 = $row[1];
        
        // Execute the query for each row
        if (!$stmt->execute()) {
            echo "Error: " . $stmt->error;
        }
    }

    echo "Data inserted successfully!";
} else {
    echo "No data received.";
}

// Close the connection
$stmt->close();
$conn->close();
?>
