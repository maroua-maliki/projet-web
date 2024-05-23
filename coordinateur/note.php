<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (isset($_SESSION['id'])) {
    $prof_id = $_SESSION['id'];
} else {
    header("Location: ../login.php");
    exit;
}

include("../connect.php");

$success_message = "";
$error_message = "";
include($_SERVER['DOCUMENT_ROOT'] . '/ENSAHify/Database.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST["action"])) {
        $data = array();
        $id_module = $_POST['module_id'];
        $qr = mysqli_query($con, "SELECT n.*
                                FROM note n
                                WHERE n.module_id = '$id_module'
                                and n.action = 'ajouter'; ");
        while ($row = mysqli_fetch_assoc($qr)) {
            array_push($data, $row);
        }

        foreach ($data as $d) {
            $update_query = "UPDATE note SET action = 'terminer' WHERE module_id = '$id_module'";
            mysqli_query($con, $update_query);
        }

        $_SESSION['message'] = "1";
    } else {
        $_SESSION['message'][] = "0";
    }
}

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
        SELECT u.id, u.nom, u.prenom, u.CNE, n.note ,n.etudiant_id ,n.action AS action
        FROM utilisateur u
        LEFT JOIN note n ON u.id = n.etudiant_id AND n.module_id = ?
        WHERE u.role = 'etudiant' AND u.niveau = ? 
        ORDER BY u.nom ASC
    ";
    $stmt = $con->prepare($students_query);
    $stmt->bind_param('ii', $module_id, $niveau_id);
    $stmt->execute();
    $students_result = $stmt->get_result();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../../bootstrap/bootstrap-5.3.3-dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Liste des Étudiants</title>
    <style>
        h2 {
            text-align: center;
        }
        .table-container {
            border: 2px solid #ffffff; /* White border for the table */
            border-radius: 8px; /* Rounded corners */
            padding: 20px; /* Padding around the table */
            background-color: #f8f9fa; /* Light background color */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Light shadow */
        }
        a.module-link {
            color: #007bff; /* Blue color for links */
            text-decoration: none; /* No underline */
        }
        a.module-link:hover {
            text-decoration: underline; /* Underline on hover */
        }
        .fixed-width {
            width: 20%; /* Adjust the width as needed */
        }
        .student-group-form{
            border: 2px solid #ffffff; /* White border for the table */
            border-radius: 8px; /* Rounded corners */
            padding: 20px; /* Padding around the table */
            background-color: #f8f9fa; /* Light background color */
            box-shadow: 0 0
        }
    </style>
</head>
<body>
<?php
include("sidebar.php");
include("../navbar/navbar.php");
?>
<div class="container mt-4">
    <div class="table-container">
        <h2>Notes des Étudiants</h2>
        <br> <br>
        <?php if (!empty($success_message)): ?>
            <div class="alert alert-success">
                <?php echo $success_message; ?>
            </div>
        <?php endif; ?>
        <?php if (!empty($error_message)): ?>
            <div class="alert alert-danger">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>

        <div class="student-group-form">
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="form-group">
                        <input type="text" class="form-control" id="myInputCNE" onkeyup="myFunction()" placeholder="Search by CNE...">
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="form-group">
                        <input type="text" class="form-control" id="myInputName" onkeyup="myFunction()" placeholder="Search by Name ...">
                    </div>
                </div>
            </div>
        </div>
        <form action="" method="POST">
            <input type="hidden" name="module_id" value="<?php echo htmlspecialchars($module_id); ?>">
            <table class="table text-start" id="myTable">
                <thead class="table-primary">
                    <tr>
                        <th scope="col" class="fixed-width">CNE</th>
                        <th scope="col" class="fixed-width">Nom</th>
                        <th scope="col" class="fixed-width">Prénom</th>
                        <th scope="col" class="fixed-width">Note</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $set = 0;
                    while ($row = $students_result->fetch_assoc()) {
                        if ($row["action"] == 'terminer') $set = 1;
                        echo '<tr>';
                        echo '<td class="fixed-width">' . htmlspecialchars($row["CNE"]) . '</td>';
                        echo '<td class="fixed-width">' . htmlspecialchars($row["nom"]) . '</td>';
                        echo '<td class="fixed-width">' . htmlspecialchars($row["prenom"]) . '</td>';
                        if (htmlspecialchars(($row["action"] == 'ajouter') || ($row["action"] == 'terminer'))) {
                            echo '<td class="fixed-width">' . htmlspecialchars($row["note"]) . '</td>';
                        } else {
                            echo '<td class="fixed-width"></td>';
                        }

                        echo '</tr>';
                    }

                    ?>
                </tbody>
            </table>
            <button <?php echo $set == 1 ? "hidden" : ""; ?> type="submit" name="action" value="terminer" class="btn btn-danger">Valider</button>
        </form>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0sG1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
<script>
    function myFunction() {
        var inputName, inputCNE, filterName, filterCNE, table, tr, tdName, tdCNE, i, txtValueName, txtValueCNE;
        inputName = document.getElementById("myInputName");
        inputCNE = document.getElementById("myInputCNE");
        filterName = inputName.value.toUpperCase();
        filterCNE = inputCNE.value.toUpperCase();
        table = document.getElementById("myTable");
        tr = table.getElementsByTagName("tr");

        for (i = 0; i < tr.length; i++) {
            tdName = tr[i].getElementsByTagName("td")[1];
            tdCNE = tr[i].getElementsByTagName("td")[0]; // Corrected index for CNE
            if (tdName && tdCNE) {
                txtValueName = tdName.textContent || tdName.innerText;
                txtValueCNE = tdCNE.textContent || tdCNE.innerText;
                if (txtValueName.toUpperCase().indexOf(filterName) > -1 && txtValueCNE.toUpperCase().indexOf(filterCNE) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }
</script>
</body>
</html>
