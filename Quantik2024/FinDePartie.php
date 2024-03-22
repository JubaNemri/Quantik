<?php
require_once('ArrayPieceQuantik.php');
require_once('PlateauQuantik.php');
require_once('QuantikUIGenerator.php'); 

// Démarrage de la session
session_start();

// Récupération ou initialisation du plateau, des pièces blanches et des pièces noires
$tableau = isset($_SESSION['tableau']) ? unserialize($_SESSION['tableau']) : new PlateauQuantik();
$tB = isset($_SESSION['ArrayBlanc']) ? unserialize($_SESSION['ArrayBlanc']) : (new ArrayPieceQuantik())->initPiecesBlanches();
$tN = isset($_SESSION['ArrayNoir']) ? unserialize($_SESSION['ArrayNoir']) : (new ArrayPieceQuantik())->initPiecesNoires();

echo QuantikUIGenerator::getDebutHTML("Fin de partie");

// Affichage des pièces disponibles
echo QuantikUIGenerator::getDivPiecesDisponibles($tN);

// Affichage du plateau de jeu
echo QuantikUIGenerator::getDivPlateauQuantik($tableau);

echo QuantikUIGenerator::getFinHTML();
?>
