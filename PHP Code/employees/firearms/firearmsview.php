<?php
include "dbconn.php";

$sql = "SELECT f.*, e.employeeID 
        FROM firearmView f
        JOIN employees e ON CONCAT(e.FirstName, ' ', e.LastName) = f.EmployeeName";
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

        h2 {
            color: #333;
            margin-bottom: 30px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            background-color: #fff;
            font-size: 14px;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ccc;
            vertical-align: top;
        }

        th {
            background-color: #003366;
            color: #fff;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        a {
            color: #003366;
            text-decoration: none;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<h2>Firearm Assignments</h2>

<table>
    <tr>
        <th>Officer</th>
        <th>Make</th>
        <th>Model</th>
        <th>Serial Number</th>
        <th>Date Added</th>
        <th>Qualification Date</th>
        <th>Status</th>
    </tr>

    <?php
    while ($row = $result->fetch_assoc()) {
        $employeeName = htmlspecialchars($row['EmployeeName']);
        $employeeID = $row['employeeID'];
        echo "<tr>
                <td><a href='https://liketheco.io/final/employees/viewemployee.php?id={$employeeID}'>$employeeName</a></td>
                <td>{$row['Make']}</td>
                <td>{$row['Model']}</td>
                <td>{$row['SerialNumber']}</td>
                <td>{$row['DateAdded']}</td>
                <td>{$row['QualificationDate']}</td>
                <td>{$row['Status']}</td>
              </tr>";
    }
    ?>

</table>

</body>
</html>

<?php $conn->close(); ?>
