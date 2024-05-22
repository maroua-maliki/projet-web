<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="refresh" content="50">
    <title>Ensah</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="x">
        <div class="image">
            <img src="../image/Ensa1.jpeg" alt="photo" width="450" height="450" class="base-image">
        </div>
        <div class="y">
            <img src="../image/logo-ensah.png" alt="logo" width="65" height="65" class="logo">
            <h1 class="P">Plateforme eServices</h1>
            <form action="#" method="POST">
                <input type="text" name="name" placeholder="Entrer votre nom d'utilisateur ..." class="input-field" required><br><br>
                <input type="password" name="password" placeholder="Saisir votre mot de passe" class="input-field" required> <br><br><br>
                <div class="remember-forgot">
                    <input type="checkbox" id="remember-me">
                    <label for="remember-me">Se rappeler de moi</label>
                </div>
                <br> <br>
                <input type="submit" name="submit" value="Se connecter" class="input-button"> 
                <?php 
                    include("../connect.php");
                    session_start();
                    if(isset($_POST['submit'])) {
                        $name = htmlspecialchars(trim($_POST['name']));
                        $password = htmlspecialchars(trim($_POST['password']));
                        $utilisateur = "SELECT * FROM utilisateur WHERE ((role='etudiant' AND CNE='$name') OR (role<>'etudiant' AND email='$name')) AND mot_de_passe='$password'";
                        $result = mysqli_query($con, $utilisateur);
                        if(mysqli_num_rows($result) > 0) {
                            $row = mysqli_fetch_assoc($result);
                            $_SESSION['nom'] = $row['nom'];
                            $_SESSION['prenom'] = $row['prenom'];
                            $_SESSION['id'] = $row['id'];
                            
                            if ($row['role'] == 'etudiant') {
                                header("Location: ../etudiant/acceuil.php");
                            }
                            elseif ($row['role'] == 'chef_departement' || $row['role'] == 'coordinateur') {
                                header("Location: ../coordinateur/acceuil.php");
                            } 
                            elseif ($row['role'] == 'professeur') {
                                header("Location: ../professeur/acceuil.php");
                            } 
                            else {
                                // Gérer d'autres rôles si nécessaire
                            }
                            exit(); // Assurez-vous de sortir après la redirection pour éviter toute autre sortie non désirée.
                        } 
                        else {
                            echo '<p class="error-message">Login ou mot de passe invalides</p>';
                        }
                    }
                   ?> 
                <hr class="line">
                <div class="centered-text">
                    <a href="#">Mot de passe oublié ?</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>