<?php
session_start();
$erreur = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $mot_de_passe = $_POST["mot_de_passe"];

    $conn = new mysqli("localhost", "root", "", "LaFerme");

    if ($conn->connect_error) {
        die("Erreur de connexion : " . $conn->connect_error);
    }

    $email = $conn->real_escape_string($email);
    $sql = "SELECT * FROM utilisateurs WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows == 1) {
        $utilisateur = $result->fetch_assoc();
        if (password_verify($mot_de_passe, $utilisateur["mot_de_passe"])) {
            $_SESSION["utilisateur"] = $utilisateur["email"];
            header("Location: index.php");
            exit();
        } else {
            $erreur = "Mot de passe incorrect.";
        }
    } else {
        $erreur = "Aucun utilisateur trouvé avec cet email.";
    }

    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion - LaFerme</title>
    <link rel="stylesheet" href="auth.css"> 
</head>
<body>
    <div class="auth-container">
        <h2>Connexion</h2>

        <?php if ($erreur): ?>
            <div class="message erreur"><?= htmlspecialchars($erreur) ?></div>
        <?php endif; ?>

        <form method="post">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="mot_de_passe" placeholder="Mot de passe" required>
            <button type="submit">Se connecter</button>
        </form>

        <div class="auth-links">
            <a href="inscription.php">Créer un compte</a>
        </div>
    </div>
</body>
</html>