<?php
// 1) Database settings – update if your MySQL user/pass differ
define('DB_HOST','127.0.0.1');
define('DB_NAME','hair_salon');
define('DB_USER','root');
define('DB_PASS','1234');   // XAMPP default

// 2) Connect via PDO
try {
  $pdo = new PDO(
    "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8",
    DB_USER, DB_PASS,
    [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION]
  );
} catch (PDOException $e) {
  die("DB Error: " . $e->getMessage());
}

// 3) Start the session for login state
session_start();
?>
