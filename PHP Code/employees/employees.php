<!DOCTYPE html>
<html>
<head>
    <title>Employee Database</title>
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
            padding: 8px 16px;
            text-decoration: none;
            border-radius: 4px;
            margin-right: 6px;
        }

        .btn:hover {
            background-color: #004a99;
        }

        .add-link {
            margin-top: 20px;
            display: inline-block;
        }
    </style>
</head>
<body>

<h1>Employee Database</h1>

<?php

header("Cache-Control: no-cache, must-revalidate");
header("Expires: Sat, 1 Jan 2000 00:00:00 GMT");

include "dbconn.php";

$sql = "
SELECT e.*, a.Street, a.City, a.State, a.ZipCode
FROM employees e
JOIN addresses a ON e.AddressID = a.AddressID
";
$result = $conn->query($sql);

echo "<table>
<tr>
    <th>ID</th>
    <th>First</th>
    <th>Last</th>
    <th>Birth Date</th>
    <th>SSN</th>
    <th>Gender</th>
    <th>Start Date</th>
    <th>Phone</th>
    <th>Address</th>
    <th>Department</th>
    <th>Type</th>
    <th>Status</th>
    <th>Shield #</th>
    <th>Actions</th>
</tr>";

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $formattedPhone = preg_replace("/(\d{3})(\d{3})(\d{4})/", "($1) $2-$3", $row["PhoneNumber"]);

        echo "<tr>
            <td>{$row['employeeID']}</td>
            <td>{$row['FirstName']}</td>
            <td>{$row['LastName']}</td>
            <td>{$row['BirthDate']}</td>
            <td>{$row['SSN']}</td>
            <td>{$row['Gender']}</td>
            <td>{$row['StartDate']}</td>
            <td>$formattedPhone</td>
            <td>{$row['Street']}, {$row['City']}, {$row['State']} {$row['ZipCode']}</td>
            <td>{$row['DepartmentID']}</td>
            <td>{$row['EmploymentType']}</td>
            <td>{$row['EmploymentStatus']}</td>
            <td>{$row['ShieldNumber']}</td>
            <td>
                <a class='btn' href='editemployee.php?employeeID={$row["employeeID"]}'>Edit</a>
                <a class='btn' href='delemployee.php?employeeID={$row["employeeID"]}'>Delete</a>
            </td>
        </tr>";
    }
} else {
    echo "<tr><td colspan='14'>No employees found.</td></tr>";
}

echo "</table>";
$conn->close();
?>

<br>
<a href='addemployee.php' class='btn add-link'>Add New Employee</a><br>
<a href='employeesindex.htm' class='btn add-link'>Back to Employees Index</a><br> <br>
<a href="https://liketheco.io/final/index.php" class="btn">Back to Main Index</a>


</body>
</html>
