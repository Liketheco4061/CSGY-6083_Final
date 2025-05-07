<?php
include "dbconn.php";

$sql = "
SELECT s.SubjectID, s.InvestigationID, s.EmployeeID, s.Role, s.Notes,
       i.CaseNumber,
       emp.FirstName, emp.LastName
FROM subjects s
JOIN investigations i ON s.InvestigationID = i.InvestigationID
LEFT JOIN employees emp ON s.EmployeeID = emp.employeeID
ORDER BY i.CaseNumber ASC, s.Role
";

$result = $conn->query($sql);
$subjectsByCase = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $subjectsByCase[$row['CaseNumber']][] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Subjects by Case</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 30px;
            background-color: #f7f7f7;
        }
        h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }
        h2 {
            margin-top: 30px;
            color: #004a99;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 30px;
            background-color: white;
            table-layout: fixed;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ccc;
            word-wrap: break-word;
        }
        th {
            background-color: #004a99;
            color: white;
        }
        col:nth-child(1) { width: 40ch; }
        col:nth-child(2) { width: 30ch; }
        col:nth-child(3) { width: auto; }
        col:nth-child(4) { width: 20ch; }
        tr:nth-child(even) {
            background-color: #f1f1f1;
        }
        a.button {
            display: inline-block;
            padding: 6px 12px;
            margin-right: 5px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            font-size: 14px;
        }
        a.button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<h1>Subjects by Case</h1>

<?php if (count($subjectsByCase) > 0): ?>
    <?php foreach ($subjectsByCase as $caseNumber => $subjects): ?>
        <h2>Case: <?= htmlspecialchars($caseNumber) ?></h2>
        <table>
            <colgroup>
                <col style="width: 40ch;">
                <col style="width: 30ch;">
                <col style="width: auto;">
                <col style="width: 20ch;">
            </colgroup>
            <tr>
                <th>Subject Name</th>
                <th>Role</th>
                <th>Notes</th>
                <th>Actions</th>
            </tr>
            <?php foreach ($subjects as $s): ?>
                <tr>
                    <td><?= $s['FirstName'] ? htmlspecialchars("{$s['FirstName']} {$s['LastName']} ({$s['EmployeeID']})") : "Unknown Subject" ?></td>
                    <td><?= htmlspecialchars($s['Role']) ?></td>
                    <td><?= htmlspecialchars($s['Notes']) ?></td>
                    <td>
                        <a class="button" href="editsubject.php?id=<?= $s['SubjectID'] ?>">Edit</a>
                        <a class="button" href="deletesubject.php?id=<?= $s['SubjectID'] ?>" onclick="return confirm('Are you sure you want to delete this subject?');">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endforeach; ?>
<?php else: ?>
    <p>No subjects found.</p>
<?php endif; ?>

<a class="button" href="addsubject.php">Add Subject</a><br><br>
<a class="button" href="https://liketheco.io/final/investigations/investigationsindex.htm">← Back to Investigations</a><br><br>
<a class="button" href="https://liketheco.io/final/index.php">← Back to Main Menu</a>

</body>
</html>
