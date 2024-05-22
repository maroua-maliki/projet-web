<?php
if(session_status() === PHP_SESSION_NONE) {
    session_start();
}
if(isset($_SESSION['nom'])) {
    $student_nom = $_SESSION['nom'];
    $student_prenom = $_SESSION['prenom'];
} else {
    header("Location: ../login.php");
    exit; 
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sidebar</title>
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');

::after,
::before {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}
li {
    list-style: none;
}

body {
    font-family: 'Poppins', sans-serif;
}

.wrapper {
    display: flex;
}

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
#sidebar {
    width: 70px;
    min-width: 70px;
    z-index: 1000;
    transition: all .25s ease-in-out;
    background-color: #4e73df;
    display: flex;
    flex-direction: column;
}

#sidebar.expand {
    width: 260px;
    min-width: 260px;
}

.toggle-btn {
    background-color: transparent;
    cursor: pointer;
    border: 0;
    padding: 1rem 1.5rem;
}

.toggle-btn i {
    font-size: 1.5rem;
    color: #FFF;
}

.sidebar-logo {
    margin: auto 0;
}

.sidebar-logo a {
    color: #FFF;
    font-size: 1.15rem;
    font-weight: 600;
}

#sidebar:not(.expand) .sidebar-logo,
#sidebar:not(.expand) a.sidebar-link span {
    display: none;
}

#sidebar.expand .sidebar-logo,
#sidebar.expand a.sidebar-link span {
    animation: fadeIn .25s ease;
}

@keyframes fadeIn {
    0% {
        opacity: 0;
    }

    100% {
        opacity: 1;
    }
}
#es{
    margin: 10px 0px;
}
.sidebar-nav {
    padding: 2rem 0;
    flex: 1 1 auto;
}

a.sidebar-link {
    padding: .625rem 1.625rem;
    color: #FFF;
    display: block;
    font-size: 0.9rem;
    white-space: nowrap;
    border-left: 3px solid transparent;
    text-decoration: none;
}

.sidebar-link i,
.dropdown-item i {
    font-size: 1.1rem;
    margin-right: .75rem;
}

a.sidebar-link:hover {
    background-color: rgba(255, 255, 255, .075);
    border-left: 3px solid #3b7ddd;
}

.sidebar-item {
    position: relative;
}
.a{
    background-color:#7189d1;

}
#sidebar:not(.expand) .sidebar-item .sidebar-dropdown {
    position: absolute;
    top: 0;
    left: 70px;
    background-color: #0e2238;
    padding: 0;
    min-width: 15rem;
    display: none;
}

#sidebar:not(.expand) .sidebar-item:hover .has-dropdown+.sidebar-dropdown {
    display: block;
    max-height: 15em;
    width: 100%;
    opacity: 1;
}

#sidebar.expand .sidebar-link[data-bs-toggle="collapse"]::after {
    border: solid;
    border-width: 0 .075rem .075rem 0;
    content: "";
    display: inline-block;
    padding: 2px;
    position: absolute;
    right: 1.5rem;
    top: 1.4rem;
    transform: rotate(-135deg);
    transition: all .2s ease-out;
}

#sidebar.expand .sidebar-link[data-bs-toggle="collapse"].collapsed::after {
    transform: rotate(45deg);
    transition: all .2s ease-out;
}
@media (min-width: 768px) {}</style>
</head>

<body>
    <div class="wrapper">
        <aside id="sidebar">
            <div class="d-flex">
                <button class="toggle-btn" type="button">
                <i class="bi bi-list"></i>
                </button>
                <div class="sidebar-logo">
                    <h4 class="text-danger">e-<span class="text-white">Services</span></h4>
                </div>
                </div>
            <ul class="sidebar-nav">
                <li class="sidebar-item">
                <a href="acceuil.php"  class="sidebar-link">
                    <i class="bi bi-house-door-fill"></i>
                        <span>Accueil</span>
                </a>
                </li>
                <hr class="h-color mx-2">
                <li class="sidebar-item">
                    <a href="gererProf.php" class="sidebar-link collapsed has-dropdown" >
                        <i class="bi bi-person-plus "></i>
                        <span>Gérer les profs</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="gererEtudiant.php" class="sidebar-link collapsed has-dropdown" >
                    <i class="bi bi-person-fill-add"></i>
                        <span>Gérer les étudiants</span>
                     </a>
                </li>
                <li class="sidebar-item">
                     <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse"
                     data-bs-target="#schedule" aria-expanded="false" aria-controls="schedule">
                  <i class="bi bi-calendar"></i>
                    <span>Emploi du temps</span>
                      </a>
                     <ul id="schedule" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                 <li class="sidebar-item">
                      <a href="#" class="sidebar-link a">Consulter</a>
                   </li>
                  <li class="sidebar-item">
                    <a href="#" class="sidebar-link a">Gérer</a>
                  </li>
               </ul>
             </li>
             <li class="sidebar-item">
                  <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse"
                    data-bs-target="#grades" aria-expanded="false" aria-controls="grades">
                    <i class="bi bi-mortarboard-fill "></i>
                     <span>Notes</span>
                   </a>
             <ul id="grades" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                <li class="sidebar-item">
                 <a href="semestreNote.php" class="sidebar-link a">Consulter</a>
               </li>
                <li class="sidebar-item">
            <a href="#" class="sidebar-link a">Exporter en CSV</a>
              </li>
            </ul>
         </li>
                
                
                <hr class="h-color mx-2">
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link">
                         <i class="bi bi-person-fill"></i>
                        <span>Profile</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link">
                     <i class="bi bi-people-fill"></i>
                        <span>Personnel</span>
                    </a>
                </li>
            </ul>
            <div class="sidebar-footer">
                <a href="../logout/logout.php" class="sidebar-link">
                <i class="bi bi-box-arrow-left"></i>
                    <span>Logout</span>
                </a>
            </div>
        </aside>

    <div class="main">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</body>

</html>