
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chess Camp Registrations</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.4/xlsx.full.min.js"></script>
    <style>
        /* Add your custom styles here */
        table {
            font-size: 12px; /* Adjust the font size */
        }
        th, td {
            padding: 0.5rem; /* Reduce padding */
        }
        body {
            margin: 0;
            padding: 0;
        }
        .table-responsive {
            overflow-x: auto;
            width: 100%;
        }
        .table thead th {
            white-space: nowrap;
        }
        .export-btn {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <?php
    $dbHost = "localhost";
    $dbUsername = "mathmsllc_chess";
    $dbPassword = "BX,Z,gbfC!8D";
    $dbName = "mathmsllc_chess";

    // Database connection
    $conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve data from the database
    $sql = "SELECT * FROM ChessCampRegistrations";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
    ?>
        <h2 class="mb-4 text-center">Chess Camp Registrations</h2>

        <button class="btn btn-primary export-btn" onclick="exportToExcel()">Export to Excel</button>

        <div class="table-responsive">
            <table id="registrationTable" class="table table-bordered table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Camp Selection</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Age</th>
                        <th>USCF Rating</th>
                        <th>Parent's First Name</th>
                        <th>Parent's Last Name</th>
                        <th>Contact Phone</th>
                        <th>Email</th>

                        <th>Other Parent's First Name</th>
                        <th>Other Parent's Last Name</th>
                        <th>Alternate Phone</th>
                        <th>Alternate Email</th>
                        <th>General Knowledge</th>
                        <th>Instruction</th>
                        <th>Etiquette Rules</th>
                        <th>Played Tournaments</th>
                        <th>Special Moves</th>
                        <th>Notation</th>
                        <th>School/Chess Club</th>
                        <th>Plays with Family</th>
                        <th>Software/Books</th>
                        <th>Online Sites</th>
                         <th>Paid</th>
                        <th>Paid Date</th>
                        <th>Amount Paid</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . $row['camp_selection'] . "</td>";
                        echo "<td>" . $row['first_name'] . "</td>";
                        echo "<td>" . $row['last_name'] . "</td>";
                        echo "<td>" . $row['age'] . "</td>";
                        echo "<td>" . $row['uscf_rating'] . "</td>";
                        echo "<td>" . $row['parent_first_name'] . "</td>";
                        echo "<td>" . $row['parent_last_name'] . "</td>";
                        echo "<td>" . $row['contact_phone'] . "</td>";
                        echo "<td>" . $row['email'] . "</td>";

                        echo "<td>" . $row['other_parent_first_name'] . "</td>";
                        echo "<td>" . $row['other_parent_last_name'] . "</td>";
                        echo "<td>" . $row['alternate_phone'] . "</td>";
                        echo "<td>" . $row['alternate_email'] . "</td>";
                        echo "<td>" . $row['general_knowledge'] . "</td>";
                        echo "<td>" . $row['instruction'] . "</td>";
                        echo "<td>" . $row['etiquette_rules'] . "</td>";
                        echo "<td>" . $row['played_tournaments'] . "</td>";
                        echo "<td>" . $row['special_moves'] . "</td>";
                        echo "<td>" . $row['notation'] . "</td>";
                        echo "<td>" . $row['school_chess_club'] . "</td>";
                        echo "<td>" . $row['plays_with_family'] . "</td>";
                        echo "<td>" . $row['software_books'] . "</td>";
                        echo "<td>" . $row['online_sites'] . "</td>";
                        echo "<td>";
                        echo "<select onchange=\"updateField('" . $row['id'] . "', 'paid', this.value)\">";
                        echo "<option value='No' " . ($row['paid'] == 'No' ? 'selected' : '') . ">No</option>";
                        echo "<option value='Yes' " . ($row['paid'] == 'Yes' ? 'selected' : '') . ">Yes</option>";
                        echo "</select>";
                        echo "</td>";
                        echo "<td contenteditable='true' onBlur=\"updateField('" . $row['id'] . "', 'paid_date', this.innerText)\">" . ($row['paid_date'] ? $row['paid_date'] : 'No Data') . "</td>";
                        echo "<td contenteditable='true' onBlur=\"updateField('" . $row['id'] . "', 'amount_paid', this.innerText)\">" . ($row['amount_paid'] ? $row['amount_paid'] : 'No Data') . "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    <?php
    } else {
        echo "<h2 class='mb-4 text-center'>No records found.</h2>";
    }

    // Close connection
    $conn->close();
    ?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function updateField(id, field, value) {
            $.ajax({
                type: "POST",
                url: "update.php",
                data: { id: id, field: field, value: value },
                success: function(response) {
                    console.log(response);
                },
                error: function(error) {
                    console.error(error);
                }
            });
        }
    </script>
	

    <script>
        function exportToExcel() {
            /* Get table data */
            var wb = XLSX.utils.table_to_book(document.getElementById('registrationTable'), {sheet: 'Registrations'});
            
            /* Generate XLSX file */
            XLSX.writeFile(wb, 'registrations.xlsx');
        }
    </script>
</body>
</html>
