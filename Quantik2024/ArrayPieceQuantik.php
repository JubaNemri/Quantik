    <?php

    /**
     * Classe PlateauQuantik
     * @author Wissam Kerrouche
     */

    require_once('PieceQuantik.php');

    class ArrayPieceQuantik implements ArrayAccess, Countable {

        public array $piecesQuantiks;

        // Constructeur
        public function __construct() {
            
            $this->piecesQuantiks = [];
        }


        // Méthode pour obtenir une PieceQuantik à une position donnée
        public function getPieceQuantik(int $pos):  PieceQuantik {
            return $this->piecesQuantiks[$pos];
        }

        // Méthode pour définir une PieceQuantik à une position donnée
        public function setPieceQuantik(int $pos, PieceQuantik $piece) {
            $this->piecesQuantiks[$pos] = $piece;
        }

        // Méthode pour ajouter une PieceQuantik
        public function addPieceQuantik(PieceQuantik $piece) {
            $this->piecesQuantiks[] = $piece;
        }

        // Méthode pour supprimer une PieceQuantik à une position donnée
        public function removePieceQuantik(int $pos): void {
            // Supprime la pièce à la position spécifiée
            unset($this->piecesQuantiks[$pos]);
        
            // Réindexe le tableau pour éviter les clés manquantes
            $this->piecesQuantiks = array_values($this->piecesQuantiks);
        }
        

        public static function initPiecesNoires(): ArrayPieceQuantik {
            $resultat = new ArrayPieceQuantik();
            $resultat->setPieceQuantik(0, PieceQuantik::initBlackCube());
            $resultat->setPieceQuantik(1, PieceQuantik::initBlackCube());
            $resultat->setPieceQuantik(2, PieceQuantik::initBlackCone());
            $resultat->setPieceQuantik(3, PieceQuantik::initBlackCone());
            $resultat->setPieceQuantik(4, PieceQuantik::initBlackCylindre());
            $resultat->setPieceQuantik(5, PieceQuantik::initBlackCylindre());
            $resultat->setPieceQuantik(6, PieceQuantik::initBlackSphere());
            $resultat->setPieceQuantik(7, PieceQuantik::initBlackSphere());
            return $resultat;
        }

        public static function initPiecesBlanches(): ArrayPieceQuantik {
            $resultat = new ArrayPieceQuantik();

            $resultat->setPieceQuantik(0, PieceQuantik::initWHiteCube());
            $resultat->setPieceQuantik(1, PieceQuantik::initWhiteCube());
            $resultat->setPieceQuantik(2, PieceQuantik::initWhiteCone());
            $resultat->setPieceQuantik(3, PieceQuantik::initWhiteCone());
            $resultat->setPieceQuantik(4, PieceQuantik::initWhiteCylindre());
            $resultat->setPieceQuantik(5, PieceQuantik::initWhiteCylindre());
            $resultat->setPieceQuantik(6, PieceQuantik::initWhiteSphere());
            $resultat->setPieceQuantik(7, PieceQuantik::initWhiteSphere());
            return $resultat;
        }

        // Méthode pour obtenir la représentation en chaîne de l'objet
        public function __toString(): string {
            
            return implode("", $this->piecesQuantiks);
        }

        // Implementation de l'interface Countable
        public function count(): int {
            return count($this->piecesQuantiks);
        }
        public function offsetUnset(mixed $offset) {
            unset($this->piecesQuantiks[$offset]);
        }
        public function offsetExists(mixed $offset) {
            return $offset < sizeof($this->piecesQuantiks);
        }
        public function offsetSet(mixed $offset, mixed $value){
            $this->piecesQuantiks[] = $value;
        }
        public function offsetGet(mixed $offset) {
            return isset($this->piecesQuantiks[$offset]) ? $this->piecesQuantiks[$offset] : null;
        }
        

        public function getJson(): string
        {
            $json = "[";
            $jTab = [];
            foreach ($this->piecesQuantiks as $p)
                $jTab[] = $p->getJson();
            $json .= implode(',', $jTab);
            return $json . ']';
        }
        public static function initArrayPieceQuantik(string|array $json): ArrayPieceQuantik
        {
            $apq = new ArrayPieceQuantik();
            if (is_string($json)) {
                $json = json_decode($json);
            }
            foreach ($json as $j)
                $apq[] = PieceQuantik::initPieceQuantik($j);
            return $apq;
        }
    }
    ?>