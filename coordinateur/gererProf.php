<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap -->
    <link href="../../bootstrap/bootstrap-5.3.3-dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <title>Liste des professeur</title>
    <style>
        body {
            background-color: #f8f9fa;
        }

        .form-container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            max-width: 1500px;
            margin: 50px auto;
        }

     
        .table-container {
            border: 2px solid #ffffff; /* Couleur blanche pour le cadre */
            border-radius: 8px; /* Coins arrondis */
            padding: 10px; /* Augmentation du rembourrage pour agrandir le cadre */
            overflow-x: auto; /* Ajout de défilement horizontal si nécessaire */
        }
    </style>
</head>

<body>

    <?php 
    include("sidebar.php"); 
    include("../navbar/navbar.php"); ?>
    <div class="container">
        <?php
        include("../connect.php");
        if (isset($_GET["msg"])) {
            $msg = $_GET["msg"];
            echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
            ' . $msg . '
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
        }
        ?>
        <br>
        <div class="text-center mb-4 form-title">
            <h3>Liste des professeur</h3>
        </div>
        <div class="form-container">
            <a href="ajouterProf.php" class="btn btn-dark mb-3">Ajouter Nouveau</a>

            <!-- Ajout de la classe .table-container -->
            <div class="table-container">
                <table class="table table-hover text-start">
                    <thead class="table-primary">
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Nom</th>
                            <th scope="col">Prénom</th>
                            <th scope="col">Email</th>
                            <th scope="col">Role</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM `utilisateur` where role<>'etudiant' order by role ASC , nom ASC";
                        $result = mysqli_query($con, $sql);
                        while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                            <tr>
                                <td><?php echo $row["id"] ?></td>
                                <td><?php echo $row["nom"] ?></td>
                                <td><?php echo $row["prenom"] ?></td>
                                <td><?php echo $row["email"] ?></td>
                                <td><?php echo $row["role"] ?></td>
                                <td>
                                    <a href="modifierProf.php?id=<?php echo $row["id"] ?>" class="link-dark"><i
                                            class="fa-solid fa-pen-to-square fs-5 me-3"></i></a>
                                    <a href="supprimerProf.php?id=<?php echo $row["id"] ?>"
                                        class="link-dark"><i class="fa-solid fa-trash fs-5"></i></a>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>

</body>

</html>
