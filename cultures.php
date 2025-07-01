<?php
$conn = new mysqli("localhost", "root", "", "LaFerme");

// AJOUT
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["ajouter"])) {
    $nom = $_POST["nom"];
    $superficie = $_POST["superficie"];
    $date_semis = $_POST["date_semis"];
    $date_recolte = $_POST["date_recolte"];

    $sql = "INSERT INTO cultures (nom, superficie, date_semis, date_recolte) 
            VALUES ('$nom', $superficie, '$date_semis', '$date_recolte')";
    $conn->query($sql);
    header("Location: cultures.php");
}

// SUPPRESSION
if (isset($_GET["supprimer"])) {
    $id = $_GET["supprimer"];
    $conn->query("DELETE FROM cultures WHERE id = $id");
    header("Location: cultures.php");
}

// FORMULAIRE MODIFICATION
if (isset($_GET["modifier"])) {
    $id = $_GET["modifier"];
    $modif = $conn->query("SELECT * FROM cultures WHERE id = $id")->fetch_assoc();
}

// TRAITEMENT MODIFICATION
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["modifier"])) {
    $id = $_POST["id"];
    $nom = $_POST["nom"];
    $superficie = $_POST["superficie"];
    $date_semis = $_POST["date_semis"];
    $date_recolte = $_POST["date_recolte"];

    $sql = "UPDATE cultures SET nom='$nom', superficie=$superficie, date_semis='$date_semis', date_recolte='$date_recolte' WHERE id=$id";
    $conn->query($sql);
    header("Location: cultures.php");
}

// AFFICHAGE
$result = $conn->query("SELECT * FROM cultures");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Liste des Cultures - LaFerme</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
 <a href="index.php" class="btn-retour">← Retour </a>
    <h2><?= isset($modif) ? "Modifier une Culture" : "Ajouter une Culture" ?></h2>
    <form method="post">
        <input type="hidden" name="id" value="<?= $modif['id'] ?? '' ?>">
        Nom: <input name="nom" value="<?= $modif['nom'] ?? '' ?>" required>
        Superficie: <input name="superficie" type="number" step="0.01" value="<?= $modif['superficie'] ?? '' ?>" required>
        Date de semis: <input name="date_semis" type="date" value="<?= $modif['date_semis'] ?? '' ?>" required>
        Date de récolte: <input name="date_recolte" type="date" value="<?= $modif['date_recolte'] ?? '' ?>">
        
        <?php if (isset($modif)) { ?>
            <button type="submit" name="modifier">Modifier</button>
            <a href="cultures.php">Annuler</a>
        <?php } else { ?>
            <button type="submit" name="ajouter">Ajouter</button>
        <?php } ?>
    </form>

    <h2>Liste des Cultures</h2>
    <table border="1" cellpadding="5">
        <tr><th>Nom</th><th>Superficie (ha)</th><th>Date de semis</th><th>Date de récolte</th><th>Actions</th></tr>
        <?php while($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?= $row["nom"] ?></td>
                <td><?= $row["superficie"] ?></td>
                <td><?= $row["date_semis"] ?></td>
                <td><?= $row["date_recolte"] ?></td>
                <td>
                    <a href="?modifier=<?= $row['id'] ?>">Modifier</a> |
                    <a href="?supprimer=<?= $row['id'] ?>" onclick="return confirm('Supprimer cette culture ?')">Supprimer</a>
                </td>
            </tr>
        <?php } ?>
    </table>

</body>
</html>