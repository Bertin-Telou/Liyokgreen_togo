<?php
$host = "localhost";
$dbname = "liyokgreen";  // ⚠️ à modifier
$username = "root";           // ⚠️ à modifier si besoin
$password = "";               // ⚠️ mot de passe MySQL si configuré

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur connexion : " . $e->getMessage());
}
?>

