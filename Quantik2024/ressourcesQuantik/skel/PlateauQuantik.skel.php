<?php

//namespace Quantik2024;

class PlateauQuantik
{
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
