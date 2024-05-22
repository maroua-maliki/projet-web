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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Module</title>
</head>
<body>
<?php 
    include("sidebar.php");
    include("../navbar/navbar.php");
    include("../connect.php");
?>
<br><br>
 <div class="d-lg-flex align-items-center justify-content-center mb-4">       
                 <h1 class="h3 mb-0 text-gray-800"> Les modules à enseigner</h1>
           </div>
<div class="container mt-4">
    <table class="table text-center">
        <thead class="table-primary">
            <tr>
                <th scope="col">Filière</th>
                <th scope="col">Niveaux</th>
                <th scope="col">module</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT niveau.nom AS niveau, filiere.nom AS filiere, module.nom AS module
                    FROM affectation_module_professeur AS a
                    INNER JOIN module ON a.module_id = module.id
                    INNER JOIN niveau ON module.niveau_id = niveau.id
                    INNER JOIN filiere ON niveau.filiere_id = filiere.id
                    WHERE a.professeur_id='$prof_id'";
            $result = mysqli_query($con, $sql);
            
            if ($result) {
                while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <tr>
                        <td><?php echo $row["filiere"] ?></td>
                        <td><?php echo $row["niveau"] ?></td>
                        <td><?php echo $row["module"] ?></td>
                    </tr>
                    <?php
                }
            } else {
                echo "Erreur de requête : " . mysqli_error($con);
            }
            ?>
        </tbody>
    </table>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>
