<?php
include("../connect.php");
session_start();
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
         SELECT m.semestre AS semesters
         FROM mdule m
          JOIN utilisateur u ON u.niveau = .niveau_id 
         WHERE u.role = 'etudiant' 
         ORDER BY u.nom ASC
     ";
     $stmt = $con->prepare($students_query);
     $stmt->bind_param('ii', $module_id, $niveau_id);
     $stmt->execute();
     $students_result = $stmt->get_result();
        echo '<table class="semestre-table">';
        echo '<tr><th>Semestre</th><th>Action</th></tr>';
        foreach ($semesters as $sem) {
            echo '<tr>';
            echo '<td>Semestre ' . $sem . '</td>';
            echo '<td><a class="semestre-link" href="indexnote.php?semester=' . $sem . '">Voir modules</a></td>';
            echo '</tr>';
        }
        echo '</table>';
        ?>
    </div>
</body>
</html>
