<?php
require_once "connection.php";
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="styles/index.css" rel="stylesheet">
    <title>Vocab Tracker Index</title>
</head>
<body>
    <div class="container" style="margin-top: 20px">
    <h1>Welcome to <span style = 'color:skyblue';>Vocab Tracker</span></h1><br/>
    <?php
    if (!isset($_SESSION['name'])){
        echo '<a class="btn btn-primary btn-sm" href="login.php" role="button">Please login first</a>';
    }
    // logged in 
    else {
        // display successful record insertion msg
        if (isset($_SESSION['success'])){
            echo '<p style="color:green; font-weight: 600; font-size: 20px" >'.$_SESSION['success']."</p>\n";
            unset($_SESSION['success']);
        }
        else if (isset($_SESSION['error'])){
            echo '<p style="color:red; font-weight: 600; font-size: 20px">'.$_SESSION['error']."</p>\n";
            unset($_SESSION['error']);
        }
        ?>
        <div class="card" >
            <div class="card-header" style='font-size: 20px'>
                <b>Vocabulary Records</b>
            </div>
            <div class="card-body">
            <?php
            //EXTRACT RECORDS
            $sql = "SELECT * FROM entries";
            $stmt = $pdo->query($sql);
            // check if there are any records
            if ($stmt->rowCount() == 0){
                echo("<p style='color:red'>No rows found</p>");
            }
            else{
                // if there are records, display them in a table with headers
                echo "<table class='table'>";
                echo"<thead>
                        <tr>
                            <th width='10%'>Entry Date</th>
                            <th width='15%'>Word</th>
                            <th width='15%'>Definition</th>
                            <th width='20%'>Sentence</th>
                            <th width='15%'>Action</th>
                        </tr>
                    </thead>
                    ";
                echo "<tbody>";
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $id = $row['entry_id'];
                    $date = $row['entry_date'];
                    $word = $row['word'];
                    $meaning = $row['meaning'];
                    $sentence = $row['sentence'];
                    echo "<tr>
                    <td>'.$date.'</td>
                    <td>'.$word.'</td>
                    <td>'.$meaning.'</td>
                    <td>'.$sentence.'</td>
                    <td>
                    <button class='btn btn-primary btn-sm'><a href='edit.php?entry_id=$id' style='color: white; text-decoration:none'>Edit</a></button>
                    <button class='btn btn-danger btn-sm'><a href='delete.php?entry_id=$id' style='color: white; text-decoration:none'>Delete</a></button>                    
                    </tr>";
                }
                echo "</table>";
            }
        ?>
            </div>
            
        </div>
        <?php
        echo "<br/>";
        echo '<a class="btn btn-primary" href="add.php" role="button">Add new entry</a>';
        echo "\n";
        echo '<a class="btn btn-secondary" href="logout.php" role="button">Logout</a>';
        }
        ?>
        
        
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>