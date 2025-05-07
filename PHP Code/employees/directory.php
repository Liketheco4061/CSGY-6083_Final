<?php
include "dbconn.php";

$result = $conn->query("SELECT * FROM EmployeeDirectory");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Employee Directory</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            padding: 40px;
        }

        h1 {
            color: #333;
            margin-bottom: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ccc;
        }

        th {
            background-color: #004a99;
            color: #fff;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .message {
            font-size: 16px;
            color: #555;
        }

        .back-btn {
            display: inline-block;
            margin-top: 20px;
            background-color: #0066cc;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 4px;
        }

        .back-btn:hover {
            background-color: #004a99;
        }
    </style>
</head>
<body>

<h1>Employee Directory</h1>

<?php
if ($result->num_rows > 0) {
    echo "<table>
            <tr>
                <th>Employee ID</th>
                <th>Full Name</th>
                <th>Age</th>
                <th>Phone Number</th>
                <th>Employment Type</th>
                <th>Shield Number</th>
                <th>Gender</th>
            </tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['employeeID']}</td>
                <td>{$row['FullName']}</td>
                <td>{$row['Age']}</td>
                <td>{$row['PhoneNumber']}</td>
                <td>{$row['EmploymentType']}</td>
                <td>{$row['ShieldNumber']}</td>
                <td>{$row['Gender']}</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "<p class='message'>No employees found.</p>";
}
$conn->close();
?>

<br>
<div class="button-group">
    <a href="employees.php" class="back-btn">Back to Employees Index</a><br> <br>
    <a href="https://liketheco.io/final/index.php" class="back-btn">Back to Main Index</a>
</div>
</body>
</html>
