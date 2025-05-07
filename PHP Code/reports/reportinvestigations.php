<?php 
include "dbconn.php";

$sql = "SELECT * FROM InvestigatorActivity";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Investigator Activity Report</title>
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

<h1>Investigator Activity Report (Department 010)</h1>

<?php
if ($result->num_rows > 0) {
    echo "<table>";
    echo "<tr><th>Investigator</th><th>Total Investigations</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['InvestigatorName']) . "</td>";
        echo "<td>" . htmlspecialchars($row['TotalInvestigations']) . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p>No investigators found in Department 010.</p>";
}
$conn->close();
?>

<br>
<a href="index.php" class="btn">Back to Reports</a>

</body>
</html>
