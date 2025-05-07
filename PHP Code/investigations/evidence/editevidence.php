<?php

header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include "dbconn.php";

if (!isset($_GET['evidenceID'])) {
    die("Error: evidenceID not provided.");
}

$evidenceID = intval($_GET['evidenceID']);

$query = $conn->prepare("SELECT * FROM evidence WHERE evidenceID = ?");
$query->bind_param("i", $evidenceID);
$query->execute();
$result = $query->get_result();
$evidence = $result->fetch_assoc();
if (!$evidence) {
    die("Error: Evidence not found.");
}


$employees = $conn->query("SELECT employeeID, FirstName, LastName FROM employees ORDER BY LastName");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Evidence</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            padding: 40px;
        }

        h2 {
            color: #333;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-top: 10px;
            font-weight: bold;
        }

        input, select, textarea {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            font-size: 14px;
        }

        input[type="submit"], .btn {
            display: inline-block;
            background-color: #0066cc;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border: none;
            border-radius: 4px;
            margin-top: 20px;
            margin-right: 10px;
            cursor: pointer;
        }

        input[type="submit"]:hover, .btn:hover {
            background-color: #004a99;
        }
    </style>
</head>
<body>

<h2>Edit Evidence Record</h2>

<form method="post" action="updateevidence.php">
    <input type="hidden" name="evidenceID" value="<?= $evidenceID ?>">

    <label>Investigation ID:</label>
    <input type="number" name="InvestigationID" value="<?= htmlspecialchars($evidence['InvestigationID']) ?>" required>

    <label>Evidence Type:</label>
    <select name="EvidenceType" required>
        <?php
        $types = ["Physical", "Digital", "Document", "Biological", "Other"];
        foreach ($types as $type) {
            $selected = ($type == $evidence['EvidenceType']) ? 'selected' : '';
            echo "<option value=\"$type\" $selected>$type</option>";
        }
        ?>
    </select>

    <label>Description:</label>
    <textarea name="Description" rows="4"><?= htmlspecialchars($evidence['Description']) ?></textarea>

    <label>Date Collected:</label>
    <input type="date" name="DateCollected" value="<?= $evidence['DateCollected'] ?>">

    <label>Date Invoiced:</label>
    <input type="date" name="DateInvoiced" value="<?= $evidence['DateInvoiced'] ?>">

    <label>Collected By:</label>
    <select name="CollectedBy" required>
        <option value="">-- Select Employee --</option>
        <?php while ($row = $employees->fetch_assoc()):
            $selected = ($row['employeeID'] == $evidence['CollectedBy']) ? 'selected' : '';
            $label = $row['employeeID'] . " - " . $row['FirstName'] . " " . $row['LastName'];
        ?>
            <option value="<?= $row['employeeID'] ?>" <?= $selected ?>><?= $label ?></option>
        <?php endwhile; ?>
    </select>

    <input type="submit" value="Update Evidence">
    <a href="evidence.php" class="btn">Cancel</a>
</form>

</body>
</html>
