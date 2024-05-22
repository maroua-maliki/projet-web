<?php
include("../connect.php");
if(session_status() === PHP_SESSION_NONE) {
    session_start();
}
if(isset($_SESSION['id'])) {
    $student_id = $_SESSION['id'];
} else {
    header("Location: ../login.php");
    exit; 
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Choisir une filière et un semestre</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            color: #333;
        }
        .container {
            text-align: center;
            margin: 50px auto;
            max-width: 900px;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #007bff;
            margin-bottom: 40px;
        }
        .choose-semestre {
            margin-top: 20px;
        }
        .semestre-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .semestre-table th, .semestre-table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: center;
        }
        .semestre-table th {
            background-color: #f8d7da;
            color: #721c24;
        }
        .semestre-table td {
            background-color: #f4d7da;
        }
        .semestre-link {
            color: #0c5460;
            font-weight: bold;
            text-decoration: none;
            transition: color 0.3s;
        }
        .semestre-link:hover {
            color: #155724;
        }
    </style>
</head>
<body>
<?php 
    include("sidebar.php");
    include("../navbar/navbar.php");
?>
    <div class="container">
        <h1 class="choose-semestre">Choisir un semestre</h1>
        <?php
        $students_query = "
            SELECT DISTINCT m.semestre 
            FROM module m 
            INNER JOIN utilisateur u ON m.niveau_id = u.niveau 
            WHERE u.id = '$student_id' order by semestre ASC 
        ";
        $stmt = $con->prepare($students_query);
        if ($stmt) {
            $stmt->execute();
            $result = $stmt->get_result();
            echo '<table class="semestre-table">';
            echo '<tr><th>Semestre</th><th>Action</th></tr>';
            while ($row = $result->fetch_assoc()) {
                $sem = $row['semestre'];
                echo '<tr>';
                echo '<td>Semestre ' . $sem . '</td>';
                echo '<td><a class="semestre-link" href="indexnote.php?semester=' . $sem . '">Voir modules</a></td>';
                echo '</tr>';
            }
            echo '</table>';
            $stmt->close();
        } else {
            echo "Erreur lors de la préparation de la requête : " . $con->error;
        }
        ?>
    </div>
</body>
</html>
