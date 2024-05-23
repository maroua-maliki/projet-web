<?php
include("../connect.php");
// Fetch all modules
if(session_status() === PHP_SESSION_NONE) {
    session_start();
}
if(isset($_SESSION['id'])) {
    $prof_id = $_SESSION['id'];
} else {
    header("Location: ../login.php");
    exit; 
}
$subjects_query = "SELECT  m.nom , a.id, m.id
FROM affectation_module_professeur a
INNER JOIN module m ON a.module_id = m.id
WHERE a.professeur_id='$prof_id' ORDER BY m.nom ASC";
$subjects_result = mysqli_query($con, $subjects_query);
$subjects = [];
while ($subject = mysqli_fetch_assoc($subjects_result)) {
    $subjects[] = $subject;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../bootstrap/bootstrap-5.3.3-dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Assign Module</title>
    <style>
        .student-list {
            margin-top: 20px;
        }
    </style>
</head>
<body>
<?php 
    include("sidebar.php");
    include("../navbar/navbar.php");
?>
    <div class="container">
        <h1 class="mt-2 mb-3 text-center text-primary">Liste des Étudiants</h1>
        <form class="d-flex justify-content-center mb-3">
            <div class="col-auto">
                <select name="subject_id" class="form-select" onchange="fetchStudents(this.value)" required>
                    <option value="">Choisir un module</option>
                    <?php foreach ($subjects as $subject) { ?>
                        <option value="<?php echo $subject['id']; ?>"><?php echo $subject['nom']; ?></option>
                    <?php } ?>
                </select>
            </div>
        </form>
        <div class="student-list" id="student-list">
            <!-- Student list will be displayed here -->
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script>
        function fetchStudents(moduleId) {
            if (moduleId === "") {
                document.getElementById('student-list').innerHTML = "";
                return;
            }
            const xhr = new XMLHttpRequest();
            xhr.open("GET", "fetch_students.php?module_id=" + moduleId, true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    document.getElementById('student-list').innerHTML = xhr.responseText;
                }
            };
            xhr.send();
        }
    </script>
</body>
</html>
