<?php


require_once 'QuantikUIGenerator.php';
require_once 'ActionQuantik.php';
require_once 'ArrayPieceQuantik.php';
require_once 'QuantikGame.php';
require_once 'ressourcesQuantik/PDOQuantik.php';

error_reporting(E_ALL);
ini_set('desplay_errors','On'); 

session_start();

// Récupérer les données de session
if (isset($_SESSION['plateau'])) {
    $plateau = $_SESSION['plateau'];}

if (isset($_SESSION['QuantikGame'])) {
    $quantikGame = $_SESSION['QuantikGame'];}

if (isset($_SESSION['etat'])) {
    $etat = $_SESSION['etat'];}

if (isset($_SESSION['QuantikGame']) && isset($_SESSION['QuantikGame']->currentPlayer)) {
    $couleurActive = $_SESSION['QuantikGame']->currentPlayer;}

if (isset($_POST["action"])) {
    $actionQuantik = new ActionQuantik($plateau);
    $_SESSION['action'] = $actionQuantik;}


if(isset($_POST['action'])) {
    $action = $_POST['action'];}


switch ($action) 
{
    case 'choisirPiece':
        if (isset($_POST['pieceSelectionnee'])) 
        {
            $_SESSION['pieceSelectionnee'] = $_POST['pieceSelectionnee'];
       
            $_SESSION['etat'] = 'posePiece';
            header('Location: quantik.php');
        }
        else{
            QuantikUIGenerator::getPageErreur("Veuillez choisir une pièce SVP! ", "quantik.php");
        }
        break;

    case 'actionPoser':
        if(isset($_POST['poser']))
        {
            $position = explode("et", $_POST['poser']);
            $row = $position[0];
            $col = $position[1];
    
            if ($quantikGame->currentPlayer == PieceQuantik::WHITE) {
                $selectedPiece = $_SESSION['QuantikGame']->piecesBlanches->getPieceQuantik($_SESSION['pieceSelectionnee']);
                $actionQuantik->posePiece($row, $col, $selectedPiece);
                $_SESSION['QuantikGame']->piecesBlanches->removePieceQuantik($_SESSION['pieceSelectionnee']);
            } else {
                $selectedPiece = $_SESSION['QuantikGame']->piecesNoires->getPieceQuantik($_SESSION['pieceSelectionnee']);
                $actionQuantik->posePiece($row, $col, $selectedPiece);
                $_SESSION['QuantikGame']->piecesNoires->removePieceQuantik($_SESSION['pieceSelectionnee']);
            }
    
            for($i = 0; $i < 4; $i++) {
                if ($actionQuantik->isRowWin($i) || $actionQuantik->isColWin($i) || $actionQuantik->isCornerWin($i)) {
                    $_SESSION['etat'] = 'victoire';
                    header('Location: quantik.php');
                }
            }
    
            if($_SESSION['etat'] != 'victoire'){
                
                $_SESSION['etat'] = 'choixPiece';
                $quantikGame->currentPlayer = ($quantikGame->currentPlayer + 1) % 2;
                header('Location: quantik.php');
            }
        }
    break;
    case 'actionAnnuler':
        $_SESSION['etat'] = 'choixPiece';
        echo $_SESSION['etat'];
        header('Location: quantik.php');

        break;
    case 'recommencer':
        session_unset();
        header('Location: quantik.php');
        break;

}
if(isset($_POST['actionConnecter'])) 
{
    $action2 = $_POST['actionConnecter'];
    switch ($action2) {
        case 'nouvelle_partie':
            // 
            if(!isset($_SESSION['QuantikGame'])) 
            {
                $playerName = $_SESSION['player']->getName();
                $jsonData = $_SESSION['QuantikGame']->getJson() ; 
                PDOQuantik::createGameQuantik($playerName, $jsonData);
            }
            header("Location: quantik.php");
            exit;
            break;
        
        case 'quitter_session':
            session_destroy();
            header("Location: ressourcesQuantik/login.php");
            exit;
            break;
        
        default:
            header("Location: ressourcesQuantik/login.php");
            exit;
            break;
    }
} 
