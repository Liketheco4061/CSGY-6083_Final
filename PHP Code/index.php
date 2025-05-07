
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Employee and Case Tracker Dashboard</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            text-align: center;
            background-color: #f7f9fc;
        }

        h1 {
            margin-top: 50px;
            color: #2c3e50;
        }

        .button-container {
            margin-top: 30px;
        }

        .nav-button {
            display: block;
            width: 300px;
            margin: 10px auto;
            padding: 14px;
            background-color: #1f4e79;
            color: white;
            text-decoration: none;
            font-size: 16px;
            border-radius: 6px;
            border: none;
            transition: background-color 0.3s ease;
        }

        .nav-button:hover {
            background-color: #163d5c;
        }
    </style>
</head>
<body>

    <h1>InvestigatorDB Management</h1>

    <div class="button-container">
        <a href="employees/employeesindex.htm" class="nav-button">Employee Management</a>
        <a href="investigations/investigationsindex.htm" class="nav-button">Investigations Management</a>
        <a href="reports/reportsindex.htm" class="nav-button">Reports</a>
    </div>

</body>
</html>
