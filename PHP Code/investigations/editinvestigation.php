<?php
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

include "dbconn.php";

if (!isset($_GET['investigationID'])) {
    echo "Invalid investigation ID.";
    exit();
}
$investigationID = intval($_GET['investigationID']);

$invQuery = $conn->prepare("SELECT * FROM investigations WHERE InvestigationID = ?");
$invQuery->bind_param("i", $investigationID);
$invQuery->execute();
$invResult = $invQuery->get_result();
$investigation = $invResult->fetch_assoc();
if (!$investigation) {
    echo "Investigation not found.";
    exit();
}

$investigators = $conn->query("SELECT employeeID, FirstName, LastName FROM employees WHERE DepartmentID = '010' ORDER BY LastName");

$subjectQuery = $conn->prepare("
    SELECT s.SubjectID, s.EmployeeID, s.Role, s.Notes, e.FirstName, e.LastName 
    FROM subjects s 
    LEFT JOIN employees e ON s.EmployeeID = e.EmployeeID
    WHERE s.InvestigationID = ?");
$subjectQuery->bind_param("i", $investigationID);
$subjectQuery->execute();
$subjectResult = $subjectQuery->get_result();
$subjects = [];
while ($row = $subjectResult->fetch_assoc()) {
    $subjects[] = $row;
}

$allEmployees = $conn->query("SELECT employeeID, FirstName, LastName FROM employees ORDER BY LastName");
$employeesList = [];
while ($emp = $allEmployees->fetch_assoc()) {
    $employeesList[] = $emp;
}

$allegations = ["Bribery", "Contraband", "False Filings", "Fraud", "Overtime Abuse", "Theft of Services", "Use of Force", "Other"];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Investigation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 30px;
            background-color: #f4f4f4;
        }

        h2, h3 {
            color: #333;
        }

        form {
            background: white;
            padding: 20px;
            border-radius: 6px;
            max-width: 700px;
        }

        input[type="text"], input[type="date"], select, textarea {
            width: 100%;
            padding: 8px;
            margin: 6px 0 12px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        textarea {
            resize: vertical;
        }

        button {
            background-color: #007bff;
            color: white;
            padding: 10px 14px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 10px;
        }

        button:hover {
            background-color: #0056b3;
        }

        .subject-block {
            margin-bottom: 20px;
            padding: 10px;
            background: #f9f9f9;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .subject-block hr {
            border: none;
            border-top: 1px solid #ccc;
        }
    </style>
</head>
<body>

<h2>Editing Case: <?= htmlspecialchars($investigation['CaseNumber']) ?></h2>

<form method="post" action="submitinvestigation.php">
    <input type="hidden" name="investigationID" value="<?= $investigationID ?>">

    Start Date: <input type="date" name="startDate" value="<?= $investigation['StartDate'] ?>"><br>
    End Date: <input type="date" name="endDate" id="endDate" value="<?= $investigation['EndDate'] ?>"><br>

    Case Status:
    <select name="caseStatus" id="caseStatus">
        <option value="Open" <?= $investigation['CaseStatus'] == "Open" ? "selected" : "" ?>>Open</option>
        <option value="Closed" <?= $investigation['CaseStatus'] == "Closed" ? "selected" : "" ?>>Closed</option>
    </select><br>

    Assigned Investigator:
    <select name="assignedInvestigator" required>
        <option value="">-- Select Investigator --</option>
        <?php while ($row = $investigators->fetch_assoc()): ?>
            <option value="<?= $row['employeeID'] ?>" <?= $row['employeeID'] == $investigation['employees_employeeID'] ? "selected" : "" ?>>
                <?= $row['employeeID'] . " - " . $row['FirstName'] . " " . $row['LastName'] ?>
            </option>
        <?php endwhile; ?>
    </select><br>

    Primary Allegation:
    <select name="primaryAllegation" required>
        <option value="" disabled <?= empty($investigation['PrimaryAllegation']) ? 'selected' : '' ?>>-- Select Allegation --</option>
        <?php foreach ($allegations as $a): ?>
            <option value="<?= $a ?>" <?= $a == $investigation['PrimaryAllegation'] ? "selected" : "" ?>><?= $a ?></option>
        <?php endforeach; ?>
    </select><br>

    Disposition:
    <select name="disposition" id="dispositionSelect">
        <option value="">-- Select Disposition --</option>
        <option value="Substantiated" <?= $investigation['Disposition'] == 'Substantiated' ? 'selected' : '' ?>>Substantiated</option>
        <option value="Unsubstantiated" <?= $investigation['Disposition'] == 'Unsubstantiated' ? 'selected' : '' ?>>Unsubstantiated</option>
        <option value="Dismissed" <?= $investigation['Disposition'] == 'Dismissed' ? 'selected' : '' ?>>Dismissed</option>
    </select><br>

    Disposition Date:
    <input type="date" name="dispositionDate" id="dispositionDate" value="<?= $investigation['DispositionDate'] ?>"><br>

    <h3>Subjects</h3>
    <?php foreach ($subjects as $i => $subject): ?>
        <div class="subject-block">
            Subject #<?= $i + 1 ?> (<?= htmlspecialchars($subject['FirstName'] . " " . $subject['LastName']) ?>):<br>
            <input type="hidden" name="existingSubjects[<?= $subject['SubjectID'] ?>][subjectID]" value="<?= $subject['SubjectID'] ?>">
            Role:
            <select name="existingSubjects[<?= $subject['SubjectID'] ?>][role]">
                <?php foreach (["Suspect", "Victim", "Witness", "Complainant", "Person of Interest"] as $role): ?>
                    <option value="<?= $role ?>" <?= $subject['Role'] == $role ? "selected" : "" ?>><?= $role ?></option>
                <?php endforeach; ?>
            </select><br>
            Notes:<br>
            <textarea name="existingSubjects[<?= $subject['SubjectID'] ?>][notes]" rows="2"><?= htmlspecialchars($subject['Notes']) ?></textarea><br>
            Remove? <input type="checkbox" name="existingSubjects[<?= $subject['SubjectID'] ?>][remove]"><br>
        </div>
    <?php endforeach; ?>

    <div id="newSubjects"></div>
    <button type="button" onclick="addSubject()">+ Add New Subject</button><br><br>

    <input type="submit" value="Update Investigation">
    <a href="investigations.php"><button type="button">Cancel</button></a>
</form>

<!-- Template for dropdown -->
<div id="subject-template" style="display: none;">
    <select name="newSubjects[{{index}}][employeeID]" required>
        <option value="">-- Select Employee --</option>
        <?php foreach ($employeesList as $emp): ?>
            <option value="<?= $emp['employeeID'] ?>">
                <?= $emp['employeeID'] ?> - <?= htmlspecialchars($emp['FirstName'] . ' ' . $emp['LastName']) ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>

<script>
let subjectCount = 0;

function addSubject() {
    let template = document.getElementById("subject-template").innerHTML.replace(/{{index}}/g, subjectCount);
    let html = `
    <div class="subject-block">
        <strong>New Subject:</strong><br>
        Employee: ${template}
        <br>Role:
        <select name="newSubjects[${subjectCount}][role]" required>
            <option value="Suspect">Suspect</option>
            <option value="Victim">Victim</option>
            <option value="Witness">Witness</option>
            <option value="Complainant">Complainant</option>
            <option value="Person of Interest">Person of Interest</option>
        </select><br>
        Notes:<br>
        <textarea name="newSubjects[${subjectCount}][notes]" rows="2"></textarea>
    </div>`;
    document.getElementById("newSubjects").insertAdjacentHTML("beforeend", html);
    subjectCount++;
}

function toggleDispositionFields() {
    const status = document.getElementById("caseStatus").value;
    const disposition = document.getElementById("dispositionSelect");
    const dispoDate = document.getElementById("dispositionDate");
    if (status === "Closed") {
        disposition.disabled = false;
        dispoDate.disabled = false;
        if (dispoDate.value === "") {
            let now = new Date().toISOString().split('T')[0];
            dispoDate.value = now;
        }
    } else {
        disposition.disabled = true;
        dispoDate.disabled = true;
        dispoDate.value = "";
    }
    document.getElementById("endDate").readOnly = (status === "Open");
    if (status === "Open") document.getElementById("endDate").value = "";
}

window.onload = function () {
    toggleDispositionFields();
    document.getElementById("caseStatus").addEventListener("change", toggleDispositionFields);
};
</script>

</body>
</html>
