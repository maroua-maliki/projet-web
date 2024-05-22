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
    <h1 class="h3 mb-0 text-gray-800"> Les modules à enseigner</h1>
</div>
<div class="container mt-4">
    <div class="table-container">
        <table class="table table-bordered text-center">
            <thead class="table-primary">
                <tr>
                    <th scope="col">Niveaux</th>
                    <th scope="col">Module</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT module.id AS module_id, niveau.nom AS niveau, module.nom AS module
                        FROM utilisateur u
                        INNER JOIN module ON module.filiere_id = u.id_filiere 
                        INNER JOIN niveau ON module.niveau_id = niveau.id
                        WHERE u.id='$prof_id' AND module.semestre='$semestre'";
                $result = mysqli_query($con, $sql);
                
                if ($result) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row["niveau"]); ?></td>
                            <td><a href="note.php?module_id=<?php echo htmlspecialchars($row["module_id"]); ?>" class="module-link"><?php echo htmlspecialchars($row["module"]); ?></a></td>
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
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>
