<?php
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Sat, 1 Jan 2000 00:00:00 GMT");

include "dbconn.php";

$sql = "
SELECT 
    a.AddressID, a.Street, a.City, a.State, a.ZipCode,
    CONCAT(e.FirstName, ' ', e.LastName) AS EmployeeName
FROM addresses a
INNER JOIN employees e ON a.AddressID = e.AddressID
ORDER BY a.AddressID
";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Assigned Addresses</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 30px;
            background-color: #f7f7f7;
        }
        h1 {
            color: #004a99;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            word-wrap: break-word;
        }
        th {
            background-color: #004a99;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f1f1f1;
        }
        .button {
            background-color: #0066cc;
            color: white;
            padding: 6px 12px;
            text-decoration: none;
            border: none;
            border-radius: 4px;
            margin-right: 5px;
            cursor: pointer;
        }
        .button:hover {
            background-color: #004a99;
        }
    </style>
</head>
<body>

<h1>Assigned Address List</h1>

<table>
    <tr>
        <th>Address ID</th>
        <th>Street</th>
        <th>City</th>
        <th>State</th>
        <th>Zip Code</th>
        <th>Employee</th>
        <th>Actions</th>
    </tr>

    <?php if ($result->num_rows > 0): ?>
        <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['AddressID']) ?></td>
                <td><?= htmlspecialchars($row['Street']) ?></td>
                <td><?= htmlspecialchars($row['City']) ?></td>
                <td><?= htmlspecialchars($row['State']) ?></td>
                <td><?= htmlspecialchars($row['ZipCode']) ?></td>
                <td><?= htmlspecialchars($row['EmployeeName']) ?></td>
                <td>
                    <a class="button" href="editaddress.php?addressID=<?= $row['AddressID'] ?>">Edit</a>
                    <a class="button" href="deladdress.php?id=<?= $row['AddressID'] ?>" onclick="return confirm('Are you sure you want to delete this address?')">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr><td colspan="7">No assigned addresses found.</td></tr>
    <?php endif; ?>
</table>

<br>
<a class="button" href="addaddress.php">Add New Address</a><br> <br>
<a class="button" href="employeesindex.htm">Return to Employees</a><br> <br>
<a class="button" href="https://liketheco.io/final/index.php">Return to Main</a><br> <br>


</body>
</html>
