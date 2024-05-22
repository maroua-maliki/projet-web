<?php
include("connect.php");

$sql = "SELECT * FROM `utilisateur` WHERE role IN ('professeur', 'chef_departement', 'coordinateur') ORDER BY nom ASC";
$result = mysqli_query($con, $sql);

// Fetch subjects to populate the dropdown
$subjects_query = "SELECT id, nom FROM module ORDER BY nom ASC";
$subjects_result = mysqli_query($con, $subjects_query);
$subjects = [];
while ($subject = mysqli_fetch_assoc($subjects_result)) {
    $subjects[] = $subject;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle the form submission to assign subjects to professors
    $prof_id = $_POST['prof_id'];
    $subject_id = $_POST['subject_id'];
    
    // Assuming you have a table to store this relationship, e.g., `prof_subject`
    $assign_query = "INSERT INTO affectation_module_professeur (professeur_id, module_id ) VALUES ('$prof_id', '$subject_id') ON DUPLICATE KEY UPDATE module_id ='$subject_id'";
    mysqli_query($con, $assign_query);
    header("Location: ".$_SERVER['PHP_SELF']);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="bootstrap/bootstrap-5.3.3-dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Personnel</title>
</head>
<body>
    <div class="container">
        <table class="table text-start" >
            <thead class="table-primary">
                <tr>
                    <th scope="col">Nom</th>
                    <th scope="col">Prénom</th>
                    <th scope="col">Email</th>
                    <th scope="col">Assigner Module</th>
                    <th scope="col" class=" text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?php echo $row["nom"] ?></td>
                        <td><?php echo $row["prenom"] ?></td>
                        <td><?php echo $row["email"] ?></td>
                        <td>
                            <form method="POST" class="d-flex">
                                <input type="hidden" name="prof_id" value="<?php echo $row['id']; ?>">
                                <select name="subject_id" class="form-select" required>
                                    <option value="">Choisir un module</option>
                                    <?php foreach ($subjects as $subject) { ?>
                                        <option value="<?php echo $subject['id']; ?>"><?php echo $subject['nom']; ?></option>
                                    <?php } ?>
                                </select>
                        </td>
                        <td class=" text-center">
                                <button type="submit" class="btn btn-primary ">Assigner</button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>
