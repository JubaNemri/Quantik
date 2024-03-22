<?php

require_once('../Quantik2024/PieceQuantik.php');
require_once('../Quantik2024/ArrayPieceQuantik.php');
require_once('../Quantik2024/PlateauQuantik.php');
require_once('../Quantik2024/ActionQuantik.php');

// Test de la classe PlateauQuantik
echo "Test de la classe PlateauQuantik:\n";

// Création d'une instance de PlateauQuantik
$plateau = new PlateauQuantik();

// Ajout de quelques pièces
$plateau->setPiece(0, 0, PieceQuantik::initBlackCone());
$plateau->setPiece(1, 1, PieceQuantik::initWhiteCone());

// Affichage du contenu du plateau
echo "Contenu initial du plateau :\n";
echo $plateau->__toString() . "\n";

// Accès à une pièce spécifique
$piece = $plateau->getPiece(0, 0);
echo "Pièce récupérée à la position (0, 0) : " . $piece . "\n";

// Affichage de la première ligne
$row = $plateau->getRow(0);
echo "Première ligne du plateau :\n";
echo $row ;

// Affichage de la première colonne
$col = $plateau->getCol(0);
echo "Première colonne du plateau :\n";
echo $col ;

// Affichage du coin nord-ouest
$cornerNW = $plateau->getCorner(PlateauQuantik::NW);
echo "Coin nord-ouest du plateau :\n";
echo $cornerNW ;

// Affichage du coin sud-est
$cornerSE = $plateau->getCorner(PlateauQuantik::SE);
echo "Coin sud-est du plateau :\n";
echo $cornerSE ;

// Récupération du coin en fonction des coordonnées
$cornerFromCoord = $plateau->getCornerFromCoord(2, 3);
echo $cornerFromCoord; 

?>
