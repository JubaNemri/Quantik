<?php

// Inclure les classes nécessaires
require_once 'PlateauQuantik.php';
require_once 'ArrayPieceQuantik.php';
require_once 'QuantikUIGenerator.php';
require_once 'QuantikGame.php';
require_once 'ActionQuantik.php';

session_start();

error_reporting(E_ALL);
ini_set('desplay_errors','On');







// Vérifier si les variables de session existent déjà
if (!isset($_SESSION['plateau'])) {
    $_SESSION['plateau'] = new PlateauQuantik();
}

if (!isset($_SESSION['QuantikGame'])) {
    $_SESSION['QuantikGame'] = new QuantikGame();
}
if (!isset($_SESSION['QuantikGame']->plateau)) {
    $_SESSION['QuantikGame']->plateau = $_SESSION['plateau'];
}

if (!isset($_SESSION['QuantikGame']->piecesNoires)) {
    $_SESSION['QuantikGame']->piecesNoires = ArrayPieceQuantik::initPiecesNoires();
}

if (!isset($_SESSION['QuantikGame']->piecesBlanches)) {
    $_SESSION['QuantikGame']->piecesBlanches = ArrayPieceQuantik::initPiecesBlanches();
}

if (!isset($_SESSION['QuantikGame']->gameStatus)) {
    $_SESSION['QuantikGame']->gameStatus = "choixPiece";
}

if (!isset($_SESSION['etat'])) {
    $_SESSION['etat'] = $_SESSION['QuantikGame']->gameStatus;
}

if (!isset($_SESSION['QuantikGame']->currentPlayer)) {
    $_SESSION['QuantikGame']->currentPlayer = 0;
}



switch($_SESSION['etat']) 
{
    case 'choixPiece':
        echo QuantikUIGenerator::getPageSelectionPiece( $_SESSION['QuantikGame'],  $_SESSION['QuantikGame']->currentPlayer);
        break;
    case 'posePiece':
        echo QuantikUIGenerator::getPagePosePiece($_SESSION['QuantikGame'],   $_SESSION['QuantikGame']->currentPlayer, intval($_SESSION['pieceSelectionnee']));
        break;
    case 'victoire':
        echo QuantikUIGenerator::getPageVictoire($_SESSION['QuantikGame'], ($_SESSION['QuantikGame']->currentPlayer), $_SESSION['pieceSelectionnee']);
        break;
    default:
        echo QuantikUIGenerator::getPageErreur("erreur ","quantik.php");
        exit(1);
}

?>
