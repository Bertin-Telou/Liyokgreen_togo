<?php
require 'config.php'; // Connexion PDO

if (isset($_POST['register'])) {
    $nom = trim($_POST['nom']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];

    // Vérifier que les champs ne sont pas vides
    if (!empty($nom) && !empty($email) && !empty($password) && !empty($password_confirm)) {
        
        // Vérifier la correspondance des mots de passe
        if ($password === $password_confirm) {
            
            // Vérifier si l’email existe déjà
            $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
            $stmt->execute([$email]);
            if ($stmt->rowCount() > 0) {
                echo "❌ Cet email est déjà utilisé.";
            } else {
                // Hashage du mot de passe
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                // Insertion en base
                $insert = $pdo->prepare("INSERT INTO users (nom, email, password) VALUES (?, ?, ?)");
                $insert->execute([$nom, $email, $hashedPassword]);

                echo "✅ Inscription réussie ! Vous pouvez vous connecter.";
            }
        } else {
            echo "⚠️ Les mots de passe ne correspondent pas.";
        }
    } else {
        echo "⚠️ Veuillez remplir tous les champs.";
    }
}
?>

