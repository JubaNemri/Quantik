<?php
namespace Quantik2024;
use Quantik2024\PDOQuantik;

require_once 'PDOQuantik.php';
session_start();

// Vérifier si le joueur est identifié
if (!isset($_SESSION['player'])) {
    header("Location: login.php"); // Rediriger vers la page de login si le joueur n'est pas identifié
    exit;
}

// Affichage de la page Home avec le nom du joueur
?>

<!DOCTYPE html>
<html lang="fr"> 

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Salle de jeux</title>
</head>

<body>
    <h1>Bienvenue dans la salle de jeux, <?php echo $_SESSION['player']->getName(); ?>!</h1>
    <h2>Que voulez-vous faire ?</h2>
    <form action="../traiteFormQuantik.php" method="post">
        <button type="submit" name="actionConnecter" value="nouvelle_partie">Initier une nouvelle partie</button><br><br>
        <button type="submit" name="actionConnecter" value="parties_non_terminees">Accéder à mes parties non terminées</button><br><br>
        <button type="submit" name="actionConnecter" value="parties_en_attente">Voir les parties en attente d'un second joueur</button><br><br>
        <button type="submit" name="actionConnecter" value="parties_terminees">Consulter mes parties terminées</button><br><br>
        <button type="submit" name="actionConnecter" value="quitter_session">Quitter la session</button>
    </form>
</body>

</html>
