<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
    include("../connect.php");
?>

<div class="container mt-4">
    <table class="table text-center">
        <thead class="table-primary">
            <tr>
                <th scope="col">Niveau</th>
                <th scope="col">Module</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT .nom AS niveau_nom, filiere.nom AS filiere_nom 
                    FROM niveau 
                    INNER JOIN filiere ON niveau.filiere_id = filiere.id";
            $result = mysqli_query($con, $sql);

            // Array to store filieres and their niveaux
            $filieres = array();

            // Fetch the results
            while ($row = mysqli_fetch_assoc($result)) {
                $filiere_nom = htmlspecialchars($row["filiere_nom"]);
                $niveau_nom = htmlspecialchars($row["niveau_nom"]);

                // Group niveaux by filiere
                if (!isset($filieres[$filiere_nom])) {
                    $filieres[$filiere_nom] = array();
                }
                $filieres[$filiere_nom][] = $niveau_nom;
            }

            // Display the results
            foreach ($filieres as $filiere_nom => $niveaux) {
                echo "<tr>";
                echo "<td>{$filiere_nom}</td>";
                echo "<td>";
                foreach ($niveaux as $niveau_nom) {
                    echo "<a href='#'>{$niveau_nom}</a> <br> ";
                }
                echo "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>
