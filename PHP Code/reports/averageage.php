<?php
include "dbconn.php";

$sql = "SELECT * FROM average_age_by_department";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Average Employee Age by Department</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 40px; }
        h1 { color: #333; margin-bottom: 30px; }
        table { width: 60%; border-collapse: collapse; background-color: #fff; }
        th, td { padding: 12px; border: 1px solid #ccc; text-align: center; }
        th { background-color: #004a99; color: white; }
        tr:nth-child(even) { background-color: #f2f2f2; }
        .btn {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #0066cc;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }
        .btn:hover { background-color: #004a99; }
    </style>
</head>
<body>

<h1>Average Employee Age by Department</h1>

<table>
    <tr>
        <th>Department</th>
        <th>Average Age</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?= htmlspecialchars($row['DepartmentName']) ?></td>
        <td><?= htmlspecialchars($row['AverageAge']) ?></td>
    </tr>
    <?php endwhile; ?>
</table>

<a href="reportsindex.htm" class="btn">Back to Reports</a>
<a href="https://liketheco.io/final/index.php" class="btn">Main Menu</a>

</body>
</html>
