<?php include 'dbconn.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Evidence</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; padding: 40px; }
        h1 { color: #333; margin-bottom: 30px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; }
        input, select, textarea {
            width: 100%; padding: 8px;
        }
        input[type="submit"] {
            padding: 10px 20px; background-color: #0066cc; color: white;
            border: none; cursor: pointer; border-radius: 4px;
        }
        input[type="submit"]:hover { background-color: #004a99; }
    </style>
</head>
<body>
<h1>Add Evidence</h1>

<form method='POST' action='submitevidence.php'>
    <div class='form-group'>
        <label>Investigation:</label>
        <select name='InvestigationID' required>
            <option value="" disabled selected>Select Investigation</option>
            <?php
            $res = $conn->query("SELECT InvestigationID, CaseNumber FROM investigations");
            while ($row = $res->fetch_assoc()) {
                echo "<option value='{$row['InvestigationID']}'>[{$row['InvestigationID']}] {$row['CaseNumber']}</option>";
            }
            ?>
        </select>
    </div>

    <div class='form-group'>
        <label>Evidence Type:</label>
        <select name='EvidenceType' required>
            <option value='Digital'>Digital</option>
            <option value='Physical'>Physical</option>
            <option value='Documents'>Documents</option>
            <option value='Other'>Other</option>
        </select>
    </div>

    <div class='form-group'>
        <label>Description:</label>
        <textarea name='Description' required></textarea>
    </div>

    <div class='form-group'>
        <label>Date Collected:</label>
        <input type='date' name='DateCollected' required>
    </div>

    <div class='form-group'>
        <label>Date Invoiced:</label>
        <input type='date' name='DateInvoiced'>
    </div>

    <div class='form-group'>
        <label>Collected By:</label>
        <select name='CollectedBy' required>
            <option value="" disabled selected>Select Employee</option>
            <?php
            $emp = $conn->query("SELECT employeeID, FirstName, LastName FROM employees ORDER BY LastName");
            while ($e = $emp->fetch_assoc()) {
                echo "<option value='{$e['employeeID']}'>[{$e['employeeID']}] {$e['FirstName']} {$e['LastName']}</option>";
            }
            ?>
        </select>
    </div>

    <input type='submit' value='Add Evidence'>
</form>

</body>
</html>
