<?php
/**
 * 
 * Classe QuantikUIGenerator
 * Cette classe permet de définir les éléments de base d'un jeu de plateau.
 * @author Wissam Kerrouche 
 * @author Juba Nemri
 * 
 */

require_once('ArrayPieceQuantik.php');
require_once('PlateauQuantik.php');
require_once('PieceQuantik.php');
require_once('AbstractUIGenerator.php');
require_once('ActionQuantik.php');

class QuantikUIGenerator extends AbstractUIGenerator {

    public static function getDebutHTML(string $title = "Quantik"): string
{
    return '<!doctype html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>' . $title . '</title>
        <link rel="stylesheet" href="monCss.css">
    </head>
    <body>
        <h1 class="quantik">' . $title . '</h1>';
}

    public static function getFinHTML(): string {
        return "</body>\n</html>\n";
    }


     /**
     * @param PieceQuantik $piece
     * @return string
     */

     protected static function getButtonClass( PieceQuantik $piece ) : string 
     {
         if ($piece->getForme() == PieceQuantik::VOID ) // si la piece est vide
         {
            return "null" ;
         }
         $resultat = $piece->__toString() ; 
         $p = substr($resultat , 1 , 2) ; // Cela extrait une sous-chaine de la chaine $resultat à partir de l'index 1 et avec une longueur de 2 caractères.
         $c = substr($resultat , 4 , 1) ;   //  à partir de l'index 4 et avec une longueur de 1 
         
         return $p.$c ; 
     }
     
 
     /**
      * méthode qui retourne le plateauQuantik sous forme d'un string -code html- 
      * les piéces sont représentées par des boutons avec des class CSS (getButtonClass)
      * les cases vides sont représentées par des boutons sans texte
      * 
      * chaque bouton a  une valeur correspondant à sa position sur le plateau, dans le format - ligne-colonne -
      * @param PlateauQuantik 
      * @return string 
      */
     protected static function getDivPlateauQuantik(PlateauQuantik $plateau): string 
     {
         $html = "<p><table class = 'plateau'>";
         for ($ligne = 0; $ligne < PlateauQuantik::NBROWS; $ligne++) {
            $html .= "<tr>";
             for ($col = 0; $col < PlateauQuantik::NBCOLS; $col++) 
             {
                 $piece = $plateau->getPiece($ligne, $col);

                 $html .="<td>";
                 if ($piece != PieceQuantik::initVOID()) {
                    $html .= "<button class='" . self::getButtonClass($piece) . "' type='submit' name='pos' value='{$ligne}-{$col}'>$piece</button>";
                 } 
                 
                 else {
                     $html .= "<button class='empty' type='submit' name='pos' value='{$ligne}-{$col}'>( , )</button>";
                 }
                 $html .="</td>";
             }
             $html .= "</tr>";
         }
         $html .="</table></p>";
         return $html;
     }
 

    /**
     * méthode qui   retourne une chaîne de caractères contenant une division HTML permettant d'afficher des boutons désactivés contenant la représentation des pièces concernées
     * @param ArrayPieceQuantik $array 
     * @param int $position 
     * @return String
     */

    public static function getDivPiecesDisponibles(ArrayPieceQuantik $pieces, int $position = -1): string 
    {
        $html = "<div>";
        for( $i = 0 ; $i< count($pieces) ; $i++ )
        {
            if ($i == $position )
            {
                $html .= '<button class = "'.SELF::getButtonClass($pieces[$i]).'" type="submit" name="active" value= "'.$i.'" disabled >'.$pieces[$i].'</button>';
            }
            else
            {
                $html .= '<button class = "'.SELF::getButtonClass($pieces[$i]).'" type="submit" name="active" value= "'.$i.'" disabled >'.$pieces[$i].'</button>';
        
            }
        }
        $html .= "<input type= 'hidden' name='action' value='choisirPiece'/>";
        $html .= "</div>";
        return $html;
    }

