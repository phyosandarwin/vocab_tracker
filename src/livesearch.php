<?php
include "connection.php";
?>

<div class = "card mt-3" >
    <div class="card-header" style='font-size: 20px; font-weight: 400'>
        <b>Vocabulary Records</b>
    </div>
    <div class="card-body">
    <?php
    if (isset($_POST['input'])){
        $input = $_POST['input'];
        // rank search results by starting similar letter (rank 1)
        $sql = "SELECT * FROM entries WHERE word LIKE '%$input%' ORDER BY CASE WHEN word LIKE '$input%' THEN 1 WHEN word LIKE '%$input' THEN 3 ELSE 2 END, word LIMIT 5";
;
        $stmt = $pdo->query($sql);
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
        }else{
            echo("<p style='color:red'>No records found.</p>");
        }
    }
    ?>
    </div>
</div>