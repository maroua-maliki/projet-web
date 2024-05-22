<?php
include("../connect.php");
session_start();
$id = mysqli_real_escape_string($con, $_GET["id"]);

if (isset($_POST["submit"])) {
  $cne = mysqli_real_escape_string($con, $_POST['CNE']);
  $first_name = mysqli_real_escape_string($con, $_POST['first_name']);
  $last_name = mysqli_real_escape_string($con, $_POST['last_name']);
  $email = mysqli_real_escape_string($con, $_POST['email']);
  $niveau = mysqli_real_escape_string($con, $_POST['niveau']);

  // Check if the email already exists in the database
  $email_check_sql = "SELECT * FROM utilisateur WHERE email='$email' AND CNE != '$id'";
  $email_check_result = mysqli_query($con, $email_check_sql);

  if (mysqli_num_rows($email_check_result) > 0) {
    echo "Failed: Email already exists for another user.";
  } else {
    $sql = "UPDATE utilisateur SET CNE='$cne', nom='$first_name', prenom='$last_name', email='$email', niveau='$niveau' WHERE role='etudiant' AND CNE='$id'";
    $result = mysqli_query($con, $sql);

    if ($result) {
      header("Location: gererEtudiant.php?msg=Inforation modifier avec succès");
    } else {
      echo "Failed: " . mysqli_error($con);
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Bootstrap -->
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

  <title>Modifier étudiant</title>
</head>

<body>
<?php 
    include("sidebar.php"); 
    include("../navbar/navbar.php"); 
?>
  <div class="container">
    <div class="text-center mb-4 form-title">
      <br>
      <h3>Modifier les informations d'un étudiant</h3>
      <p class="text-muted">Cliquez sur Update après avoir modifié les informations</p>
    </div>

    <?php
    $sql = "SELECT * FROM utilisateur WHERE role='etudiant' AND CNE='$id' LIMIT 1";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);

    // Récupérer les niveaux disponibles
    $niveau_sql = "SELECT id, nom FROM niveau";
    $niveau_result = mysqli_query($con, $niveau_sql);
    ?>

    <div class="form-container">
      <form action="" method="post">
        <div class="row mb-3">
          <div class="col">
            <label class="form-label">CNE:</label>
            <input type="text" class="form-control" name="CNE" value="<?php echo htmlspecialchars($row['CNE']); ?>">
          </div>
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
          <label class="form-label">Niveau:</label>
          <select class="form-control" name="niveau" required>
            <option value="" disabled>Choisir le niveau</option>
            <?php
            if ($niveau_result->num_rows > 0) {
                while ($niveau_row = mysqli_fetch_assoc($niveau_result)) {
                    $selected = $niveau_row['id'] == $row['niveau'] ? 'selected' : '';
                    echo '<option value="' . $niveau_row['id'] . '" ' . $selected . '>' . $niveau_row['nom'] . '</option>';
                }
            }
            ?>
          </select>
        </div>
        <div class="text-center">
          <button type="submit" class="btn btn-success" name="submit">Update</button>
          <a href="gererEtudiant.php" class="btn btn-danger">Cancel</a>
        </div>
      </form>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>
