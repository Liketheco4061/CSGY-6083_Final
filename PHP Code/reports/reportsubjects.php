<?php
include "dbconn.php";

$sql = "SELECT * FROM SubjectEmployeeSummary";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Employees Listed as Subjects</title>
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
            border-collapse: collapse;
            width: 100%;
            background-color: #fff;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #0066cc;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .btn {
            display: inline-block;
            background-color: #0066cc;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }

        .btn:hover {
            background-color: #004a99;
        }
    </style>
</head>
<body>

<h1>Employees Listed as Subjects</h1>

<?php
if ($result->num_rows > 0) {
    echo "<table>";
    echo "<tr><th>Employee</th><th>Times Listed</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['EmployeeName']) . "</td>";
        echo "<td>" . htmlspecialchars($row['TimesListedAsSubject']) . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p>No employees have been listed as subjects.</p>";
}
$conn->close();
?>

<br>
<a href="reportsindex.htm" class="btn">Back to Reports</a>

</body>
</html>
