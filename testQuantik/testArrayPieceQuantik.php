<?php

require_once "../Quantik2024/ArrayPieceQuantik.php";
require_once "../Quantik2024/PieceQuantik.php";

// Test de l'initialisation des pièces noires
echo "Test d'initialisation des pièces noires : \n";
$arrayPiecesNoires = ArrayPieceQuantik::initPiecesNoires();
echo $arrayPiecesNoires;

// Test de l'initialisation des pièces blanches
echo "Test d'initialisation des pièces blanches : \n";
$arrayPiecesBlanches = ArrayPieceQuantik::initPiecesBlanches();
echo $arrayPiecesBlanches;


// Test de la récupération d'une pièce
echo "Test de la récupération d'une pièce : \n";
$piece = $arrayPiecesBlanches->getPieceQuantik(3);
echo "Pièce à la position 3 : ".$piece."\n";

// Test de la modification d'une pièce
echo "Test de la modification d'une pièce : \n";
$newPiece = PieceQuantik::initBlackCube();
$arrayPiecesBlanches->setPieceQuantik(3, $newPiece);
echo "Pièce modifiée à la position 3 : ".$arrayPiecesBlanches->getPieceQuantik(3)."\n";

// Test de la suppression d'une pièce
echo "Test de la suppression d'une pièce : \n";
$arrayPiecesBlanches->removePieceQuantik(3);
echo $arrayPiecesBlanches;

/* *********************** TRACE d'éxécution de ce programme
(Co:B)(Co:B)(Cu:B)(Cu:B)(Cy:B)(Cy:B)(Sp:B)(Sp:B)
(Co:W)(Co:W)(Cu:W)(Cu:W)(Cy:W)(Cy:W)(Sp:W)(Sp:W)
*********************** */