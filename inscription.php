<?php
session_start();
$succes = "";
$erreur = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
     $nom = $_POST["nom"];
     $prenom = $_POST["prenom"];
     $email = $_POST["email"];
     $mot_de_passe = $_POST["mot_de_passe"];
     $confirmation = $_POST["confirmation"];

    if ($mot_de_passe !== $confirmation) {
        $erreur = "Les mots de passe ne correspondent pas.";
    } else {
        $conn = new mysqli("localhost", "root", "", "LaFerme");

        if ($conn->connect_error) {
            die("Erreur de connexion : " . $conn->connect_error);
        }

        // Sécurité contre les injections SQL
        $prenom = $conn->real_escape_string($prenom);
        $nom = $conn->real_escape_string($nom);
        $email = $conn->real_escape_string($email);
        $mot_de_passe_hash = password_hash($mot_de_passe, PASSWORD_DEFAULT);

        // Vérifie si l'email existe déjà
        $check = $conn->query("SELECT * FROM utilisateurs WHERE email='$email'");
        if ($check->num_rows > 0) {
            $erreur = "Un compte avec cet email existe déjà.";
        } else {
            $sql = "INSERT INTO utilisateurs (nom, prenom, email, mot_de_passe) 
                    VALUES ('$nom', '$prenom', '$email', '$mot_de_passe_hash')";
            if ($conn->query($sql)) {
                $succes = "Inscription réussie ! Vous pouvez vous connecter.";
            } else {
                $erreur = "Erreur lors de l'inscription.";
            }
        }

        $conn->close();
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription - LaFerme</title>
    <link rel="stylesheet" href="auth.css"> <!-- Ou style.css si tu préfères -->
</head>
<body>
    <div class="auth-container">
        <h2>Inscription</h2>

        <?php if ($erreur): ?>
            <div class="message erreur"><?= htmlspecialchars($erreur) ?></div>
        <?php endif; ?>
        <?php if ($succes): ?>
            <div class="message succes"><?= htmlspecialchars($succes) ?></div>
        <?php endif; ?>

        <form method="post">
            <input type="text" name="nom" placeholder="Nom" required>
            <input type="text" name="prenom" placeholder="Prénom" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="mot_de_passe" placeholder="Mot de passe" required>
            <input type="password" name="confirmation" placeholder="Confirmer le mot de passe" required>
            <button type="submit">S'inscrire</button>
        </form>

        <div class="auth-links">
            <a href="connexion.php">Déjà inscrit ? Connexion</a>
        </div>
    </div>
</body>
</html>