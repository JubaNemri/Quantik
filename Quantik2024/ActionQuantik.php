<?php
/**
 * 
 * Classe ActionQuantik
 * 
 * @author Juba Nemri
 * 
 */

require_once 'PlateauQuantik.php'; 
require_once 'PieceQuantik.php';    
require_once 'ArrayPieceQuantik.php';   

class ActionQuantik 
{
    private PlateauQuantik $plateau;

    // Constructeur
    public function __construct(PlateauQuantik $plateau) 
    {
        $this->plateau = $plateau;
    }

    // Méthode pour obtenir le plateau
    public function getPlateau(): PlateauQuantik 
    {
        return $this->plateau;
    }

     // Méthode pour vérifier si une ligne est gagnante
     public function isRowWin(int $numRow): bool
    {
        $row = $this->plateau->getRow($numRow);
        return $this->isComboWin($row);
    }

    // Méthode pour vérifier si une colonne est gagnante
    public function isColWin(int $numCol): bool
    {
        $col = $this->plateau->getCol($numCol);
        return $this->isComboWin($col);

    }

    // Méthode pour vérifier si un coin est gagnant
    public function isCornerWin(int $dir): bool
    {
        $cor = $this->plateau->getCorner($dir);

        return $this->isComboWin($cor);
    }

    // Méthode pour vérifier si une pose de pièce est valide
    public function isValidePose(int $rowNum, int $colNum, PieceQuantik $piece): bool
    {
        if($this->plateau->getPiece($rowNum, $colNum) != PieceQuantik::initVoid()){
            return false;
        }
        $pieceRow = $this->plateau->getRow($rowNum);
        $pieceCol = $this->plateau->getCol($colNum);
        $pieceCorner = $this->plateau->getCorner(PlateauQuantik::getCornerFromCoord($rowNum, $colNum));

        $resultat = $this->isPieceValide($pieceCorner, $piece) && $this->isPieceValide($pieceCol, $piece) && $this->isPieceValide($pieceRow, $piece) ;
        return $resultat;
    }


    // Méthode pour poser une pièce
    public function posePiece(int $rowNum, int $colNum, PieceQuantik $piece): void 
    {

        $plateau = $this->getPlateau(); 
        if ($this->isValidePose($rowNum, $colNum, $piece)) 
        {
            $plateau->setPiece($rowNum, $colNum, $piece);
        }
    }

    public function toString(): string 
    {
        return $this->plateau:: __toString() ;  
    }

    // Méthode pour vérifier si un combo est gagnant
    
    private static function isComboWin(ArrayPieceQuantik $tableau) :bool
    {
        for( $i=0; $i<count($tableau);$i++){
            $total+=$tableau[$i]->getForme();
        }
        if($total==10){
            return true;
        }
        else
            return false;
    }

    // Méthode pour vérifier si une pièce est valide
    private static function isPieceValide(ArrayPieceQuantik $pieces, PieceQuantik $p): bool
    {
        for( $i = 0 ; $i < count($pieces) ; $i++ )
        {
            if($pieces->getPieceQuantik($i)->getForme() == $p->getForme() )
            {
                return false; 
            }
        }
        return true ;
    }
}
?>
