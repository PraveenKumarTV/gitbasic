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

// Check if the database exists, if not create it
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($sql) === TRUE) {
    // Database created or already exists
} else {
    die("Error creating database: " . $conn->error);
}

// Select the database
$conn->select_db($dbname);

// Handle the incoming AJAX request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the raw POST data (JSON format)
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    $rows = $data['rows']; // Excel data rows
    $tutor = $data['tutor']; // Selected tutor from the dropdown

    // Create table for the tutor if it doesn't exist
    $createTableSQL = "
        CREATE TABLE IF NOT EXISTS `$tutor` (
            id INT AUTO_INCREMENT PRIMARY KEY,
            student_name VARCHAR(255),
            student_id VARCHAR(100) UNIQUE,
            year_of_study VARCHAR(50),
            phone_number VARCHAR(15),
            tutor_name VARCHAR(100),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
    ";
    if ($conn->query($createTableSQL) !== TRUE) {
        die("Error creating table: " . $conn->error);
    }

    // Prepare the SQL query to insert data
    $stmt = $conn->prepare("INSERT INTO `$tutor` (student_name, student_id, year_of_study, phone_number, tutor_name) VALUES (?, ?, ?, ?, ?)");

    // Iterate over each row and insert the data into the database
    foreach ($rows as $row) {
        // Extract student data from each row
        $student_name = $row[0]; // Assuming the first column is the student name
        $student_id = $row[1];   // Assuming the second column is the student ID
        $year_of_study = $row[2]; // Assuming the third column is the year of study
        $phone_number = $row[3]; // Assuming the fourth column is the phone number

        // Check if the student already exists in the table (based on student_id)
        $checkSQL = "SELECT COUNT(*) FROM `$tutor` WHERE student_id = ?";
        $checkStmt = $conn->prepare($checkSQL);
        $checkStmt->bind_param("s", $student_id);
        $checkStmt->execute();
        $checkStmt->bind_result($count);
        $checkStmt->fetch();
        $checkStmt->close();

        // If the student doesn't exist, insert the new record
        if ($count == 0) {
            // Bind parameters and execute the statement
            $stmt->bind_param("sssss", $student_name, $student_id, $year_of_study, $phone_number, $tutor);
            $stmt->execute();
        } else {
            // Optionally log or print a message that the record already exists
            // echo "Record for student ID $student_id already exists.\n";
        }
    }

    // Close the statement
    $stmt->close();

    // Return success response
    echo 'Data inserted successfully';
} else {
    echo 'Invalid request';
}

// Close the database connection
$conn->close();
?>
