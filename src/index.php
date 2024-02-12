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
    <link href="../styles/index.css" rel="stylesheet">
    <title>Vocab Tracker Index</title>
</head>
<body>
    <div class="container" style="margin-top: 20px">
    <h1 class="text-center mt-5 mb-3" >Welcome to <span style = 'color:steelblue; font-weight:800;';>VocabTracker</span></h1><br/>
    <?php
    if (!isset($_SESSION['name'])){
        echo
        "
        <div class='accordion' id='accordionExample' mb-5>
            <div class='accordion-item'>
                <h2 class='accordion-header' id='headingOne'>
                <button class='accordion-button' type='button' data-bs-toggle='collapse' data-bs-target='#collapseOne' aria-expanded='true' aria-controls='collapseOne'>
                    What is VocabTracker?
                </button>
                </h2>
                <div id='collapseOne' class='accordion-collapse collapse show' aria-labelledby='headingOne' data-bs-parent='#accordionExample'>
                <div class='accordion-body'>
                    VocabTracker is a simple PHP+MySQL application leveraging on CRUD operations. For every new vocabulary that I come to learn of
                    once in a blue moon, it would be nice to store it in an online platform that allows me to focus on learning and reviewing the terms, and 
                    not just refer to the Notes App which stores everything else (it's kind of messy). <br/><br/> So I decided to make this vocabulary tracker application designed for this sole purpose! 
                </div>
                </div>
            </div>
        
        <div class='col text-center mt-5'> 
            <a class='btn btn-primary btn-lg' href='login.php' role='button'>Please login first</a>
        </div>";
    }
    // logged in 
    else {
        ?>

        <input type="text" class="form-control" id="live-search" autocomplete="off" placeholder="Search word...">
        <div id = "searchresult" style="display: none;"></div><!-- Initially hidden, shown when search is made -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function(){
                $("#live-search").keyup(function(){
                    var search_input = $(this).val();
                    if (search_input != ""){
                        $.ajax({
                            url: "livesearch.php",
                            method: "POST",
                            data:{input: search_input},

                            success:function(data){
                                $("#searchresult").html(data).show();
                                $("#all-records").hide();
                            }
                        });
                    }else{
                        $("#searchresult").hide();
                        $("#all-records").show()
                    }
                });   
            });
        </script>

        <div class="card mt-3" id="all-records">
            <?php
            // display successful record insertion msg
            if (isset($_SESSION['success'])){
                ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong><?php echo $_SESSION['success']; ?></strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php
                unset($_SESSION['success']);
            }
            else if (isset($_SESSION['error'])){
                ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong><?php echo $_SESSION['error']; ?></strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php
                unset($_SESSION['error']);
            }
            ?>

            <div class="card-header" style='font-size: 20px; font-weight: 400'>
                <b>Vocabulary Records</b>
            </div>
            <div class="card-body">
            <?php
            //EXTRACT RECORDS
            $sql = "SELECT * FROM entries";
            $stmt = $pdo->query($sql);
            // check if there are any records

            if ($stmt->rowCount() > 0){
                echo "<div class='table-responsive'>
                    <table class='table table-hover'>
                    <thead class='table-light'>
                        <tr>
                            <th width='10%'>Entry Date</th>
                            <th width='15%'>Word</th>
                            <th width='15%'>Definition</th>
                            <th width='20%'>Sentence</th>
                            <th width='15%'>Action</th>
                        </tr>
                    </thead>
                    <tbody>";
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $id = $row['entry_id'];
                    $date = $row['entry_date'];
                    $word = $row['word'];
                    $meaning = $row['meaning'];
                    $sentence = $row['sentence'];
                    echo "<tr>
                    <td>{$date}</td>
                    <td>{$word}</td>
                    <td>{$meaning}</td>
                    <td>{$sentence}</td>
                    <td>
                        <div class ='btn-group mr-2' role='group' aria-label='Edit/Delete entry'>
                        <a href= 'edit.php?entry_id={$id}' class='btn btn-warning btn-sm' role = 'button' aria-pressed ='true' style='color: black'>Edit</a>
                        <a href= 'delete.php?entry_id={$id}' class='btn btn-danger btn-sm' role = 'button' aria-pressed ='true' style='color: white'>Delete</a>
                        </div>
                    </td>
                    </tr>";
                }
                echo "</table></div>";
            }
            else{
                echo("<p style='color:red'>No records found.</p>");
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
<footer class="bg-info text-center text-lg-start fixed-bottom">
  <div class="text-center p-3" style="background-color: white;">
    © 2024 Copyright Phyo Sandar Win
  </div>
</footer>
</html>