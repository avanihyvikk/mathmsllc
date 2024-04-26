<?php include 'protect.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Activity Report Submissions</title>

    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- DataTables JavaScript -->
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

    <!-- DataTables Buttons CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">

    <!-- DataTables Buttons JavaScript -->
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>

<!-- DataTables Initialization Script -->
<script>
    $(document).ready(function() {
        var dataTable = $('#responsesTable').DataTable({
            ajax: 'responses1.php', // URL to fetch data from
            columns: [
                { data: 'location' },
                { data: 'question_text' },
                { data: 'answer' },
                {
                    data: 'submission_datetime',
                    render: function(data, type, row) {
                        // Format date using moment.js
                        return moment(data).format('MM/DD/YYYY HH:mm:ss');
                    }
                }
            ],
            order: [[3, 'desc']], // Set default sorting to Submission Date in descending order
            paging: true, // Enable pagination
            searching: true, // Disable search box
            lengthMenu: [10, 25, 50, 100], // Set the page length options
            pageLength: 50, // Initial number of rows per page
            columnDefs: [
                { orderable: false, targets: [0, 1, 2, 3] } // Disable sorting on all columns
            ],
            dom: 'Bfrtip', // Add buttons to the DOM
            buttons: [
                {
                    extend: 'excelHtml5',
                    text: 'Export to Excel',
                    className: 'btn-excel',
                    exportOptions: {
                        columns: [0, 1, 2, 3]
                    }
                }
            ]
        });

        // Add individual column search boxes
        $('#responsesTable thead tr').clone(true).appendTo('#responsesTable thead');
        $('#responsesTable thead tr:eq(1) th').each(function (i) {
            var title = $(this).text();
            $(this).html('<input type="text" class="form-control" placeholder="Search ' + title + '" />');

            $('input', this).on('keyup change', function () {
                if (dataTable.column(i).search() !== this.value) {
                    dataTable
                        .column(i)
                        .search(this.value)
                        .draw();
                }
            });
        });
    });
</script>


    <!-- Custom Styles -->
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }

        .header {
            background-color: #343a40;
            color: #ffffff;
            padding: 20px;
            text-align: center;
            margin-bottom: 30px;
        }

        .container {
            width: 80%;
            margin: auto;
            overflow: hidden;
        }

        .responses-container {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        #responsesTable {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        #responsesTable th,
        #responsesTable td {
            border: 1px solid #dee2e6;
            padding: 12px;
            text-align: left;
            font-size: 14px; /* Adjust the font size as needed */
        }

        #responsesTable th {
            background-color: #343a40;
            color: #ffffff;
            font-weight: bold;
        }

        #responsesTable tbody tr:hover {
            background-color: #f8f9fa;
        }

        /* Styles for search boxes */
        #responsesTable_filter input {
            border: 1px solid #ced4da;
            border-radius: 4px;
            padding: 10px;
            margin-bottom: 10px;
            width: 100%; /* Full width */
            box-sizing: border-box;
            font-size: 14px; /* Adjust the font size as needed */
        }

        /* Style for Excel export button */
        .btn-excel {
            background-color: #28a745;
            color: #ffffff;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Daily Activity Report Submissions</h1>
    </div>

    <div class="container">
        <div class="responses-container">
            <table id="responsesTable" class="display">
                <thead>
                    <tr>
                        <th>Location</th>
                        <th>Question</th>
                        <th>Answer</th>
                        <th>Submission Date</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</body>
</html>
