<?php

/**
 * Classe AbstractGame
 * Cette classe abstraite permet de définir les éléments de base d'un jeu de plateau.
 * @author Wissam Kerrouche
 */

abstract class AbstractGame {

    protected int $gameID;
    protected array $players;

    public int $currentPlayer ;
    public string $gameStatus;

}
?>