<?php
include "dbconn.php";

$sql = "SELECT f.*, CONCAT(e.FirstName, ' ', e.LastName) AS OfficerName
        FROM firearms f
        JOIN employees e ON f.EmployeeID = e.employeeID
        WHERE e.EmploymentType = 'Uniform'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Firearm Assignments</title>
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
            padding: 8px 14px;
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

<h1>Firearm Assignments</h1>

<table>
    <tr>
        <th>Officer</th>
        <th>Make</th>
        <th>Model</th>
        <th>Serial Number</th>
        <th>Date Added</th>
        <th>Qualification Date</th>
        <th>Status</th>
        <th>Actions</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()) { ?>
    <tr>
        <td><?= htmlspecialchars($row['OfficerName']) ?></td>
        <td><?= htmlspecialchars($row['Make']) ?></td>
        <td><?= htmlspecialchars($row['Model']) ?></td>
        <td><?= htmlspecialchars($row['SerialNumber']) ?></td>
        <td><?= $row['DateAdded'] ?></td>
        <td><?= $row['QualificationDate'] ?></td>
        <td><?= $row['Status'] ?></td>
        <td>
            <a class="btn" href="editfirearm.php?id=<?= $row['firearmID'] ?>">Edit</a>
            <a class="btn" href="delfirearm.php?id=<?= $row['firearmID'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
        </td>
    </tr>
    <?php } ?>
</table>

<br>
<a href="addfirearm.php" class="btn add-link">Add New Firearm</a><br> <br>
<a href="https://liketheco.io/final/employees/employeesindex.htm" class="btn">Back to Employees Index</a><br> <br>
<a href="https://liketheco.io/final/index.php" class="btn">Back to Main Index</a>


</body>
</html>
