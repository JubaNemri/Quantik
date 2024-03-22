<?php
require_once('QuantikGame.php');
require_once('QuantikUIGenerator.php'); 

session_start();

if (isset($_SESSION['plateau']) )
{
    $plateau = new PlateauQuantik();
    if(!isset($_SESSION['plateau']))
    {
        $_SESSION['plateau'] = $plateau ;
    }


    /// Création d'ensembles de pièces blanches et noires
    $tableauBlanc = ArrayPieceQuantik::initPiecesBlanches();
    if (!isset($_SESSION['tableauBlanc']))
    {
        $_SESSION['tableauBlanc']=$tableauBlanc;
    }

    $tableauNoir = ArrayPieceQuantik::initPiecesNoires();
    if(!isset($_SESSION['tableauNoir']))
    {
        $_SESSION['tableauNoir']=$tableauNoir ;
    }

    // Création du jeu Quantik avec le plateau et les pièces
    $quantik = new QuantikGame($plateau, $tableauBlanc, $tableauNoir, array(PieceQuantik::WHITE));

    echo QuantikUIGenerator::getPagePosePiece($quantik ,  PieceQuantik::WHITE  , $_SESSION['pieceSelectionnee']) ;

    if(isset($_POST['actionPoser'])) 
    {
        // Récupérer la position du bouton cliqué
        $position = $_POST['actionPoser'];

        list($x, $y) = explode(' ', $position);

        // Vérifier si la pose est valide
        if ($actionQuantik->isValidePose($x, $y,  $_SESSION['pieceSelectionnee'])) {
            // Poser la pièce sur le plateau
            $actionQuantik->posePiece($x, $y,  $_SESSION['pieceSelectionnee']);

            // Vérifier si la partie est gagnée
            if (isGameWin()) {
                $_SESSION['etat'] = 'victoire';
    
            } else {
                // on continue de jouer 
                $_SESSION['QuantikGame']->currentPlayer = ($_SESSION['QuantikGame']->currentPlayer + 1) % 2;
                $_SESSION['etat'] = 'choixPiece';
                header('Location: index.php');
            }
        } else {
            exit();
        }
    }
}
else
{
    QuantikUIGenerator::getPageErreur("Aucune Pièce selectionnée  " , "ChoixPiecesBlanche.php") ;
}

function isGameWin(): bool
{

    for ($i = 0; $i < PlateauQuantik::NBROWS; $i++) 
    {
        if (ActionQuantik::isRowWin($i)) {
            return true;
        }
    }

    for ($j = 0; $j < PlateauQuantik::NBCOLS; $j++) 
    {
        if (ActionQuantik::isColWin($j)) {
            return true;
        }
    }

    for ($k = 0; $k < PlateauQuantik::NBCORNERS; $k++) 
    {
        if (ActionQuantik::isCornerWin($k)) {
            return true;
        }
    }
    return false;
}
?>