    /**
     *  formulaire pour selectionner une piece 
     * @param ArrayPieceQuantik $array
     * @return string
     */
    public static function getFormSelectionPiece(ArrayPieceQuantik $pieces): string 
    {
        $html = "<form action='traiteFormQuantik.php' method='post'>";
     
        for( $i = 0 ; $i < $pieces->count() ; $i++ ) 
        {
            $html .= "<button class = '".SELF::getButtonClass($pieces[$i])."'type='submit' name='pieceSelectionnee' value='$i'>".$pieces->getPieceQuantik($i)->__toString()."</button>";
            $html .= "<input type='hidden' name='action' value='choisirPiece'>";
        }   
     
        $html .= "</form>";
        return $html;
    }

    
    /**
     * méthode qui e génère un formulaire HTML qui représente le plateau de jeu qui permet à l'utilisateur de poser une pièce
     *@param PlateauQuantik
     *@param PieceQuantik 
     *@return string
     */

     public static function getFormPlateauQuantik(PlateauQuantik $plateau, PieceQuantik $p): string 
     {
         $resultat = "<form action='traiteFormQuantik.php' method='post'><table class = 'plateau'>";
     
         $action = new ActionQuantik($plateau);
         for ($i = 0; $i < PlateauQuantik::NBROWS; $i++) {
             $resultat .= "<tr>";
             for ($j = 0; $j < PlateauQuantik::NBCOLS; $j++) {
                 $position= $i."et".$j ;
                 $piece = $plateau->getPiece($i, $j);
                 $temp = "";
                 if ($piece != PieceQuantik::initVOID()) {
                     $temp = $piece->__toString();
                 } else {
                     $temp = "( , )";
                 }
    
                 if ($action->isValidePose($i, $j, $p)) {
                     $resultat .= "<td>";
                     $resultat .= "<button class = empty '".SELF::getButtonClass($piece)."' type= 'submit' name='poser' value='$position' > $temp </button>";
                     $resultat .= "<input type='hidden' name='action' value='actionPoser'>";
                    } elseif($piece == PieceQuantik::initVOID()) {
                     $resultat .= "<td>";
                     $resultat .= "<button class ='nonValide ".SELF::getButtonClass($piece)."' type='submit' name= 'poser' value='$position' disabled > $temp </button>";    
                     $resultat .= "<input type='hidden' name='action' value='actionPoser'>";   
                    }else{
                        $resultat .= "<td>";
                     $resultat .= "<button class =' ".SELF::getButtonClass($piece)."' type='submit' name= 'poser' value='$position' disabled > $temp </button>";    
                     $resultat .= "<input type='hidden' name='action' value='actionPoser'>";
                    }
                 $resultat .= "</td>";
             }
             $resultat .= "</tr>";
         }
         $resultat .= "</table></form></p>"; 
         $resultat .= self::getLienRecommencer("Quitter la partie") ;
         return $resultat;
     }
     
    /**
     * méthode qui génére un formulaire html pour annuler un choix 
     * @return string
     */
    protected static function getFormBoutonAnnulerChoixPiece(): string 
    {
        $html = '<form method="post" action="traiteFormQuantik.php">'; //Une fois le formulaire soumis, il sera traité par le script traiteFormQuantik.php.
        $html .= '<input type="hidden" name="action" value="actionAnnuler" >'; // cancel pour annuler son choix de piece 
        $html .= '<button class ="annuler"type="submit">Annuler le choix de la pièce sélectionnée</button>';
        $html .= '</form>';
        return $html;
    }
    
    /**
     * @param string $message
     * @param string $urlLien
     * @return string
     */

    public static function getPageErreur(string $message , string $urlLien = "quantik.php" ): string {
        $debut = self::getDebutHTML($message);
        $fin = self::getFinHTML();
        
        return <<<HTML
        $debut
            <h1>Erreur 400: Bad Request</h1>
            <p>$message</p>
            <a href="$urlLien">Retourner à la page d'accueil</a>
        $fin
        HTML;
    }
    
    /**
     * @param int $couleur
     * @return string
     */

    protected static function getDivMessageVictoire(int $couleur): string {
        $message = ($couleur == PieceQuantik::WHITE) ? "Victoire des pièces blanches !" : "Victoire des pièces noires !";
        return "<div>$message</div>";
    }
    

    /**
     * méthode qui permet de recommencer - elle envoie vers le lien traiteFormQuantik - 
    */
    protected static function getLienRecommencer($message = "Nouvelle Partie"): string{
        return "<form action='traiteFormQuantik.php' method='post'>
                <button class = recommencer type='submit' name='action' value='recommencer' >$message</button></form>";
    }
    
    
    /**
     * @param QuantikGame 
     * @param int $couleurActive
     * @return string
    */

