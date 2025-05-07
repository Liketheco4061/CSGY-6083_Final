<!DOCTYPE html>
<html>
<head>
    <title>Employees by Department</title>
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

        .btn {
            display: inline-block;
            background-color: #0066cc;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
            font-size: 16px;
        }

        .btn:hover {
            background-color: #004a99;
        }
    </style>
</head>
<body>

<h1>Employees by Department</h1>

<?php
include "dbconn.php";

$sql = "SELECT d.DepartmentID, d.DepartmentName, COUNT(e.EmployeeID) AS TotalEmployees
        FROM departments d
        LEFT JOIN employees e ON d.DepartmentID = e.DepartmentID
        GROUP BY d.DepartmentID, d.DepartmentName
        ORDER BY d.DepartmentID";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table>
            <tr>
                <th>Department ID</th>
                <th>Department Name</th>
                <th>Total Employees</th>
            </tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['DepartmentID']}</td>
                <td>{$row['DepartmentName']}</td>
                <td>{$row['TotalEmployees']}</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "<p>No data found.</p>";
}

$conn->close();
?>

<a href="reportsindex.htm" class="btn">Back to Reports</a>

</body>
</html>
