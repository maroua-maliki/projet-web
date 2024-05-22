<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Liste des Étudiants</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: sans-serif;
        }

        @media print {
            .table,
            .table__body {
                overflow: visible;
                height: auto !important;
                width: auto !important;
            }
        }

        body {
            min-height: 100vh;
            background: url(images/html_table.jpg) center / cover;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        main.table {
            width: 82vw;
            height: 90vh;
            background-color: #fff5;
            backdrop-filter: blur(7px);
            box-shadow: 0 .4rem .8rem #0005;
            border-radius: .8rem;
            overflow: hidden;
        }

        .table__header {
            width: 100%;
            height: 10%;
            background-color: #fff4;
            padding: .8rem 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .table__header .input-group {
            width: 35%;
            height: 100%;
            background-color: #fff5;
            padding: 0 .8rem;
            border-radius: 2rem;
            display: flex;
            justify-content: center;
            align-items: center;
            transition: .2s;
        }

        .table__header .input-group:hover {
            width: 45%;
            background-color: #fff8;
            box-shadow: 0 .1rem .4rem #0002;
        }

        .table__header .input-group input {
            width: 100%;
            padding: 0 .5rem 0 .3rem;
            background-color: transparent;
            border: none;
            outline: none;
        }

        .table__body {
            width: 95%;
            max-height: calc(89% - 1.6rem);
            background-color: #fffb;
            margin: .8rem auto;
            border-radius: .6rem;
            overflow: auto;
            overflow: overlay;
        }

        .table__body::-webkit-scrollbar {
            width: 0.5rem;
            height: 0.5rem;
        }

        .table__body::-webkit-scrollbar-thumb {
            border-radius: .5rem;
            background-color: #0004;
            visibility: hidden;
        }

        .table__body:hover::-webkit-scrollbar-thumb {
            visibility: visible;
        }

        table {
            width: 100%;
        }

        td img {
            width: 36px;
            height: 36px;
            margin-right: .5rem;
            border-radius: 50%;
            vertical-align: middle;
        }

        table,
        th,
        td {
            border-collapse: collapse;
            padding: 1rem;
            text-align: left;
        }

        thead th {
            position: sticky;
            top: 0;
            left: 0;
            background-color: #d5d1defe;
            cursor: pointer;
            text-transform: capitalize;
        }

        tbody tr:nth-child(even) {
            background-color: #0000000b;
        }

        tbody tr {
            --delay: .1s;
            transition: .5s ease-in-out var(--delay), background-color 0s;
        }

        tbody tr.hide {
            opacity: 0;
            transform: translateX(100%);
        }

        tbody tr:hover {
            background-color: #fff6 !important;
        }

        tbody tr td,
        tbody tr td p,
        tbody tr td img {
            transition: .2s ease-in-out;
        }

        tbody tr.hide td,
        tbody tr.hide td p {
            padding: 0;
            font: 0 / 0 sans-serif;
            transition: .2s ease-in-out .5s;
        }

        tbody tr.hide td img {
            width: 0;
            height: 0;
            transition: .2s ease-in-out .5s;
        }

        .status {
            padding: .4rem 0;
            border-radius: 2rem;
            text-align: center;
        }

        @media (max-width: 1000px) {
            td:not(:first-of-type) {
                min-width: 12.1rem;
            }
        }

        thead th:hover {
            color: #6c00bd;
        }

        thead th.active,
        tbody td.active {
            color: #6c00bd;
        }

        .export__file {
            position: relative;
        }

        .export__file .export__file-btn {
            display: inline-block;
            width: 2rem;
            height: 2rem;
            background: #fff6 url(images/export.png) center / 80% no-repeat;
            border-radius: 50%;
            transition: .2s ease-in-out;
        }

        .export__file .export__file-btn:hover {
            background-color: #fff;
            transform: scale(1.15);
            cursor: pointer;
        }

        .export__file input {
            display: none;
        }

        .export__file .export__file-options {
            position: absolute;
            right: 0;
            width: 12rem;
            border-radius: .5rem;
            overflow: hidden;
            text-align: center;
            opacity: 0;
            transform: scale(.8);
            transform-origin: top right;
            box-shadow: 0 .2rem .5rem #0004;
            transition: .2s;
        }

        .export__file input:checked+.export__file-options {
            opacity: 1;
            transform: scale(1);
            z-index: 100;
        }

        .export__file .export__file-options label {
            display: block;
            width: 100%;
            padding: .6rem 0;
            background-color: #f2f2f2;
            display: flex;
            justify-content: space-around;
            align-items: center;
            transition: .2s ease-in-out;
        }

        .export__file .export__file-options label:first-of-type {
            padding: 1rem 0;
            background-color: #86e49d !important;
        }

        .export__file .export__file-options label:hover {
            transform: scale(1.05);
            background-color: #fff;
            cursor: pointer;
        }

        .export__file .export__file-options img {
            width: 2rem;
            height: auto;
        }
    </style>
</head>

<body>
    <main class="table" id="customers_table">
        <section class="table__header">
            <br>
            <h4>Liste Des Etudiants</h4>
            <div class="input-group">
                <input type="search" placeholder="Search Data..." id="search">
            </div>
            <div class="export__file">
                <label for="export-file" class="export__file-btn" title="Export File"></label>
                <input type="checkbox" id="export-file">
                <div class="export__file-options">
                    <label>Export As </label>
                    <label for="export-file" id="toPDF">PDF <img src="images/pdf.png" alt=""></label>
                    <label for="export-file" id="toCSV">CSV <img src="images/csv.png" alt=""></label>
                </div>
            </div>
        </section>
        <section class="table__body">
            <?php
            include("../connect.php");

            if (isset($_GET['module_id'])) {
                $module_id = $_GET['module_id'];

                // Fetch the level associated with the module
                $module_query = "SELECT niveau_id FROM module WHERE id = ?";
                $stmt = $con->prepare($module_query);
                $stmt->bind_param('i', $module_id);
                $stmt->execute();
                $module_result = $stmt->get_result();
                $module = $module_result->fetch_assoc();
                $niveau_id = $module['niveau_id'];

                // Fetch students enrolled in the level
                $students_query = "
                    SELECT u.id, u.nom, u.prenom, u.email, u.CNE, n.note
                    FROM utilisateur u
                    LEFT JOIN note n ON u.id = n.etudiant_id AND n.module_id = ?
                    WHERE u.role = 'etudiant' AND u.niveau = ?
                    ORDER BY u.nom ASC
                ";
                $stmt = $con->prepare($students_query);
                $stmt->bind_param('ii', $module_id, $niveau_id);
                $stmt->execute();
                $students_result = $stmt->get_result();

                echo '<form action="save_notes.php" method="POST">';
                echo '<table>';
                echo '<thead>';
                echo '<tr>';
                echo '<th scope="col">CNE</th>';
                echo '<th scope="col">Nom</th>';
                echo '<th scope="col">Prénom</th>';
                echo '<th scope="col">Email</th>';
                echo '<th scope="col">Note</th>';
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';
                while ($row = $students_result->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($row["CNE"]) . '</td>';
                    echo '<td>' . htmlspecialchars($row["nom"]) . '</td>';
                    echo '<td>' . htmlspecialchars($row["prenom"]) . '</td>';
                    echo '<td>' . htmlspecialchars($row["email"]) . '</td>';
                    echo '<td><input type="text" name="notes[' . htmlspecialchars($row["id"]) . ']" class="status delivered" value="' . htmlspecialchars($row["note"]) . '"></td>';
                    echo '</tr>';
                }
                echo '</tbody>';
                echo '</table>';
                echo '<button type="submit" name="action" value="sauvegarde" class="btn btn-success">Sauvegarder</button>';
                echo '<button type="submit" name="action" value="ajouter" class="btn btn-danger">Terminer</button>';
                echo '</form>';
            }
            ?>
        </section>
    </main>
    <script>
        const search = document.querySelector('.input-group input'),
            table_rows = document.querySelectorAll('tbody tr');

        search.addEventListener('input', searchTable);

        function searchTable() {
            table_rows.forEach((row, i) => {
                let table_data = row.textContent.toLowerCase(),
                    search_data = search.value.toLowerCase();

                row.classList.toggle('hide', table_data.indexOf(search_data) < 0);
                row.style.setProperty('--delay', i / 25 + 's');
            })

            document.querySelectorAll('tbody tr:not(.hide)').forEach((visible_row, i) => {
                visible_row.style.backgroundColor = (i % 2 == 0) ? 'transparent' : '#0000000b';
            });
        }

        const pdf_btn = document.querySelector('#toPDF');
        const customers_table = document.querySelector('#customers_table');

        const toPDF = function (customers_table) {
            const html_code = `
            <!DOCTYPE html>
            <link rel="stylesheet" type="text/css" href="style.css">
            <main class="table" id="customers_table">${customers_table.innerHTML}</main>`;

            const new_window = window.open();
            new_window.document.write(html_code);

            setTimeout(() => {
                new_window.print();
                new_window.close();
            }, 400);
        }

        pdf_btn.onclick = () => {
            toPDF(customers_table);
        }

        const csv_btn = document.querySelector('#toCSV');

        const toCSV = function (table) {
            const t_heads = table.querySelectorAll('th'),
                tbody_rows = table.querySelectorAll('tbody tr');

            const headings = [...t_heads].map(head => {
                let actual_head = head.textContent.trim().split(' ');
                return actual_head.splice(0, actual_head.length - 1).join(' ').toLowerCase();
            }).join(',');

            const table_data = [...tbody_rows].map(row => {
                const cells = row.querySelectorAll('td'),
                    data = [...cells].map(cell => cell.textContent.replace(/,/g, ".").trim()).join(',');

                return data;
            }).join('\n');

            return headings + '\n' + table_data;
        }

        csv_btn.onclick = () => {
            const csv = toCSV(customers_table);
            downloadFile(csv, 'csv', 'etudiants_notes');
        }

        function downloadFile(data, fileType, fileName) {
            const blob = new Blob([data], { type: fileType });
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.style.display = 'none';
            a.href = url;
            a.download = fileName;
            document.body.appendChild(a);
            a.click();
            window.URL.revokeObjectURL(url);
        }
    </script>
</body>

</html>
