<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Progres Pengisian Profil Prodi UIN Sunan Gunung Djati Bandung</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .text-red {
            color: red;
        }
        .no-results {
            display: none;
            color: red;
            text-align: center;
            margin-top: 20px;
        }
        .table td, .table th {
            padding: 0.2rem;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Progres Pengisian Profil Program Studi</h2>
        <input class="form-control mb-4" id="tableSearch" type="text" placeholder="Search..">
        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="dataTable">
                <thead class="thead-dark">
                    <tr>
                        <!-- Baris header akan diisi secara dinamis -->
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // URL CSV dari Google Sheets
                    $csv_url = 'https://docs.google.com/spreadsheets/d/e/2PACX-1vRVGy6K2nSZHZQ_rLIWBU40aq92a3eSs7UTsDOv4zMSidz26-StIhM3ckg7s6YVxazR2kNi6ckkBTTb/pub?gid=1802657193&single=true&output=csv';

                    // Mengambil data CSV
                    $data = file_get_contents($csv_url);

                    // Memisahkan baris data
                    $rows = explode("\n", $data);

                    // Menampilkan data dalam tabel HTML
                    $firstRow = true;
                    foreach ($rows as $row) {
                        if (empty(trim($row))) continue; // Skip empty rows
                        $cells = str_getcsv($row);
                        if ($firstRow) {
                            echo '<tr>';
                            foreach ($cells as $cell) {
                                echo '<th>' . htmlspecialchars($cell) . '</th>';
                            }
                            echo '</tr>';
                            $firstRow = false;
                        } else {
                            $highlightClass = '';
                            $textRedClass = '';
                            foreach ($cells as $cell) {
                                if (stripos($cell, 'belum') !== false) {
                                    $highlightClass = 'highlight';
                                    $textRedClass = 'text-red';
                                    break;
                                }
                            }
                            echo '<tr class="' . $highlightClass . '">';
                            foreach ($cells as $cell) {
                                echo '<td class="' . $textRedClass . '">' . htmlspecialchars($cell) . '</td>';
                            }
                            echo '</tr>';
                        }
                    }
                    ?>
                </tbody>
            </table>
            <p class="no-results">No results found</p>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        // Script for table search functionality
        $(document).ready(function() {
            $("#tableSearch").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                var visible = false;
                $("#dataTable tbody tr").filter(function() {
                    var rowVisible = $(this).text().toLowerCase().indexOf(value) > -1;
                    $(this).toggle(rowVisible);
                    visible = visible || rowVisible;
                });
                $(".no-results").toggle(!visible);
            });
        });
    </script>
</body>
</html>
