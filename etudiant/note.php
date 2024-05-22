<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Note du Module</title>
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');
        body {
            background-color: #f8f9fa;
            font-family: 'Poppins', sans-serif;
        }
        .form-container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 30px;
            max-width: 800px;
            margin: 50px auto;
            text-align: center;
        }
        .form-label {
            font-weight: bold;
        }
        .form-title {
            margin-bottom: 30px;
        }
        .form-buttons {
            margin-top: 30px;
            text-align: center;
        }
        .form-buttons .btn {
            margin: 0 10px;
        }
        .card-body {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        .card-body p {
            margin: 10px 0;
        }
        @media (max-width: 768px) {
            .col-md-4 {
                display: flex;
                justify-content: center;
                align-items: center;
            }
            .col-md-4 img {
                max-width: 100px;
                height: auto;
            }
        }
        .badge-R {
            background-color: #dc3545;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
        }
        .badge-V {
            background-color: #28a745;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <?php 
        // Démarrer la session et récupérer l'identifiant de l'étudiant
        if(session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if(isset($_SESSION['id'])) {
            $student_id = $_SESSION['id'];
        } else {
            header("Location: ../login.php");
            exit;
        }

        include("sidebar.php"); 
        include("../navbar/navbar.php"); 
        include("../connect.php");

        // Récupérer l'ID du module depuis l'URL
        if(isset($_GET['module_id'])) {
            $module_id = $_GET['module_id'];
        } else {
            echo "L'ID du module n'est pas spécifié.";
            exit;
        }

        // Récupérer les notes du module
        $sql = "SELECT note, action FROM note WHERE module_id = '$module_id' AND etudiant_id = '$student_id'";
        $result = mysqli_query($con, $sql);

        // Récupérer le nom du module
        $sql_module = "SELECT nom FROM module WHERE id = '$module_id'";
        $result_module = mysqli_query($con, $sql_module);
        
        $note = null;
        $note_max = null;
        $note_min = null;
        $action = null;
        $module_nom = "";

        if ($result_module && mysqli_num_rows($result_module) > 0) {
            $row_module = mysqli_fetch_assoc($result_module);
            $module_nom = $row_module['nom'];
        }

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $note = $row['note'];
            $action = $row['action'];
            // Récupérer les notes maximale et minimale pour le module
            $sql_stats = "SELECT MAX(note) AS note_max, MIN(note) AS note_min FROM note WHERE module_id = '$module_id'";
            $result_stats = mysqli_query($con, $sql_stats);
            if ($result_stats && mysqli_num_rows($result_stats) > 0) {
                $row_stats = mysqli_fetch_assoc($result_stats);
                $note_max = $row_stats['note_max'];
                $note_min = $row_stats['note_min'];
            }
        } else {
            echo "Erreur de requête : " . mysqli_error($con);
        }
    ?>

    <div class="text-center mb-4 form-title">
        <br>
        <h3>Note du module <?php echo htmlspecialchars($module_nom); ?></h3>
    </div>
    <div class="form-container">
        <div class="card mb-3 mx-auto" style="max-width: 800px;">
            <div class="row g-0">
                <div class="col-md-4 d-flex align-items-center justify-content-center">
                    <img src="../image/grads.jpg" class="img-fluid rounded-start" alt="...">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title">Détails de la Note</h5>
                        <?php if ($action === 'terminer') { ?>
                            <p class="card-text">
                                <strong>Note:</strong> <?php echo htmlspecialchars($note); ?> 
                                <span class="badge <?php echo ($note < 10) ? 'badge-R' : 'badge-V'; ?>">
                                    <?php echo ($note < 10) ? 'R' : 'V'; ?>
                                </span>
                            </p>
                        <?php } else { ?>
                            <p class="card-text"><strong>Note:</strong> Les notes ne sont pas encore disponibles.</p>
                        <?php } ?>
                        <?php if ($action === 'terminer') { ?>
                            <p class="card-text mt-4"><strong>Note Maximale:</strong> <?php echo htmlspecialchars($note_max); ?></p>
                            <p class="card-text"><strong>Note Minimale:</strong> <?php echo htmlspecialchars($note_min); ?></p>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
