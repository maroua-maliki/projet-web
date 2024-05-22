<?php
include("../connect.php");
session_start();
$id = mysqli_real_escape_string($con, $_GET["id"]);

if (isset($_POST["submit"])) {
    $first_name = mysqli_real_escape_string($con, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($con, $_POST['last_name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $role = mysqli_real_escape_string($con, $_POST['role']);

    $sql = "UPDATE utilisateur SET nom='$first_name', prenom='$last_name', email='$email', role='$role' WHERE id='$id'";

    $result = mysqli_query($con, $sql);

    if ($result) {
        header("Location: gererProf.php?msg=Data updated successfully");
    } else {
        echo "Failed: " . mysqli_error($con);
    }
}

$sql = "SELECT * FROM utilisateur WHERE role<>'etudiant' AND id='$id' LIMIT 1";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier professeur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .form-container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 30px;
            max-width: 800px; /* Augmentation de la largeur maximale */
            margin: 50px auto;
        }

        .form-label {
            font-weight: bold;
        }

        .form-title {
            margin-bottom: 30px;
        }
    </style>
</head>

<body>
    <?php
    include("sidebar.php");
    include("../navbar/navbar.php");
    ?>
    <div class="container">
        <div class="text-center mb-4 form-title">
            <br>
            <h3>Modifier les informations d'un professeur</h3>
            <p class="text-muted">Cliquez sur Update après avoir modifié les informations</p>
        </div>

        <div class="form-container">
            <form action="" method="post">
                <div class="row mb-3">
                    <div class="col">
                        <label class="form-label">First Name:</label>
                        <input type="text" class="form-control" name="first_name" value="<?php echo htmlspecialchars($row['nom']); ?>">
                    </div>
                    <div class="col">
                        <label class="form-label">Last Name:</label>
                        <input type="text" class="form-control" name="last_name" value="<?php echo htmlspecialchars($row['prenom']); ?>">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email:</label>
                    <input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($row['email']); ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label">Role:</label>
                    <select class="form-control" name="role" required>
                        <option value="" disabled>Choisir le role</option>
                        <option value="professeur" <?php if ($row['role'] == 'professeur') echo 'selected'; ?>>Professeur</option>
                        <option value="coordinateur" <?php if ($row['role'] == 'coordinateur') echo 'selected'; ?>>Coordinateur</option>
                        <option value="chef_departement" <?php if ($row['role'] == 'chef_departement') echo 'selected'; ?>>Chef de département</option>
                    </select>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-success" name="submit">Update</button>
                    <a href="gererProf.php" class="btn btn-danger">Cancel</a>
                </div>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>

</html>