    public static function getPageSelectionPiece(QuantikGame $quantik, int $couleurActive): string 
    {
    
        $html = QuantikUIGenerator::getDebutHTML("QUANTIK");
        $html .= '<table class=jeu>';
        $html.= "<tr><th>Pieces Blanches </th><th>Plateau</th></tr>";
       
        if ($couleurActive == PieceQuantik::BLACK) 
        { 
            $html .= "<tr><td >".self::getDivPiecesDisponibles($quantik->piecesBlanches)."</td>";
            $html .= "<td rowspan=3>".self::getDivPlateauQuantik($quantik->plateau)."</td></tr>"; 
    
            $html.= "<tr><th>Pieces Noires </th></tr>";
            $html .= "<tr><td>". self::getFormSelectionPiece($quantik->piecesNoires)."</td></tr>";
        } elseif ($couleurActive == PieceQuantik::WHITE) 
        {
            $html .= "<tr><td >".self::getFormSelectionPiece($quantik->piecesBlanches)."</td>";
            $html .= "<td rowspan=3>".self::getDivPlateauQuantik($quantik->plateau)."</td></tr>";
    
            $html.= "<tr><th>Pieces Noires </th></tr>";
            $html .= "<tr><td>". self::getDivPiecesDisponibles($quantik->piecesNoires)."</td></tr>";
        }
    
        $html .= '</table>'.self::getFinHTML();
        return $html;
    }
    



    /**
     * @param int $couleurActive
     * @param PlateauQuantik $plateau
     * @return string
     */
    public static function getPageVictoire(QuantikGame $quantik, int $couleurActive): string {

        $html = self::getDebutHTML("Victoire");
        if($couleurActive == PieceQuantik::WHITE ){
            $html .= self::getDivPiecesDisponibles($quantik->piecesBlanches)
                    . "<p></br></p>"
                . self::getDivPiecesDisponibles($quantik->piecesNoires);

        }elseif ($couleurActive == PieceQuantik::BLACK){

            $html .= self::getDivPiecesDisponibles($quantik->piecesBlanches)
                . "<p></br></p>"
                . self::getDivPiecesDisponibles($quantik->piecesNoires);
        }

        $html .= self::getDivPlateauQuantik($quantik->plateau) 
            . self::getDivMessageVictoire($couleurActive)
            .self::getLienRecommencer()
            . "</form>"
            . self::getFinHTML();
        return $html;
    }
    
    
     /**
      * @param QuantikGame  
      * @param int $couleurActive
      * @param int $posSelection position de la pièce sélectionnée dans la couleur active
      * @return string
     */
    public static function getPagePosePiece(QuantikGame $quantik, int $couleurActive, int $posSelection): string 
    {
        $resultat = self::getDebutHTML("QUANTIK");
        $resultat .= '<table class=jeu>';
        
        if($couleurActive == PieceQuantik::WHITE)
        { 
            $resultat .=  "<tr><th> Pièces Blanches </th><th>Plateau</th></tr>";
            $resultat.= "<tr><td >".self::getDivPiecesDisponibles($quantik->piecesBlanches ,$posSelection) ."</td >";
            $resultat.= "<td rowspan =3>". self::getFormPlateauQuantik($quantik->plateau, $quantik->piecesBlanches-> getPieceQuantik($posSelection)) ."</td ></tr>";
            $resultat.="<tr><th>Pièces Noires </th></tr>";
            $resultat .= "<tr><td >".self::getDivPiecesDisponibles($quantik->piecesNoires)."</td></tr>";
    
        }else if($couleurActive == PieceQuantik::BLACK)
        {
            $resultat.="<tr><th> Pièces Blanches </th> <th>Plateau</th></tr>";
            $resultat .= "<tr><td >".self::getDivPiecesDisponibles($quantik->piecesBlanches)."</td>";
           
            $resultat.= "<td rowspan =3>". self::getFormPlateauQuantik($quantik->plateau, $quantik->piecesNoires-> getPieceQuantik($posSelection)) ."</td ></tr>";
            
            $resultat .=  "<tr><th> Pièces Noires </th></tr>";
            $resultat.= "<tr><td >".self::getDivPiecesDisponibles($quantik->piecesNoires ,$posSelection) ."</td >";
    
        }
        $resultat .= "</table>".self::getFormBoutonAnnulerChoixPiece();
        $resultat .=  self::getFinHTML();
        return $resultat ;
    }
}

?>
 