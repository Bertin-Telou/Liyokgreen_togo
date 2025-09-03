<?php
session_start();
require 'config.php'; // fichier de connexion PDO

if (isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (!empty($email) && !empty($password)) {
        // Vérifier si l’utilisateur existe
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            // Créer une session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_nom'] = $user['nom'];
            $_SESSION['user_email'] = $user['email'];

            // "Se rappeler de moi" → Cookie valable 7 jours
            if (isset($_POST['remember'])) {
                setcookie("user_id", $user['id'], time() + (7 * 24 * 60 * 60), "/");
            }

            // Rediriger vers la page d’accueil personnalisée
            header("Location: home.php?id=" . $user['id']);
            exit;
        } else {
            echo "❌ Email ou mot de passe incorrect.";
        }
    } else {
        echo "⚠️ Veuillez remplir tous les champs.";
    }
}
?>

