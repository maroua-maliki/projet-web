<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NavBar</title>
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        nav {
	background: var(--light);
	height: 64px;
	padding: 0 20px;
	display: flex;
	align-items: center;
	grid-gap: 28px;
	position: sticky;
	top: 0;
	left: 0;
	z-index: 100;
}
nav .toggle-sidebar {
	font-size: 18px;
	cursor: pointer;
}
nav form {
	max-width: 400px;
	width: 100%;
	margin-right: auto;
}
nav .form-group {
	position: relative;
}
nav .form-group input {
	width: 100%;
	background: var(--grey);
	border-radius: 5px;
	border: none;
	outline: none;
	padding: 10px 36px 10px 16px;
	transition: all .3s ease;
}
nav .form-group input:focus {
	box-shadow: 0 0 0 1px var(--blue), 0 0 0 4px var(--light-blue);
}
nav .form-group .icon {
	position: absolute;
	top: 50%;
	transform: translateY(-50%);
	right: 16px;
	color: var(--dark-grey);
}
nav .nav-link {
	position: relative;
}
nav .nav-link .icon {
	font-size: 18px;
	color: var(--dark);
}
nav .nav-link .badge {
	position: absolute;
	top: -12px;
	right: -12px;
	width: 20px;
	height: 20px;
	border-radius: 50%;
	border: 2px solid var(--light);
	background: var(--red);
	display: flex;
	justify-content: center;
	align-items: center;
	color: var(--light);
	font-size: 10px;
	font-weight: 700;
}
nav .divider {
	width: 1px;
	background: var(--grey);
	height: 12px;
	display: block;
}
nav .profile {
	position: relative;
}
nav .profile img {
	width: 36px;
	height: 36px;
	border-radius: 50%;
	object-fit: cover;
	cursor: pointer;
}
nav .profile .profile-link {
	position: absolute;
	top: calc(100% + 10px);
	right: 0;
	background: #fff;
	padding: 10px 0;
	box-shadow: 4px 4px 16px rgba(0, 0, 0, .1);
	border-radius: 10px;
	width: 160px;
	opacity: 0;
	pointer-events: none;
	transition: all .3s ease;
}
nav .profile .profile-link.show {
	opacity: 1;
	pointer-events: visible;
	top: 100%;
}
nav .profile .profile-link a {
	padding: 10px 16px;
	display: flex;
	grid-gap: 10px;
	font-size: 14px;
	color: var(--dark);
	align-items: center;
	transition: all .3s ease;
    text-decoration: none;
}
nav .profile .profile-link a:hover {
	background: var(--grey);
}
</style>
</head>
<body>
     <!-- NAVBAR -->
     <section id="content">
		<!-- NAVBAR -->
		<nav>
			<i class='bx bx-menu toggle-sidebar' ></i>
			 <!-- Topbar Search -->
                    <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-50 navbar-search custom-search-form bg-custom">
                      <div class="input-group w-100">
                         <input type="text" class="form-control  border-0 small search-input " style="background-color: #eee;"placeholder="Search for..."
                           aria-label="Search" aria-describedby="basic-addon2">
                         <div class="input-group-append">
                              <button class="btn btn-primary" type="button">
                              <i class="bi bi-search"></i>
                               </button>
                         </div>
                     </div>
                     </form>
			<span class="divider"></span>
			<div class="profile">
				<img src="../image/profile.png" alt="">
				<span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $student_nom;?> <?php echo $student_prenom  ?></span>
				<ul class="profile-link">
					<li><a href="#"><i class='bx bxs-user-circle icon' ></i> Profile</a></li>
					<li><a href="../logout/logout.php"><i class='bx bxs-log-out-circle' ></i> Logout</a></li>
				</ul>
			</div>
		</nav>
		<!-- NAVBAR -->
       </section>
	   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <script >const hamBurger = document.querySelector(".toggle-btn");

hamBurger.addEventListener("click", function () {
  document.querySelector("#sidebar").classList.toggle("expand");
});
// PROFILE DROPDOWN
const profile = document.querySelector('nav .profile');
const imgProfile = profile.querySelector('img');
const dropdownProfile = profile.querySelector('.profile-link');

imgProfile.addEventListener('click', function () {
	dropdownProfile.classList.toggle('show');
})

</script>
</body>
</html>