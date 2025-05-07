<?php
include "dbconn.php";


$sql = "SELECT * FROM investigationauditlog ORDER BY UpdatedAt DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Investigation Audit Log</title>
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
            background-color: #004a99;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        pre {
            white-space: pre-wrap;
            word-wrap: break-word;
            margin: 0;
        }

        .message {
            font-size: 16px;
            color: #555;
        }

        .back-btn {
            display: inline-block;
            margin-top: 20px;
            background-color: #0066cc;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 4px;
        }

        .back-btn:hover {
            background-color: #004a99;
        }
    </style>
</head>
<body>

<h2>Investigation Audit Log</h2>

<?php if ($result && $result->num_rows > 0): ?>
    <table>
        <thead>
            <tr>
                <th>Log ID</th>
                <th>Investigation ID</th>
                <th>Case Number</th>
                <th>Investigator ID</th>
                <th>Values Changed</th>
                <th>Updated At</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['LogID']) ?></td>
                    <td><?= htmlspecialchars($row['InvestigationID']) ?></td>
                    <td><?= htmlspecialchars($row['CaseNumber']) ?></td>
                    <td><?= htmlspecialchars($row['InvestigatorID']) ?></td>
                    <td><pre><?= htmlspecialchars($row['ValuesChanged']) ?></pre></td>
                    <td><?= htmlspecialchars($row['UpdatedAt']) ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
<?php else: ?>
    <p class="message">No audit entries found.</p>
<?php endif; ?>

<a href="indexinvestigations.php" class="back-btn">Back to Investigations</a><br><br>
<a href="https://liketheco.io/final/index.php" class="back-btn">Back to Main Index</a>

</body>
</html>
