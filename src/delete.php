<?php
require_once "connection.php";
session_start();

if (!isset($_SESSION['name'])){
    die("<p style = 'color: red;'>ACCESS DENIED. Please ensure you <a href ='login.php'>login</a> first </p>");
}

if ( isset ($_POST['cancel'])){
    header("Location: index.php");
    return;
}
if ( isset($_POST['entry_id']) ) {
    $sql = "DELETE FROM entries WHERE entry_id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(':id' => $_POST['entry_id']));
    $_SESSION['success'] = 'Record deleted!';
    header( 'Location: index.php' ) ;
    return;
}

// Guardian: Make sure that user_id is present
if ( ! isset($_GET['entry_id']) ) {
  $_SESSION['error'] = "Missing entry id!";
  header('Location: index.php');
  return;
}

$stmt = $pdo->prepare("SELECT word, entry_id FROM entries where entry_id = :id");
$stmt->execute(array(":id" => $_GET['entry_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
    $_SESSION['error'] = 'Bad value for entry_id!';
    header( 'Location: index.php' ) ;
    return;
}

?>
<html>
    <head>
        <title>Vocab Tracker Delete Page</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet" href="../styles/delete.css" class="stylesheet">
    </head>
<body>
<div class="card text-center" style="position: absolute; transform: translate(-50%, -50%); top: 50%; left: 50%; height:auto;">
    <div class="card-header">Confirm Deletion</div>
    <div class="card-body">
        <p>Deleting the word<b><?= htmlentities($row['word']) ?></b>...</p>
        <form method= "post">
            <input type="hidden" name="entry_id" value="<?= $row['entry_id'] ?>">
            <button class="btn btn-danger btn-sm" type="submit" name= "delete">Delete</button>
            <button class="btn btn-secondary btn-sm" type="submit" name= "cancel">Cancel</button>
        </form>
    </div>
</div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>