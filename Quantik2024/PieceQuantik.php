<?php

    /**
     * Classe PieceQuantik
     * @author Juba NEMRI
     *
     */
    class PieceQuantik {

        const WHITE = 0 ;   // couleur blanche
        const BLACK = 1 ;   // couleur noire 
        const VOID = 0;    
        const CUBE = 1 ;
        const CONE = 2 ;
        const CYLINDRE = 3; 
        const SPHERE = 4 ;

        protected int $forme; 
        protected int $couleur ;

        
        // Constructeur privé pour restreindre l'instanciation à l'intérieur de la classe
        private function __construct( $forme , $couleur)
        {
            $this->forme = $forme ;
            $this->couleur = $couleur ;
        }

        //retourne la forme
        public function getForme() : int 
        {
            return $this->forme ;
        }

        //retourne la couleur 
        public function getCouleur() : int
        {
            return $this->couleur;
        }

       // Méthode pour afficher la représentation de l'objet sous forme de chaîne
        public  function __toString(): string
        {
            $formeString = "";
            $couleurString = "";

            switch ($this->forme) {
                case self::CUBE:
                    $formeString = "Cu";
                    break;
                case self::CONE:
                    $formeString = "Co";
                    break;
                case self::CYLINDRE:
                    $formeString = "Cy";
                    break;
                case self::SPHERE :
                    $formeString = "Sp";
                    break;
            }

            switch ($this->couleur) {
                case self::WHITE:
                    $couleurString = ":B";
                    break;
                case self::BLACK:
                    $couleurString = ":N";
                    break;
            }

            return "(" . $formeString . $couleurString . ")";
        }


        // Méthodes statiques pour initialiser des pièces prédéfinies
        // self fait référence à la classe courante " PieceQuantik " 
        public static function initVOID(): PieceQuantik
        {
            return new PieceQuantik(self:: VOID,self :: VOID);
        }

        public static function initWhiteCube() : PieceQuantik
        {
            return new PieceQuantik(self:: CUBE,self :: WHITE);
        }

        public static function initBLackCube() : PieceQuantik
        {
            return new PieceQuantik(self:: CUBE,self :: BLACK);
        }

        public static function initWhiteCone() : PieceQuantik
        {
            return new PieceQuantik(self:: CONE,self :: WHITE);
        }

        public static function initBLackCone() : PieceQuantik
        {
            return new PieceQuantik(self:: CONE,self :: BLACK);
        }
        public static function initWhiteCylindre() : PieceQuantik
        {
            return new PieceQuantik(self:: CYLINDRE,self :: WHITE);
        }

        public static function initBLackCylindre() : PieceQuantik
        {
            return new PieceQuantik(self:: CYLINDRE,self :: BLACK);
        }
        public static function initWhiteSphere() : PieceQuantik
        {
            return new PieceQuantik(self:: SPHERE,self :: WHITE);
        }

        public static  function initBLackSphere() : PieceQuantik
        {
            return new PieceQuantik(self:: SPHERE,self :: BLACK);
        }
      
        
    /* TODO implantation schéma UML */
    public function getJson(): string {
        return '{"forme":'. $this->forme . ',"couleur":'.$this->couleur. '}';
    }

    public static function initPieceQuantik(string|object $json): PieceQuantik {
        if (is_string($json)) {
            $props = json_decode($json, true);
            return new PieceQuantik($props['forme'], $props['couleur']);
        }
        else
            return new PieceQuantik($json->forme, $json->couleur);
    }
}


?>