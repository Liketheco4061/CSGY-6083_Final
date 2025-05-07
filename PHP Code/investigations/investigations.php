<?php
include "dbconn.php";

$sql = "
SELECT i.InvestigationID, i.CaseNumber, i.StartDate, i.EndDate, i.CaseStatus,
       i.Disposition, i.DispositionDate, i.PrimaryAllegation,
       e.FirstName AS InvFirst, e.LastName AS InvLast
FROM investigations i
JOIN employees e ON i.employees_employeeID = e.employeeID
ORDER BY i.CaseNumber ASC
";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Investigations</title>
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
            vertical-align: top;
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

        td a {
            color: #0066cc;
            text-decoration: none;
            margin-right: 8px;
        }

        td a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<h1>Investigations</h1>

<?php
if ($result->num_rows > 0) {
    echo "<table>
            <tr>
                <th>Case Number</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Status</th>
                <th>Primary Allegation</th>
                <th>Investigator</th>
                <th>Subjects</th>
                <th>Disposition</th>
                <th>Disposition Date</th>
                <th>Actions</th>
            </tr>";

    while ($row = $result->fetch_assoc()) {
        $investigationID = $row['InvestigationID'];

        
        $subSql = "
        SELECT s.EmployeeID, s.Role, emp.FirstName, emp.LastName
        FROM subjects s
        LEFT JOIN employees emp ON s.EmployeeID = emp.employeeID
        WHERE s.InvestigationID = $investigationID
        ";
        $subjectsResult = $conn->query($subSql);

        $subjectsList = "";
        if ($subjectsResult && $subjectsResult->num_rows > 0) {
            while ($s = $subjectsResult->fetch_assoc()) {
                $subjectName = $s['FirstName'] ? $s['FirstName'] . ' ' . $s['LastName'] : "Unknown Subject";
                $role = !empty($s['Role']) ? $s['Role'] : "None";
                $subjectsList .= "{$subjectName} ({$role})<br>";
            }
        } else {
            $subjectsList = "None Assigned";
        }

        echo "<tr>
                <td>{$row['CaseNumber']}</td>
                <td>{$row['StartDate']}</td>
                <td>{$row['EndDate']}</td>
                <td>{$row['CaseStatus']}</td>
                <td>{$row['PrimaryAllegation']}</td>
                <td>{$row['InvFirst']} {$row['InvLast']}</td>
                <td>{$subjectsList}</td>
                <td>{$row['Disposition']}</td>
                <td>{$row['DispositionDate']}</td>
                <td>
                    <a href='editinvestigation.php?investigationID={$investigationID}'>Edit</a>
                    <a href='delinvestigation.php?id={$investigationID}' onclick=\"return confirm('Are you sure you want to delete this investigation?');\">Delete</a>
                </td>
            </tr>";
    }

    echo "</table>";
} else {
    echo "<p>No investigations found.</p>";
}
$conn->close();
?>

<a href="addinvestigation.php" class="btn">Add New Investigation</a> <br>
<a href="investigationsindex.htm" class="btn">Back to Investigation Index</a> <br>
<a href="https://liketheco.io/final/index.php" class="btn">Back to Main Index</a>

</body>
</html>
