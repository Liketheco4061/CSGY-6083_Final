<?php
include "dbconn.php";

$sql = "SELECT * FROM subjectauditlogview ORDER BY ActionTime DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Subject Audit Log</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; padding: 40px; }
        h1 { color: #333; margin-bottom: 30px; }
        table {
            border-collapse: collapse;
            width: 100%;
            background-color: #fff;
            font-size: 14px;
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
        tr:nth-child(even) { background-color: #f2f2f2; }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #0066cc;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 4px;
            text-decoration: none;
        }
        .btn:hover {
            background-color: #004a99;
        }
    </style>
</head>
<body>

<h1>Subject Audit Log</h1>

<?php if ($result && $result->num_rows > 0): ?>
    <table>
        <tr>
            <th>Log ID</th>
            <th>Case Number</th>
            <th>Employee</th>
            <th>Role</th>
            <th>Notes</th>
            <th>Action</th>
            <th>Timestamp</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($row['LogID']) ?></td>
            <td><?= htmlspecialchars($row['CaseNumber']) ?></td>
            <td><?= htmlspecialchars($row['EmployeeName']) ?></td>
            <td><?= htmlspecialchars($row['Role']) ?></td>
            <td><?= nl2br(htmlspecialchars($row['Notes'])) ?></td>
            <td><?= htmlspecialchars($row['ActionTaken']) ?></td>
            <td><?= htmlspecialchars($row['ActionTime']) ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
<?php else: ?>
    <p>No subject audit records found.</p>
<?php endif; ?>

<br>
<a href="subjects.php" class="btn">← Back to Subjects</a>

</body>
</html>
