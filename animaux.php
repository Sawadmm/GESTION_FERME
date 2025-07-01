<?php
$conn = new mysqli("localhost", "root", "", "LaFerme");

// AJOUT
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["ajouter"])) {
    $nom = $_POST["nom"];
    $type = $_POST["type"];
    $quantite = $_POST["quantite"];
    $date = date("Y-m-d");

    $sql = "INSERT INTO animaux (nom, type, quantite, date_ajout) 
            VALUES ('$nom', '$type', $quantite, '$date')";
    $conn->query($sql);
    header("Location: animaux.php");
}

// SUPPRESSION
if (isset($_GET["supprimer"])) {
    $id = $_GET["supprimer"];
    $conn->query("DELETE FROM animaux WHERE id = $id");
    header("Location: animaux.php");
}

// FORMULAIRE MODIFICATION
if (isset($_GET["modifier"])) {
    $id = $_GET["modifier"];
    $modif = $conn->query("SELECT * FROM animaux WHERE id = $id")->fetch_assoc();
}

// TRAITEMENT MODIFICATION
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["modifier"])) {
    $id = $_POST["id"];
    $nom = $_POST["nom"];
    $type = $_POST["type"];
    $quantite = $_POST["quantite"];
    $sql = "UPDATE animaux SET nom='$nom', type='$type', quantite=$quantite WHERE id=$id";
    $conn->query($sql);
    header("Location: animaux.php");
}

// LISTE
$result = $conn->query("SELECT * FROM animaux");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Animaux - SawaFarm</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <a href="index.php" class="btn-retour">← Retour </a>

    <h2><?= isset($modif) ? "Modifier un animal" : "Ajouter un animal" ?></h2>
    <form method="post">
        <input type="hidden" name="id" value="<?= $modif['id'] ?? '' ?>">
        Nom: <input name="nom" value="<?= $modif['nom'] ?? '' ?>" required>
        Type: <input name="type" value="<?= $modif['type'] ?? '' ?>" required>
        Quantité: <input name="quantite" type="number" value="<?= $modif['quantite'] ?? '' ?>" required>
        
        <?php if (isset($modif)) { ?>
            <button type="submit" name="modifier">Modifier</button>
            <a href="animaux.php">Annuler</a>
        <?php } else { ?>
            <button type="submit" name="ajouter">Ajouter</button>
        <?php } ?>
    </form>

    <h2>Liste des animaux</h2>
    <table border="1" cellpadding="5">
        <tr><th>Nom</th><th>Type</th><th>Quantité</th><th>Date</th><th>Actions</th></tr>
        <?php while($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?= $row["nom"] ?></td>
                <td><?= $row["type"] ?></td>
                <td><?= $row["quantite"] ?></td>
                <td><?= $row["date_ajout"] ?></td>
                <td>
                    <a href="?modifier=<?= $row['id'] ?>">Modifier</a> | 
                    <a href="?supprimer=<?= $row['id'] ?>" onclick="return confirm('Supprimer cet animal ?')">Supprimer</a>
                </td>
            </tr>
        <?php } ?>
    </table>

</body>
</html>