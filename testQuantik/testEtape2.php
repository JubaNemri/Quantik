<?php

require_once('../Quantik2024/QuantikUIGenerator.php');
require_once('../Quantik2024/QuantikGame.php');
require_once('../Quantik2024/PlateauQuantik.php');
require_once('../Quantik2024/PieceQuantik.php');
require_once('../Quantik2024/ArrayPieceQuantik.php');


// Création d'un plateau Quantik.
$plateau = new PlateauQuantik();

// Création d'ensembles de pièces blanches et noires
$piecesBlanches = new ArrayPieceQuantik();
$piecesNoires = new ArrayPieceQuantik();

// Ajout de quelques pièces blanches et noires
$piecesBlanches = ArrayPieceQuantik::initPiecesBlanches() ;


$piecesNoires = ArrayPieceQuantik::initPiecesNoires(); 

// Création du jeu Quantik avec le plateau et les pièces
$quantik = new QuantikGame($plateau, $piecesBlanches, $piecesNoires, array(PieceQuantik::WHITE, PieceQuantik::BLACK));

// Test de la méthode getPageSelectionPiece
echo "Test de la méthode getPageSelectionPiece:<br>";
echo QuantikUIGenerator::getPageSelectionPiece($quantik, PieceQuantik::WHITE);

// Test de la méthode getPageVictoire
echo "Test de la méthode getPageVictoire:<br>";
echo QuantikUIGenerator::getPageVictoire($quantik, PieceQuantik::WHITE);

// Test de la méthode getPagePosePiece
echo "Test de la méthode getPagePosePiece:<br>";
echo QuantikUIGenerator::getPagePosePiece($quantik, PieceQuantik::WHITE, 0);



?>
