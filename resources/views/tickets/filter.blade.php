<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DataTable with API</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">DataTable with API</h2>
        <button id="updateButton" class="btn btn-primary mb-4">Update Data</button>
        <table id="example" class="display" style="width:100%">
            <thead>
                <tr>
                    <th>Column 1</th>
                    <th>Column 2</th>
                    <th>Column 3</th>
                </tr>
            </thead>
            <tbody>
                <!-- Data will be populated here -->
            </tbody>
        </table>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- Bootstrap JS -->
    
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <!-- Custom JS to fetch data and initialize DataTable -->
    <script>
        $(document).ready(function() {
            // Initialize DataTable
            var table = $('#example').DataTable();

            // Function to get today's date in YYYY-MM-DD format
            function getTodayDate() {
                var today = new Date();
                var dd = String(today.getDate()).padStart(2, '0');
                var mm = String(today.getMonth() + 1).padStart(2, '0'); // January is 0!
                var yyyy = today.getFullYear();
                return yyyy + '-' + mm + '-' + dd;
            }

            // Function to fetch data from API and update DataTable
            function updateData() {
                var todayDate = getTodayDate();
                var apiUrl = 'https://microsoftedge.github.io/Demos/json-dummy-data/64KB.json?date=' + todayDate; // Replace with your API URL

                $.ajax({
                    url: apiUrl,
                    method: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        // Clear existing data
                        table.clear();

                        // Add new data
                        table.rows.add(data);

                        // Draw the table with new data
                        table.draw();
                    },
                    error: function(error) {
                        console.log('Error fetching data:', error);
                    }
                });
            }

            // Set up event listener for the update button
            $('#updateButton').on('click', function() {
                updateData();
            });

            // Fetch data initially
            updateData();
        });
    </script>
</body>
</html>
