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
    <link href="../../bootstrap/bootstrap-5.3.3-dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Module</title>
    <style>
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
    </style>
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
    <div class="table-container"  style="max-height: 400px; overflow-y: auto;">
        <table class="table table-bordered text-center">
            <thead class="table-primary">
                <tr>
                    <th scope="col">Filière</th>
                    <th scope="col">Niveaux</th>
                    <th scope="col">Module</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT module.id AS module_id, niveau.nom AS niveau, filiere.nom AS filiere, module.nom AS module
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
                            <td><?php echo htmlspecialchars($row["filiere"]); ?></td>
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
