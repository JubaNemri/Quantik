<?php

//namespace Quantik2024;

/**
 * Class PieceQuantik
 * @package Quantik2024
 */
class PieceQuantik
{

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
