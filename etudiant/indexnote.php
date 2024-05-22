<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Les modules à enseigner</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');

        body {
            background-color: #f8f9fa;
            font-family: 'Poppins', sans-serif;
        }
        .d-lg-flex {
            margin-top: 20px;
        }
        .table-container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 30px;
            margin: 10px auto;
            max-width: 90%;
        }
        .table {
            margin-bottom: 0;
        }
        .table th, .table td {
            vertical-align: middle;
        }
        .table thead {
            background-color: #007bff;
            color: #fff;
        }
        .table thead th {
            font-weight: 600;
        }
        .table tbody tr {
            transition: background-color 0.3s;
        }
        .table tbody tr:hover {
            background-color: #f1f1f1;
        }
        .module-link {
            color: #007bff;
            text-decoration: none;
            transition: color 0.3s;
        }
        .module-link:hover {
            color: #0056b3;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <?php
    if(session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if(isset($_SESSION['id'])) {
        $student_id = $_SESSION['id'];
    } else {
        header("Location: ../login.php");
        exit;
    }

    // Récupérer le numéro du semestre depuis l'URL
    if(isset($_GET['semester'])) {
        $semestre = $_GET['semester'];
    } else {
        // Gérer le cas où le numéro du semestre n'est pas défini
        echo "Le numéro du semestre n'est pas spécifié.";
        exit;
    }

    include("sidebar.php");
    include("../navbar/navbar.php");
    include("../connect.php");
    ?>
    <br><br>
    <div class="d-lg-flex align-items-center justify-content-center mb-4">       
        <h1 class="h3 mb-0 text-gray-800">Les modules à enseigner</h1>
    </div>
    <div class="container mt-4">
        <div class="table-container">
            <table class="table table-bordered text-center">
                <thead class="table-primary">
                    <tr>
                        <th scope="col">Professeur</th>
                        <th scope="col">Module</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT module.id AS module_id, module.nom AS module
                            FROM utilisateur u
                            INNER JOIN module ON module.niveau_id = u.niveau 
                            WHERE u.id='$student_id' AND module.semestre='$semestre'";
                    $result = mysqli_query($con, $sql);
                    
                    if ($result) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $module_id = $row["module_id"];
                            
                            // Requête pour obtenir les professeurs associés à ce module
                            $sql_prof = "SELECT u.nom AS professeur_nom, u.prenom AS professeur_pre
                                         FROM utilisateur u
                                         INNER JOIN affectation_module_professeur a ON a.professeur_id = u.id 
                                         WHERE a.module_id = '$module_id'";
                            $result_prof = mysqli_query($con, $sql_prof);
                            
                            $professeur_nom_complet = "";
                            if ($result_prof) {
                                while ($prof_row = mysqli_fetch_assoc($result_prof)) {
                                    $professeur_nom_complet .= htmlspecialchars($prof_row["professeur_nom"]) . " " . htmlspecialchars($prof_row["professeur_pre"]) . "<br>";
                                }
                            }

                            echo "<tr>";
                            echo "<td>" . $professeur_nom_complet . "</td>";
                            echo "<td><a href='note.php?module_id=" . htmlspecialchars($row["module_id"]) . "' class='module-link'>" . htmlspecialchars($row["module"]) . "</a></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "Erreur de requête : " . mysqli_error($con);
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>
