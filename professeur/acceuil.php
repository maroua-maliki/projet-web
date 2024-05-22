
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceuil</title>
    <link rel="stylesheet" href="../bootstrap/bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- Ajout de FontAwesome -->
    <style>
     @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');
.main {
    display: flex;
    flex-direction: column;
    min-height: 100vh;
    width: 100%;
    overflow: hidden;
    transition: all 0.35s ease-in-out;
    background-color: #e8e8e84a;
    min-width: 0;
}
#content{
    background-color: #fff;
}

.a{
    background-color:#7189d1;
}
    </style>
</head>
<body> 
<?php 
    session_start();
    include("sidebar.php");
    include("../navbar/navbar.php");
?>
    <br> <br>
       <div class="d-lg-flex align-items-center justify-content-center mb-4">
                          
                        <h1 class="h3 mb-0 text-gray-800"> Bienvenue sur la plateforme e-Services</h1>
         </div>
         
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
