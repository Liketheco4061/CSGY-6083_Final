<?php
include "dbconn.php";

$sql = "SELECT * FROM employee_log ORDER BY action_time DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Employee Log</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            padding: 40px;
        }

        h2 {
            color: #333;
            margin-bottom: 30px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            background-color: #fff;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ccc;
        }

        th {
            background-color: #004a99;
            color: white;
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

<h2>Employee Log</h2>

<?php
if ($result->num_rows > 0) {
    echo "<table>
            <tr>
                <th>Log ID</th>
                <th>Employee Name</th>
                <th>Action</th>
                <th>Timestamp</th>
            </tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['log_id']}</td>
                <td>{$row['employee_name']}</td>
                <td>{$row['action']}</td>
                <td>{$row['action_time']}</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "<p class='message'>No log entries found.</p>";
}

$conn->close();
?>

<br>
<a href="employeesindex.htm" class="back-btn">Back to Employees Index</a><br> <br>
<a href="https://liketheco.io/final/index.php" class="back-btn">Back to Main Index</a>

</body>
</html>
