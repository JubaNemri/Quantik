<?php

namespace Quantik2024;

use ArrayAccess;
use Countable;

require_once("../../ArrayPieceQuantik.php");
class ArrayPieceQuantik implements ArrayAccess, Countable
{
    /* TODO implantation schéma UML */
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