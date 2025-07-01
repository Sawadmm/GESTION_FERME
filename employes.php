<?php
$conn = new mysqli("localhost", "root", "", "LaFerme");

// AJOUT
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["ajouter"])) {
    $nom = $_POST["nom"];
    $poste = $_POST["poste"];
    $salaire = $_POST["salaire"];
    $date_embauche = $_POST["date_embauche"];

    $sql = "INSERT INTO employes (nom, poste, salaire, date_embauche)
            VALUES ('$nom', '$poste', $salaire, '$date_embauche')";
    $conn->query($sql);
    header("Location: employes.php");
}

// SUPPRESSION
if (isset($_GET["supprimer"])) {
    $id = $_GET["supprimer"];
    $conn->query("DELETE FROM employes WHERE id = $id");
    header("Location: employes.php");
}

// FORMULAIRE MODIFICATION
if (isset($_GET["modifier"])) {
    $id = $_GET["modifier"];
    $modif = $conn->query("SELECT * FROM employes WHERE id = $id")->fetch_assoc();
}

// TRAITEMENT MODIFICATION
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["modifier"])) {
    $id = $_POST["id"];
    $nom = $_POST["nom"];
    $poste = $_POST["poste"];
    $salaire = $_POST["salaire"];
    $date_embauche = $_POST["date_embauche"];

    $sql = "UPDATE employes SET nom='$nom', poste='$poste', salaire=$salaire, date_embauche='$date_embauche' WHERE id=$id";
    $conn->query($sql);
    header("Location: employes.php");
}

// AFFICHAGE
$result = $conn->query("SELECT * FROM employes");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Employés - LaFerme</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
     <a href="index.php" class="btn-retour">← Retour </a>

    <h2><?= isset($modif) ? "Modifier un employé" : "Ajouter un employé" ?></h2>
    <form method="post">
        <input type="hidden" name="id" value="<?= $modif['id'] ?? '' ?>">
        Nom: <input name="nom" value="<?= $modif['nom'] ?? '' ?>" required>
        Poste: <input name="poste" value="<?= $modif['poste'] ?? '' ?>" required>
        Salaire (FCFA): <input name="salaire" type="number" value="<?= $modif['salaire'] ?? '' ?>" required>
        Date d'embauche: <input name="date_embauche" type="date" value="<?= $modif['date_embauche'] ?? '' ?>" required>

        <?php if (isset($modif)) { ?>
            <button type="submit" name="modifier">Modifier</button>
            <a href="employes.php">Annuler</a>
        <?php } else { ?>
            <button type="submit" name="ajouter">Ajouter</button>
        <?php } ?>
    </form>

    <h2>Liste des employés</h2>
    <table border="1" cellpadding="5">
        <tr><th>Nom</th><th>Poste</th><th>Salaire</th><th>Date d'embauche</th><th>Actions</th></tr>
        <?php while($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?= $row["nom"] ?></td>
                <td><?= $row["poste"] ?></td>
                <td><?= number_format($row["salaire"], 0, ',', ' ') ?> FCFA</td>
                <td><?= $row["date_embauche"] ?></td>
                <td>
                    <a href="?modifier=<?= $row["id"] ?>">Modifier</a> |
                    <a href="?supprimer=<?= $row["id"] ?>" onclick="return confirm('Supprimer cet employé ?')">Supprimer</a>
                </td>
            </tr>
        <?php } ?>
    </table>

</body>
</html>