<!DOCTYPE html>
<html>
<head>
    <title>Evidence List</title>
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

<h1>Evidence List</h1>

<?php
include 'dbconn.php';

$sql = "SELECT * FROM evidence";
$result = $conn->query($sql);

echo "<table>
<tr>
    <th>ID</th>
    <th>Investigation ID</th>
    <th>Type</th>
    <th>Description</th>
    <th>Date Collected</th>
    <th>Date Invoiced</th>
    <th>Collected By</th>
    <th>Actions</th>
</tr>";

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
            <td>{$row['evidenceID']}</td>
            <td>{$row['InvestigationID']}</td>
            <td>{$row['EvidenceType']}</td>
            <td>{$row['Description']}</td>
            <td>{$row['DateCollected']}</td>
            <td>{$row['DateInvoiced']}</td>
            <td>{$row['CollectedBy']}</td>
            <td>
                <a class='btn' href='editevidence.php?evidenceID={$row["evidenceID"]}'>Edit</a>
                <a class='btn' href='delevidence.php?id={$row["evidenceID"]}' onclick=\"return confirm('Are you sure you want to delete this evidence item?')\">Delete</a>
            </td>
        </tr>";
    }
} else {
    echo "<tr><td colspan='8'>No evidence records found.</td></tr>";
}

echo "</table>";
$conn->close();
?>

<br>
<a href='addevidence.php' class='btn add-link'>Add New Evidence</a><br>
<a href='https://liketheco.io/final/investigations/investigations.php' class='btn add-link'>Back to Investigations</a><br><br>
<a href='https://liketheco.io/final/index.php' class='btn'>Back to Main Index</a>

</body>
</html>
