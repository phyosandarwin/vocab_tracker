<?php
require_once "connection.php";
session_start();

if (!isset($_SESSION['name'])){
    die("<p style = 'color: red;'>ACCESS DENIED. Please ensure you <a href ='login.php'>login</a> first </p>");
}

if ( isset($_POST['word']) && isset($_POST['meaning']) && isset($_POST['sentence'])){
    // if there are any fields empty
    if ( strlen($_POST['word']) < 1 || strlen($_POST['meaning']) < 1 || strlen($_POST['sentence']) < 1) {
        $_SESSION['error'] = 'All fields are required';
        header("Location: add.php");
        return;
    }
    // insert record into database
    else{
        $date = date("Y-m-d");
        $word = htmlentities($_POST['word']);
        $meaning = $_POST['meaning'];
        $sentence = $_POST['sentence'];
        $stmt = $pdo->prepare('INSERT INTO entries (entry_date, word, meaning, sentence) 
                                  VALUES (:dt, :word, :def, :sentence)');
        $stmt->execute(array(
                ':dt'   => $date,
                ':word'   => $word,
                ':def'   => $meaning,
                ':sentence'   => $sentence
        ));
        $_SESSION['success'] = "Entry added!";
        header("Location: index.php");
        return;
    }
}

?>

<html>
<head>
    <title>Vocab Tracker Add Entry</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="../styles/add.css" class="stylesheet">
    
    </head>

    <body>
        <?php 
        // print any error message
        if (isset($_SESSION['error'])){
            ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong><?php echo $_SESSION['error']; ?></strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php
            unset($_SESSION['error']);
        }
        ?>
        <div class="card">
            <div class="card-header">
                <h3><b>Add a new word today!</b></h3>
            </div>
            <div class="card-body">

            <form method="post">

                <div class="form-group">    
                    <label for="word">Word:</label>
                    <input type="text" class= "form-control" id ="word" name="word"/><br/>
                </div>
                <div class="form-group">
                    <label for="meaning">Definition:</label>
                    <textarea class="form-control" id="meaning" name="meaning" rows="4" placeholder="The meaning is ..."></textarea><br/>
                </div>
                <div class="form-group">
                    <label for="sentence">Sentence Use:</label>
                    <textarea name="sentence" id="sentence" class="form-control" rows="6" placeholder="A sentence example is..."></textarea><br/>
                </div>
                <div>
                <button class="btn btn-primary btn-sm" type="submit">Add Word</button>
                <a class="btn btn-secondary btn-sm" href="index.php" role="button">Cancel</a>    
                </div>
            </form>
            </div>
        </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    </body>
</html>