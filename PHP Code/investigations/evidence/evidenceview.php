<?php
include "dbconn.php";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Evidence Report</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 40px; background-color: #f4f4f4; }
        h1 { margin-bottom: 30px; color: #333; }
        table { border-collapse: collapse; width: 100%; background-color: #fff; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }
        th { background-color: #0066cc; color: white; }
        tr:nth-child(even) { background-color: #f9f9f9; }
    </style>
</head>
<body>
    <h1>Evidence Report</h1>

    <table>
        <tr>
            <th>Evidence ID</th>
            <th>Case Number</th>
            <th>Type</th>
            <th>Description</th>
            <th>Date Collected</th>
            <th>Date Invoiced</th>
            <th>Collected By</th>
        </tr>

        <?php
        $result = $conn->query("SELECT * FROM evidenceview");

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                    <td>{$row['evidenceID']}</td>
                    <td>{$row['CaseNumber']}</td>
                    <td>{$row['EvidenceType']}</td>
                    <td>{$row['Description']}</td>
                    <td>{$row['DateCollected']}</td>
                    <td>{$row['DateInvoiced']}</td>
                    <td>{$row['CollectedByID']} - {$row['CollectedByName']}</td>
                </tr>";
            }
        } else {
            echo "<tr><td colspan='7'>No evidence records found.</td></tr>";
        }

        $conn->close();
        ?>
    </table>
</body>
</html>
