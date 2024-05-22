<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceuil</title>
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

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
@media (min-width: 768px) {}</style>
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
       <!-- Content Row -->
         <div class="row justify-content-center ">
         <div class="col-xl-3 col-md-6 mb-4">
                  <div class="card border-left-primary shadow h-100 py-2">
                      <div class="card-body">
                          <div class="row no-gutters align-items-center">
                              <div class="col mr-2">
                                  <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                  Gérer les profs</div>
                              </div>
                              <div class="col-auto">
                              <i class="bi bi-person-plus fs-3"></i>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
              <div class="col-xl-3 col-md-6 mb-4">
                  <div class="card border-left-primary shadow h-100 py-2">
                      <div class="card-body">
                          <div class="row no-gutters align-items-center">
                              <div class="col mr-2">
                                  <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                  Gérer les étudiants </div>
                              </div>
                              <div class="col-auto">
                              <i class="bi bi-people-fill fs-3"></i>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
         </div>
         <div class="row justify-content-center ">
           <div class="col-xl-3 col-md-6 mb-4">
                  <div class="card border-left-primary shadow h-100 py-2">
                      <div class="card-body">
                          <div class="row no-gutters align-items-center">
                              <div class="col mr-2">
                                  <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                      Emploi du temps</div>
                              </div>
                              <div class="col-auto">
                              <i class="bi bi-calendar  fs-2"></i>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
    
              <!-- Earnings (Monthly) Card Example -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Notes</div>
                                </div>
                                <div class="col-auto">
                                <i class="bi bi-mortarboard-fill fs-2"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
         </div>
    </div>
</body>

</html>