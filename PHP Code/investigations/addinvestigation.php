<?php
include "dbconn.php";

$investigators = [];
$sql = "SELECT employeeID, FirstName, LastName FROM employees WHERE DepartmentID = '010'";
$result = $conn->query($sql);
while ($row = $result->fetch_assoc()) {
    $investigators[] = $row;
}

$subjects = [];
$subResult = $conn->query("SELECT employeeID, FirstName, LastName FROM employees ORDER BY LastName ASC");
while ($emp = $subResult->fetch_assoc()) {
    $subjects[] = $emp;
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add New Investigation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 30px;
            background-color: #f9f9f9;
        }
        h1, h3 {
            margin-bottom: 15px;
        }
        .form-group {
            margin-bottom: 18px;
        }
        label {
            display: block;
            font-weight: bold;
            margin-bottom: 6px;
        }
        input[type="date"],
        select,
        textarea {
            width: 300px;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        textarea {
            resize: vertical;
        }
        .btn {
            padding: 10px 16px;
            background-color: #0066cc;
            color: white;
            border: none;
            border-radius: 5px;
            margin-top: 10px;
            margin-right: 10px;
            cursor: pointer;
        }
        .btn:hover {
            background-color: #004a99;
        }
        .subject-box {
            border: 1px solid #ccc;
            padding: 12px;
            margin-bottom: 20px;
            background-color: #fff;
            border-radius: 4px;
        }
    </style>
    <script>
    function validateForm() {
        const investigator = document.getElementById('investigator').value;
        const subjectFields = document.querySelectorAll('[name="subject[]"]');
        const roleFields = document.querySelectorAll('[name="role[]"]');

        for (let i = 0; i < subjectFields.length; i++) {
            const subject = subjectFields[i].value;
            const role = roleFields[i].value;

            if (subject !== "" && investigator === subject) {
                alert("The Investigator cannot also be listed as a Subject.");
                return false;
            }

            if (subject === "" && role === "") {
                subjectFields[i].closest(".subject-box").remove();
            }
        }
        return true;
    }

    function addSubjectFields() {
        const container = document.getElementById('subjects-container');
        const subjectHTML = `
            <div class="subject-box">
                <label>Subject:</label>
                <select name="subject[]">
                    <option value="">-- Unknown Subject --</option>
                    ${document.getElementById('subject-template').innerHTML}
                </select>

                <label>Role:</label>
                <select name="role[]">
                    <option value="">-- Select Role --</option>
                    <option value="Suspect">Suspect</option>
                    <option value="Witness">Witness</option>
                    <option value="Victim">Victim</option>
                    <option value="Complainant">Complainant</option>
                    <option value="Person of Interest">Person of Interest</option>
                </select>

                <label>Notes:</label>
                <textarea name="notes[]" rows="2"></textarea>

                <button type="button" class="btn" style="background-color:#d9534f;" onclick="this.closest('.subject-box').remove()">🗑 Remove Subject</button>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', subjectHTML);
    }
    </script>
</head>
<body>

<h1>Add New Investigation</h1>

<form action="submitinvestigation.php" method="POST" onsubmit="return validateForm()">
    <div class="form-group">
        <label for="startDate">Start Date:</label>
        <input type="date" id="startDate" name="startDate" required>
    </div>

    <div class="form-group">
        <label for="investigator">Assigned Investigator:</label>
        <select id="investigator" name="investigator" required>
            <option value="">-- Select Investigator --</option>
            <?php foreach ($investigators as $inv): ?>
                <option value="<?= $inv['employeeID'] ?>">
                    <?= $inv['employeeID'] ?> - <?= htmlspecialchars($inv['FirstName'] . ' ' . $inv['LastName']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <h3>Subject Information (Optional)</h3>
    <div id="subjects-container">
        <div class="subject-box">
            <label>Subject:</label>
            <select name="subject[]">
                <option value="">-- Unknown Subject --</option>
                <?php foreach ($subjects as $sub): ?>
                    <option value="<?= $sub['employeeID'] ?>">
                        <?= $sub['employeeID'] ?> - <?= htmlspecialchars($sub['FirstName'] . ' ' . $sub['LastName']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label>Role:</label>
            <select name="role[]">
                <option value="">-- Select Role --</option>
                <option value="Suspect">Suspect</option>
                <option value="Witness">Witness</option>
                <option value="Victim">Victim</option>
                <option value="Complainant">Complainant</option>
                <option value="Person of Interest">Person of Interest</option>
            </select>

            <label>Notes:</label>
            <textarea name="notes[]" rows="2"></textarea>

            <br><button type="button" class="btn" style="background-color:#d9534f;" onclick="this.closest('.subject-box').remove()">🗑 Remove Subject</button>
        </div>
    </div>

    <div class="form-group">
        <label for="allegation">Primary Allegation:</label>
        <select name="allegation" id="allegation" required>
            <option value="" disabled selected>-- Select Allegation --</option>
            <option value="Bribery">Bribery</option>
            <option value="Contraband">Contraband</option>
            <option value="False Filings">False Filings</option>
            <option value="Fraud">Fraud</option>
            <option value="Overtime Abuse">Overtime Abuse</option>
            <option value="Theft of Services">Theft of Services</option>
            <option value="Use of Force">Use of Force</option>
            <option value="Other">Other</option>
        </select>
    </div>

    <div id="subject-template" style="display:none">
        <?php foreach ($subjects as $sub): ?>
            <option value="<?= $sub['employeeID'] ?>">
                <?= $sub['employeeID'] ?> - <?= htmlspecialchars($sub['FirstName'] . ' ' . $sub['LastName']) ?>
            </option>
        <?php endforeach; ?>
    </div>

    <button type="button" class="btn" onclick="addSubjectFields()">➕ Add Another Subject</button>
    <br><br>
    <button type="submit" name="add" class="btn">✔ Add Investigation</button>
    <button type="button" class="btn" onclick="window.location.href='investigations.php'">Cancel</button>
</form>

</body>
</html>
