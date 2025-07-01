<?php
$conn = new mysqli("localhost", "root", "", "LaFerme");

// AJOUT
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["ajouter"])) {
    $type = $_POST["type_operation"];
    $montant = $_POST["montant"];
    $description = $_POST["description"];
    $date = $_POST["date_operation"];

    $sql = "INSERT INTO finances (type_operation, montant, description, date_operation)
            VALUES ('$type', $montant, '$description', '$date')";
    $conn->query($sql);
    header("Location: finance.php");
}

// SUPPRESSION
if (isset($_GET["supprimer"])) {
    $id = $_GET["supprimer"];
    $conn->query("DELETE FROM finances WHERE id = $id");
    header("Location: finance.php");
}

// FORMULAIRE MODIFICATION
if (isset($_GET["modifier"])) {
    $id = $_GET["modifier"];
    $modif = $conn->query("SELECT * FROM finances WHERE id = $id")->fetch_assoc();
}

// TRAITEMENT MODIFICATION
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["modifier"])) {
    $id = $_POST["id"];
    $type = $_POST["type_operation"];
    $montant = $_POST["montant"];
    $description = $_POST["description"];
    $date = $_POST["date_operation"];

    $sql = "UPDATE finances SET type_operation='$type', montant=$montant, description='$description', date_operation='$date' WHERE id=$id";
    $conn->query($sql);
    header("Location: finance.php");
}

// AFFICHAGE
$result = $conn->query("SELECT * FROM finances");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Finances - LaFerme</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
     <a href="index.php" class="btn-retour">← Retour </a>

<h2><?= isset($modif) ? "Modifier une Opération Financière" : "Ajouter une Opération Financière" ?></h2>
<form method="post">
    <input type="hidden" name="id" value="<?= $modif['id'] ?? '' ?>">
    
    Type: 
    <select name="type_operation" required>
        <option value="recette" <?= (isset($modif) && $modif["type_operation"] == "recette") ? "selected" : "" ?>>Recette</option>
        <option value="dépense" <?= (isset($modif) && $modif["type_operation"] == "dépense") ? "selected" : "" ?>>Dépense</option>
    </select>

    Montant: <input name="montant" type="number" step="0.01" value="<?= $modif['montant'] ?? '' ?>" required>
    Description: <input name="description" value="<?= $modif['description'] ?? '' ?>">
    Date: <input name="date_operation" type="date" value="<?= $modif['date_operation'] ?? '' ?>" required>

    <?php if (isset($modif)) { ?>
        <button type="submit" name="modifier">Modifier</button>
        <a href="finance.php">Annuler</a>
    <?php } else { ?>
        <button type="submit" name="ajouter">Ajouter</button>
    <?php } ?>
</form>

<h2>Liste des Opérations Financières</h2>
<table border="1" cellpadding="5">
    <tr><th>Type</th><th>Montant</th><th>Description</th><th>Date</th><th>Actions</th></tr>
    <?php while($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?= $row["type_operation"] ?></td>
            <td><?= number_format($row["montant"], 2, ',', ' ') ?> FCFA</td>
            <td><?= $row["description"] ?></td>
            <td><?= $row["date_operation"] ?></td>
            <td>
                <a href="?modifier=<?= $row["id"] ?>">Modifier</a> |
                <a href="?supprimer=<?= $row["id"] ?>" onclick="return confirm('Supprimer cette opération ?')">Supprimer</a>
            </td>
        </tr>
    <?php } ?>
</table>

</body>
</html>