<?php
// PHP code to fetch table names for the dropdown
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "excel_upload";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all table names from the database
$tableQuery = "SHOW TABLES";
$result = $conn->query($tableQuery);

// Prepare an array to store table names
$tableNames = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_row()) {
        $tableNames[] = $row[0]; // Get the first column which is the table name
}
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Student Data</title>
    <style>
        /* Basic reset for margins and paddings */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fc;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        h1 {
            font-size: 2em;
            margin-bottom: 20px;
            color: #0056b3;
        }

        .form-container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
        }

        label {
            font-size: 1.1em;
            margin-bottom: 5px;
            display: block;
            color: #555;
        }

        input, select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1em;
            color: #333;
        }

        input[type="submit"] {
            background-color: #0056b3;
            color: #fff;
            border: none;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #004080;
        }

        select {
            font-size: 1em;
        }

        .form-container input, .form-container select {
            transition: border 0.3s ease;
        }

        .form-container input:focus, .form-container select:focus {
            border-color: #0056b3;
            outline: none;
        }

        .form-container input[type="text"]:invalid {
            border-color: red;
        }

        .form-container input[type="text"]:valid {
            border-color: green;
        }

        /* Optional: Add a simple footer */
        footer {
            position: fixed;
            bottom: 10px;
            width: 100%;
            text-align: center;
            color: #aaa;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h1>Student Data Upload</h1>

        <!-- Form to input student details and select a tutor -->
        <form id="student-form" method="POST" action="insert_student.php">
            <label for="tutor">Select Tutor:</label>
            <select name="tutor" id="tutor" required>
                <option value="">--Select Tutor--</option>
                <?php foreach ($tableNames as $tableName): ?>
                    <option value="<?= htmlspecialchars($tableName) ?>"><?= htmlspecialchars($tableName) ?></option>
                <?php endforeach; ?>
            </select><br><br>

            <label for="student_name">Student Name:</label>
            <input type="text" id="student_name" name="student_name" required><br><br>

            <label for="student_id">Student ID:</label>
            <input type="text" id="student_id" name="student_id" required><br><br>

            <label for="year_of_study">Year of Study:</label>
            <input type="text" id="year_of_study" name="year_of_study" required><br><br>

            <label for="phone_number">Phone Number:</label>
            <input type="text" id="phone_number" name="phone_number" required><br><br>

            <input type="submit" value="Add Student">
        </form>
    </div>

    <!-- Optional footer -->
    <footer>
        <p>&copy; 2024 Your Company. All Rights Reserved.</p>
    </footer>
</body>
</html>
