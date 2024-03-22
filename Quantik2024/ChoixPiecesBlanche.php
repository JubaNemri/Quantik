<?php
require_once('QuantikUIGenerator.php');
require_once('QuantikGame.php');
require_once('PlateauQuantik.php');
require_once('ArrayPieceQuantik.php');
require_once('ActionQuantik.php');

session_start();
// debug    
error_reporting(E_ALL);
ini_set('display_errors', 1);


$plateau = new PlateauQuantik();
if(!isset($_SESSION['plateau']))
{
    $_SESSION['plateau'] = serialize($plateau) ;
}


// Création d'ensembles de pièces blanches et noires
$tableauBlanc = ArrayPieceQuantik::initPiecesBlanches();
if (!isset($_SESSION['tableauBlanc']))
{
    $_SESSION['tableauBlanc']=serialize($tableauBlanc);
}

$tableauNoir = ArrayPieceQuantik::initPiecesNoires();
if(!isset($_SESSION['tableauNoir']))
{
    $_SESSION['tableauNoir']=serialize($tableauNoir) ;
}

$_SESSION['etat'] = "blanc" ;

// Création du jeu Quantik avec le plateau et les pièces
$quantik = new QuantikGame($plateau, $tableauBlanc, $tableauNoir, array(PieceQuantik::WHITE));

if(!isset($_SESSION['quantik']))
{   
    $_SESSION['quantik'] = serialize($quantik) ;
}
echo QuantikUIGenerator::getPageSelectionPiece($quantik ,PieceQuantik::WHITE );


?>