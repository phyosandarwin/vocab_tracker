<?php
$pdo = new PDO('mysql:host=localhost;port=3306;dbname=vocab', 
'sam', '3101');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sql = "CREATE TABLE IF NOT EXISTS entries (
  entry_id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
  word VARCHAR(255),
  entry_date DATE,
  meaning TEXT,
  sentence TEXT
)";

try {
    $pdo->exec($sql);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>

