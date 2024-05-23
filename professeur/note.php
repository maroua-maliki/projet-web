<?php
if(session_status() === PHP_SESSION_NONE) {
    session_start();
}
if(isset($_SESSION['id'])) {
    $prof_id = $_SESSION['id'];
} else {
    header("Location: ../login.php");
    exit; 
}

include("../connect.php");

$success_message = "";
$error_message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['module_id']) && isset($_POST['notes']) && isset($_POST['action'])) {
        $module_id = $_POST['module_id'];

        // Efface les notes associées au module
        $stmt = $con->prepare("DELETE FROM note WHERE module_id = ?");
        $stmt->bind_param('i', $module_id);
        if (!$stmt->execute()) {
            $error_message = "Error clearing table: " . $stmt->error;
        }

        // Traiter la soumission du formulaire pour enregistrer les notes
        $notes = $_POST['notes'];
        $action = $_POST['action'];

        foreach ($notes as $student_id => $note) {
            $query = "INSERT INTO note (module_id, etudiant_id, note, action) 
                      VALUES (?, ?, ?, ?) 
                      ON DUPLICATE KEY UPDATE note=?, action=?";
            $stmt = $con->prepare($query);
            if ($stmt === false) {
                $error_message = "Error preparing statement: " . $con->error;
                continue;
            }
            $stmt->bind_param('iiisis', $module_id, $student_id, $note, $action, $note, $action);
            if (!$stmt->execute()) {
                $error_message = "Error executing statement: " . $stmt->error;
            }
        }

        if (empty($error_message)) {
            if ($action == 'ajouter') {
                $success_message = "Les notes ont été ajoutées avec succès.";
            } elseif ($action == 'sauvegarder') {
                $success_message = "Les notes ont été sauvegardées avec succès.";
            }
        }
    } else {
        $error_message = "Error: Module ID, notes, or action not set.";
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
        SELECT u.id, u.nom, u.prenom, u.CNE, n.note , n.action 
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
            box-shadow: 0;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
<?php 
    include("sidebar.php");
    include("../navbar/navbar.php");
?>
<div class="container mt-4">
    <div class="table-container" style="max-height: 400px; overflow-y: auto;">
        <h2>Notes des Étudiants</h2>
        <br>
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
        <form action="note.php?module_id=<?php echo htmlspecialchars($module_id); ?>" method="POST">
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
                        echo '<tr>';
                        echo '<td class="fixed-width">' . htmlspecialchars($row["CNE"]) . '</td>';
                        echo '<td class="fixed-width">' . htmlspecialchars($row["nom"]) . '</td>';
                        echo '<td class="fixed-width">' . htmlspecialchars($row["prenom"]) . '</td>';
                        echo '<td class="fixed-width"><input type="text" name="notes[' . htmlspecialchars($row["id"]) . ']" class="form-control" value="' . htmlspecialchars($row["note"]) . '"';
                        if ($row["action"] == "ajouter") {
                            $set = 2;
                            echo ' readonly';
                        }
                        echo '></td>';
                        echo '</tr>';
                    }
                    ?>
                </tbody>
            </table>
            <button <?php if ($set == 2) echo 'hidden'; ?> type="submit" name="action" value="sauvegarder" class="btn btn-success">Sauvegarder</button>
            <button <?php if ($set == 2) echo 'hidden'; ?> type="submit" name="action" value="ajouter" class="btn btn-danger">Valider</button>
        </form>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
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
            tdName = tr[i].getElementsByTagName("td")[1]; // Index changed to 1 for Nom
            tdCNE = tr[i].getElementsByTagName("td")[0]; // Index changed to 0 for CNE
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
