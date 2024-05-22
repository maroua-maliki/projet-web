<?php
ob_start(); // Démarre la temporisation de sortie

include("sidebar.php"); 
include("../navbar/navbar.php"); 
include("../connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    $CNE = NULL; // Affection automatique de NULL pour le CNE

    // Vérifier si l'email existe déjà
    $check_email_sql = "SELECT * FROM utilisateur WHERE email = ?";
    $stmt = $con->prepare($check_email_sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<div class='alert alert-danger text-center'>L'email existe déjà. Veuillez utiliser un autre email.</div>";
    } else {
        $sql = "INSERT INTO utilisateur (nom, prenom, email, role, CNE) VALUES (?, ?, ?, ?, ?)";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("sssss", $nom, $prenom, $email, $role, $CNE);
        
        if ($stmt->execute()) {
            header("Location: gererProf.php?msg=Enregistrement réussi");
            exit;
        } else {
            echo "<div class='alert alert-danger text-center'>Erreur lors de l'enregistrement des données : " . $con->error . "</div>";
        }
    }

    $stmt->close();
}
$con->close();
ob_end_flush(); // Arrête la temporisation et envoie la sortie
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter Professeur</title>
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');
        body {
            background-color: #f8f9fa;
            font-family: 'Poppins', sans-serif;
        }
        .form-container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 30px;
            max-width: 800px;
            margin: 50px auto;
        }
        .form-label {
            font-weight: bold;
        }
        .form-title {
            margin-bottom: 30px;
        }
        .form-buttons {
            margin-top: 30px;
            text-align: center;
        }
        .form-buttons .btn {
            margin: 0 10px;
        }
    </style>
</head>
<body>
    <div class="text-center mb-4 form-title">
      <br>
      <h3>Ajouter un nouveau professeur</h3>
      <p class="text-muted">Cliquez sur Ajouter après avoir ajouté les informations</p>
    </div>
    <div class="form-container">
        <form class="row g-3" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="col-md-6">
                <label for="validationDefault01" class="form-label">Nom</label>
                <input type="text" class="form-control" name="nom" id="validationDefault01" placeholder="Entrer le nom" required>
            </div>
            <div class="col-md-6">
                <label for="validationDefault02" class="form-label">Prénom</label>
                <input type="text" class="form-control" name="prenom" id="validationDefault02" placeholder="Entrer le prénom" required>
            </div>
            <div class="col-md-6">
                <label for="inputEmail4" class="form-label">Email</label>
                <input type="email" class="form-control" name="email" id="inputEmail4" placeholder="Entrer Email" required>
            </div>
            <div class="col-md-6">
                <label for="inputRole" class="form-label">Role</label>
                <select class="form-control" name="role" id="inputRole" required>
                    <option value="" disabled selected>Choisir le rôle</option>
                    <option value="professeur">professeur</option>
                    <option value="coordinateur">coordinateur</option>
                    <option value="chef_departement">chef de département</option>
                </select>
            </div>
            <div class="form-buttons">
                <button type="submit" class="btn btn-success">Ajouter</button>
                <a href="gererProf.php" class="btn btn-danger">Cancel</a>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script>
        const hamBurger = document.querySelector(".toggle-btn");
        hamBurger.addEventListener("click", function () {
            document.querySelector("#sidebar").classList.toggle("expand");
        });
        const profile = document.querySelector('nav .profile');
        const imgProfile = profile.querySelector('img');
        const dropdownProfile = profile.querySelector('.profile-link');
        imgProfile.addEventListener('click', function () {
            dropdownProfile.classList.toggle('show');
        })
    </script>
</body>
</html>
