<?php
session_start();
// Vérification si l'utilisateur est connecté et si c'est un étudiant
       if(isset($_SESSION['name'])  == 'name') {
    $student_name = $_SESSION['name'];
} else {
    // Redirection vers la page de connexion si l'utilisateur n'est pas connecté ou n'est pas un étudiant
    header("Location: ../login.php");
    exit; // Arrêter le script pour éviter l'exécution du reste de la page
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../bootstrap/bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- Ajout de FontAwesome -->
    <style>
       body {
        background: #eee;
        margin: 0; /* Supprime les marges par défaut du corps */
        padding: 0; /* Supprime les rembourrages par défaut du corps */
        overflow-x: hidden; /* Empêche le défilement horizontal */
       }

        #side_nav {
            background: #4e73df;
            min-width: 250px;
            max-width: 250px;
            transition: all 0.3s;
           
        }

        .content {
        min-height: 100vh; /* Utilise 100% de la hauteur de la vue */
        width: 100vw; /* Utilise 100% de la largeur de la vue */
        overflow-y: auto; /* Ajoute un défilement vertical si le contenu dépasse la hauteur de la vue */
         }

        hr.h-color {
            background: #eee;
        }

        .sidebar li:hover {
            background: #eee;
            border-radius: 8px;
        }

        .sidebar li:hover a {
            color: #000;
        }

        .sidebar li a {
            color: #fff;
        }
        .sidebar-heading {
          color: #e8e8e84a; /* Couleur grise pour le texte */
       }
       .card.border-left-primary,
        .card.border-left-danger {
           border-width: 5px; /* Changer la largeur de la bordure */
        }
        /* Ajout de styles pour centrer le titre */
        .centered-title {
            text-align: center;
        }
        .dropdown-menu {
         display: none; /* Masquer le menu déroulant par défaut */
        position: absolute;
        top: 100%;
         left: 0;
         z-index: 1000;
        }

       .nav-item:hover .dropdown-menu {
        display: block; /* Afficher le menu déroulant lorsque l'élément parent est survolé */
        }


        @media(max-width: 767px) {
            #side_nav {
                margin-left: -250px;
                position: absolute;
                min-height: 100vh;
                z-index: 1;
            }

            #side_nav.active {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    <div class="main-container d-flex">
        <div class="sidebar" id="side_nav">
            <div class="header-box px-2 pt-3 pb-4 d-flex justify-content-between">
                <h3 class="fs-4"><img src="../image/logo-ensah.png" alt="logo" width="65" height="65" class="logo"> <span
                        class="text-white">E-Service</span></h3>
                <button class="btn d-md-none d-block close-btn px-1 py-0 text-white"><i
                        class="fal fa-stream"></i></button>
            </div>

            <ul class="list-unstyled px-2">
                <li class=""><a href="page1.php" class="text-decoration-none px-3 py-3 d-block">
                <i class="fas fa-home fa-2x fa-sm text-gray-300"></i>
                       Accueil</a></li>
                       <hr class="h-color mx-2">
                       <div class="sidebar-heading">
                          Services en ligne
                        </div>
                <li class=""><a href="#" class="text-decoration-none px-3 py-3 d-block"><i class="fas fa-calendar fa-2x fa-sm text-gray-300"></i>

                        Emploi du temps</a></li>
            
                <li class=""><a href="#" class="text-decoration-none px-3 py-3 d-block">
                <i class="fas fa-graduation-cap fa-2x fa-sm text-gray-300"></i> Notes</a></li>
        
            </ul>
            <hr class="h-color mx-2">
            <ul class="list-unstyled px-2">
            <div class="sidebar-heading">
                          Autres
                        </div>
                <li class=""><a href="#" class="text-decoration-none px-3 py-3 d-block"><i class="fas fa-user fa-2x fa-sm text-gray-300"></i>
                        Profile</a></li>
                <li class=""><a href="personel.php" class="text-decoration-none px-3 py-3 d-block"><i class="fas fa-users fa-2x fa-sm text-gray-300"></i>
                        Personnel</a></li>

            </ul>

        </div>
        <div class="content">
            <nav class="navbar navbar-expand-md navbar-light bg-light">
                <div class="container-fluid">
                    <div class="d-flex justify-content-between d-md-none d-block">
                        <button class="btn px-1 py-0 open-btn me-2"><i class="fal fa-stream"></i></button>
                        <a class="navbar-brand fs-4" href="#"><span class="bg-dark rounded px-2 py-0 text-white">CL</span></a>
                    </div>
                    <button class="navbar-toggler p-0 border-0" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fal fa-bars"></i>
                    </button>
    
                    <!-- Topbar Search -->
                    <form
                        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                                aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                    <!-- Nav Item - User Information -->
                    <div class="nav-item dropdown no-arrow">
    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-user fa-lg fa-fw mr-2 text-gray-400"></i>
        <span class="text-gray-900 font-weight-bold"><?php echo $student_name; ?></span>
    </a>
    <!-- Dropdown - User Information -->
    <div class="dropdown-menu">
        <a class="dropdown-item" href="#">
            <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
            Profile
        </a>
    
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="../login/login.php" data-toggle="modal" data-target="#logoutModal">
            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
            Logout
        </a>
    </div>
</div>
                    
                </div>
            </nav>
            <br>
            <div class="centered-title">
                <h1 >Bienvenue sur la plateforme e-Services</h1>
            </div> <br> <br>
  <div class="container">
    <table class="table table-hover text-center">
      <thead class="table-primary">
        <tr>
          <th scope="col">Nom</th>
          <th scope="col">Prénom</th>
          <th scope="col">Email</th>
        </tr>
      </thead>
      <tbody>
        <?php
         include("../connect.php");
        $sql = "SELECT * FROM `professeur` order by Nom ASC";
        $result = mysqli_query($con, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
        ?>
          <tr>
            <td><?php echo $row["Nom"] ?></td>
            <td><?php echo $row["Prénom"] ?></td>
            <td><?php echo $row["Email"] ?></td>
          </tr>
        <?php
        }
        ?>
      </tbody>
    </table>
  </div>

</body>
</html>