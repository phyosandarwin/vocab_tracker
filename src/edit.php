<?php
require_once "connection.php";
session_start();

if (!isset($_SESSION['name'])){
    die("ACCESS DENIED. Please ensure you <a href ='login.php'>login</a> first");
}

// Guardian: Make sure that entry_id is present in the query string
if (!isset($_GET['entry_id'])) {
    $_SESSION['error'] = "Missing entry_id!";
    header('Location: index.php');
    return;
}

// Fetch the existing entry from the database
$stmt = $pdo->prepare("SELECT * FROM entries WHERE entry_id = :id");
$stmt->execute(array(":id" => $_GET['entry_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);

// Check if the entry with the provided entry_id exists
if ($row === false) {
    $_SESSION['error'] = 'Bad value for entry_id!';
    header('Location: index.php');
    return;
}

if (  isset($_POST['word']) && isset($_POST['meaning']) && isset($_POST['sentence']) ) {

    // Data validation
    if ( strlen($_POST['word']) < 1 || strlen($_POST['meaning']) < 1 || 
        strlen($_POST['sentence']) < 1 ) {
        $_SESSION['error'] = 'All fields are required';
        header("Location: edit.php?entry_id=".$_POST['entry_id']);
        return;
    }

    $sql = "UPDATE entries SET word = :word, meaning = :meaning, sentence = :sentence
            WHERE entry_id = :entry_id";
            
    $stmt = $pdo->prepare($sql);
    
    $stmt->execute(array(
        ':word' => $_POST['word'],
        ':meaning' => $_POST['meaning'],
        ':sentence' => $_POST['sentence'],
        ':entry_id' => $_POST['entry_id']));
        
    $_SESSION['success'] = 'Record updated!';
    header( 'Location: index.php' ) ;
    return;
    
}

else {
    $_SESSION['error'] = 'Record not updated!';
    header( 'Location: index.php' ) ;
}

$word = htmlspecialchars($row['word'], ENT_QUOTES, 'UTF-8');
$meaning = htmlspecialchars($row['meaning'], ENT_QUOTES, 'UTF-8');
$sentence = htmlspecialchars($row['sentence'], ENT_QUOTES, 'UTF-8');
$entryid = $row['entry_id'];
?>

<html>
    <head>
    <title>Vocab Tracker Edit Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="styles/edit.css">
    </head>
    <body>
        <?php
            // Flash pattern - show the error messages while editing the records
            if ( isset($_SESSION['error']) ) {
                echo '<p style="color:red; font-weight: 600; font-size: 20px">'.$_SESSION['error']."</p>\n";
                unset($_SESSION['error']);
            }
        ?>
        <div class= "card">
            <div class="card-header">
                <h3><b>Editing entry</b></h3>
            </div>
            <div class="card-body">
            <form method="post">
                <p>
                <label for="word">Word:</label>
                <input type="text" name="word" size="60" value="<?= $word ?>"/></p>
                <p>
                <label for="meaning">Definition:</label><br/>
                <textarea name="meaning" class="text-area1"><?= $meaning ?></textarea></p>
                <p>
                <label for="sentence">Sentence Use:</label><br/>
                <textarea name="sentence" class="text-area2"><?= $sentence ?></textarea></p>
                <input type="hidden" name="entry_id" value="<?= $entryid ?>">
                <br/>
                <button class="btn btn-primary btn-sm" type="submit">Save</button>
                <a class="btn btn-secondary btn-sm" href="index.php" role="button">Cancel</a>
            </form>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    </body>
</html>