<?php
/**
 * Classe PlateauQuantik
 * @author Wissam Kerrouche
 */

require_once('ArrayPieceQuantik.php');
require_once('PieceQuantik.php');


class PlateauQuantik 
{
    const NBROWS = 4; // nombre de lignes
    const NBCOLS = 4; // nombre de colonnes 
    const NW = 0;     // zone nord-ouest
    const NE = 1;     // zone nord-est
    const SW = 2;     // zone sud-ouest
    const SE = 3;     // zone sud-est

    protected array $cases; 

    // Constructeur
    public function __construct()
    {
        for($i = 0; $i < self::NBROWS; $i++){
            for($j = 0; $j < self::NBCOLS; $j++){
                $this->cases[$i][$j] = PieceQuantik::initVOID() ;
            }
        }
     }

    // Méthode pour obtenir une Piece à une position donnée
    public function getPiece(int $rowNum, int $colNum): PieceQuantik
    {
        return $this->cases[$rowNum][$colNum];
    }
    
    // Méthode pour définir une Piece à une position donnée
    public function setPiece(int $rowNum, int $colNum, PieceQuantik $p): void 
    {
        $this->cases[$rowNum][$colNum] = $p;
    }


    // Méthode pour obtenir une ligne donnée
    public function getRow(int $numRow): ArrayPieceQuantik
    {
        $resultat = new ArrayPieceQuantik() ;
        for ($i = 0; $i < self::NBROWS; $i++) 
        {
            $resultat->setPieceQuantik($i , $this->cases[$numRow][$i]);
        }
        return $resultat;
    }


    // Méthode pour obtenir une colonne donnée
    public function getCol(int $colNum): ArrayPieceQuantik 
    {
        $resultat = new ArrayPieceQuantik() ;
        for ($i = 0; $i < self::NBCOLS; $i++) 
        {
            $resultat->setPieceQuantik($i , $this->cases[$i][$colNum]);
        }
        return $resultat;
    }

   // Méthode pour obtenir un coin donné
public function getCorner(int $dir): ArrayPieceQuantik
{
    $resultat = new ArrayPieceQuantik();

    switch ($dir) {
        case self::NW:
            $resultat->setPieceQuantik(0, $this->cases[0][0]);
            $resultat->setPieceQuantik(1, $this->cases[0][1]);
            $resultat->setPieceQuantik(2, $this->cases[1][0]);
            $resultat->setPieceQuantik(3, $this->cases[1][1]);
            break;
        case self::NE:
            $resultat->setPieceQuantik(0, $this->cases[0][2]);
            $resultat->setPieceQuantik(1, $this->cases[0][3]);
            $resultat->setPieceQuantik(2, $this->cases[1][2]);
            $resultat->setPieceQuantik(3, $this->cases[1][3]);
            break;
        case self::SW:
            $resultat->setPieceQuantik(0, $this->cases[2][0]);
            $resultat->setPieceQuantik(1, $this->cases[2][1]);
            $resultat->setPieceQuantik(2, $this->cases[3][0]);
            $resultat->setPieceQuantik(3, $this->cases[3][1]);
            break;
        case self::SE:
            $resultat->setPieceQuantik(0, $this->cases[2][2]);
            $resultat->setPieceQuantik(1, $this->cases[2][3]);
            $resultat->setPieceQuantik(2, $this->cases[3][2]);
            $resultat->setPieceQuantik(3, $this->cases[3][3]);
            break;
    }

    return $resultat;
}

    // Méthode pour obtenir un coin via les coordonées données
    public static function getCornerFromCoord(int $rowNum, int $colNum): int {
        if ($rowNum < self::NBROWS / 2) {
            // Lignes supérieures
            if ($colNum < self::NBCOLS / 2) {
                // Coins nord-ouest
                return self::NW;
            } else {
                // Coins nord-est
                return self::NE;
            }
        } else {
            // Lignes inférieures
            if ($colNum < self::NBCOLS / 2) {
                // Coins sud-ouest
                return self::SW;
            } else {
                // Coins sud-est
                return self::SE;
            }
        }
    }
    

   // Méthode pour obtenir la représentation en chaîne de l'objet
   public function __toString():String
   {
    $resultat = '<p><table>';
    foreach($this->cases as $value =>$v) 
    {
        $resultat = $resultat.'<tr>';
        foreach ($v as $key => $val) {
            $resultat = $resultat."<td>".$val."</td>";
        }
        $resultat = $resultat."</tr>";
    }
    $resultat = $resultat.'</table></p>';
        return $resultat;
}
  /* TODO implantation schéma UML */
  public function getJson(): string {
    $json = "[";
    $jTab = [];
    foreach ($this->cases as $apq)
        $jTab[] = $apq->getJson();
    $json .= implode(',',$jTab);
    return $json.']';
}

public static function initPlateauQuantik(string|array $json) : PlateauQuantik
{
    $pq = new PlateauQuantik();
    if (is_string($json))
        $json = json_decode($json);
    $cases = [];
    foreach($json as $elem)
        $cases[] = ArrayPieceQuantik::initArrayPieceQuantik($elem);
    $pq->cases = $cases;
    return $pq;
}
}