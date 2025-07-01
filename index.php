<?php
session_start();
if (!isset($_SESSION["utilisateur"])) {
    header("Location: connexion.php");
    exit();
}
$utilisateur = $_SESSION["utilisateur"];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>LaFerme - Accueil</title>
    <style>
        html, body {
            height: 100%;
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4f9ff;
            color: #1e293b;
            display: flex;
            flex-direction: column;
        }

        main {
            flex: 1;
            padding: 20px;
        }

        h1 {
            text-align: center;
            font-size: 36px;
            color: #1e3a8a;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 40px;
            position: relative;
            display: inline-block;
            padding-bottom: 10px;
        }

        h1::after {
            content: "";
            display: block;
            width: 80px;
            height: 4px;
            background-color: #3b82f6;
            margin: 10px auto 0;
            border-radius: 2px;
        }

        h2 {
            color: #1e3a8a;
            border-left: 5px solid #2563eb;
            padding-left: 10px;
            margin-top: 30px;
        }

        .menu {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            margin-top: 40px;
        }

        .menu-item {
            background-color: #3b82f6;
            color: white;
            text-decoration: none;
            padding: 20px 30px;
            border-radius: 10px;
            font-size: 18px;
            font-weight: bold;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            transition: transform 0.2s, background-color 0.3s;
        }

        .menu-item:hover {
            background-color: #2563eb;
            transform: scale(1.05);
        }

        .topbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 60px;
            background-color: #1e3a8a;
            color: #fff;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 30px;
            z-index: 1000;
            box-shadow: 0 2px 6px rgba(0,0,0,0.2);
        }

        .topbar a {
            color: #fff;
            text-decoration: none;
            margin-left: 20px;
            font-weight: bold;
        }

        .topbar a:hover {
            text-decoration: underline;
        }

        .logout {
            background-color: #ef4444;
            padding: 8px 12px;
            border-radius: 6px;
            color: #fff;
            margin-left: 30px;
            text-decoration: none;
        }

        .logout:hover {
            background-color: #dc2626;
        }

        a {
            color: #2563eb;
            text-decoration: none;
            font-weight: 600;
        }

        a:hover {
            text-decoration: underline;
        }

        footer {
            background: #004080;
            color: white;
            padding: 1em;
            text-align: center;
            margin-top: auto;
            box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.1);
        }

        body {
            padding-top: 70px; /* Pour ne pas que le topbar cache le contenu */
        }
    </style>
</head>
<body>

    <!-- Barre de navigation supérieure -->
    <header class="topbar">
        <div class="left">Bienvenue, <?= htmlspecialchars($utilisateur) ?></div>
        <div class="right">
            <a href="connexion.php">Accueil</a>
            <a href="logout.php" class="logout">Déconnexion</a>
        </div>
    </header>

    <!-- Contenu principal -->
    <main>
        <h1>Bienvenue sur LaFerme, <?= htmlspecialchars($utilisateur) ?></h1>
        <p style="text-align:center;">Utilisez le menu ci-dessous pour naviguer dans les différentes sections de gestion.</p>

        <div class="menu">
            <a href="animaux.php" class="menu-item">GESTION des Animaux</a>
            <a href="cultures.php" class="menu-item">GESTION des Cultures</a>
            <a href="employes.php" class="menu-item">GESTION des Employés</a>
            <a href="stock.php" class="menu-item">GESTION du Stock</a>
            <a href="finance.php" class="menu-item">GESTION des Finances</a>
        </div>
    </main>

    <!-- Pied de page -->
    <footer>
        &copy; <?= date("Y") ?> LaFerme | Créé par Arlette Sawadogo
    </footer>

</body>
</html>