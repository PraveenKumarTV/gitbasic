<?php
$servername = "localhost";
$username = "root";   // Default XAMPP MySQL username
$password = "";       // Default XAMPP MySQL password is empty
$dbname = "excel_upload";  // The name of the database

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize search variables
$tutor = "";
$student_name = "";
$year_of_study = "";

// Form submission check
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tutor = isset($_POST['tutorSelect']) ? $_POST['tutorSelect'] : '';
    $student_name = isset($_POST['student_name']) ? $_POST['student_name'] : '';
    $year_of_study = isset($_POST['year_of_study']) ? $_POST['year_of_study'] : '';

    // Query to get all tables in the database
    $tables = [];
    $result = $conn->query("SHOW TABLES");
    while ($row = $result->fetch_row()) {
        $tables[] = $row[0]; // Add table name to array
    }

    // Build the SQL query dynamically
    $sql = "";
    $conditions = [];

    // Add search conditions based on user input
    if ($student_name) {
        $conditions[] = "student_name LIKE '%" . $conn->real_escape_string($student_name) . "%'";
    }

    if ($year_of_study) {
        $conditions[] = "year_of_study LIKE '%" . $conn->real_escape_string($year_of_study) . "%'";
    }

    if ($tutor) {
        $conditions[] = "tutor_name LIKE '%" . $conn->real_escape_string($tutor) . "%'";
    }

    // If any conditions are specified, apply them to the query
    if (count($conditions) > 0) {
        $sql .= " WHERE " . implode(" AND ", $conditions); // Use AND to ensure all conditions are met
    }

    // Prepare the query for each table
    $results = [];
    foreach ($tables as $table) {
        $query = "SELECT * FROM `$table`" . $sql; // Searching in each table with the constructed conditions
        $res = $conn->query($query);

        if ($res && $res->num_rows > 0) {
            // If results found, append to the final results array
            while ($row = $res->fetch_assoc()) {
                $row['table'] = $table; // Add the table name to the result row
                $results[] = $row;
            }
        }
    }
} else {
    $results = null; // No results yet
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Student Data</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7f6;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #2c3e50;
        }
        form {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        label {
            font-weight: bold;
            color: #34495e;
        }
        input, select {
            padding: 8px;
            font-size: 16px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }
        button {
            padding: 10px;
            background-color: #3498db;
            color: white;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #2980b9;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        table th {
            background-color: #f2f2f2;
        }
        .message {
            text-align: center;
            font-size: 16px;
            color: #2ecc71;
            font-weight: bold;
            margin-top: 20px;
        }
        .error-message {
            text-align: center;
            font-size: 16px;
            color: #e74c3c;
            font-weight: bold;
            margin-top: 20px;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Search Student Data</h2>
        
        <form method="POST" action="">
            <label for="tutorSelect">Tutor Name (optional):</label>
            <input type="text" id="tutorSelect" name="tutorSelect" value="<?php echo htmlspecialchars($tutor); ?>" />

            <label for="student_name">Student Name (optional):</label>
            <input type="text" id="student_name" name="student_name" value="<?php echo htmlspecialchars($student_name); ?>" />
            
            <label for="year_of_study">Year of Study (optional):</label>
            <input type="text" id="year_of_study" name="year_of_study" value="<?php echo htmlspecialchars($year_of_study); ?>" />

            <button type="submit">Search</button>
        </form>

        <?php if ($results !== null): ?>
            <?php if (count($results) > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Table</th>
                            <th>ID</th>
                            <th>Student Name</th>
                            <th>Student ID</th>
                            <th>Year of Study</th>
                            <th>Phone Number</th>
                            <th>Tutor Name</th>
                            <th>Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($results as $row): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['table']); ?></td>
                                <td><?php echo htmlspecialchars($row['id']); ?></td>
                                <td><?php echo htmlspecialchars($row['student_name']); ?></td>
                                <td><?php echo htmlspecialchars($row['student_id']); ?></td>
                                <td><?php echo htmlspecialchars($row['year_of_study']); ?></td>
                                <td><?php echo htmlspecialchars($row['phone_number']); ?></td>
                                <td><?php echo htmlspecialchars($row['tutor_name']); ?></td>
                                <td><?php echo $row['created_at']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="error-message">No records found matching your criteria.</div>
            <?php endif; ?>
        <?php endif; ?>
    </div>

</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
