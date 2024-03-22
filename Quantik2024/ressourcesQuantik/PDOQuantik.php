<?php

;namespace Quantik2024;
require_once 'Player.php';

use PDO;
use PDOStatement;
use Quantik2024\Player;



class PDOQuantik
{
    private static PDO $pdo;

    public static function initPDO(string $sgbd, string $host, string $db, string $user, string $password, string $nomTable = ''): void
    {
        switch ($sgbd) {
            case 'pgsql':
                self::$pdo = new PDO('pgsql:host=' . $host . ' dbname=' . $db . ' user=' . $user . ' password=' . $password);
                break;
            case 'mysql':
                self::$pdo = new PDO('mysql:host=' . $host . ';dbname=' . $db, $user, $password);
                break;
            default:
                exit ("Type de sgbd non correct : $sgbd fourni, 'mysql' ou 'pgsql' attendu");
        }

        // pour récupérer aussi les exceptions provenant de PDOStatement
        self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    /* requêtes Préparées pour l'entitePlayer */
    private static PDOStatement $createPlayer;
    private static PDOStatement $selectPlayerByName;

    /******** Gestion des requêtes relatives à Player *************/
    public static function createPlayer(string $name): Player
    {
        if (!isset(self::$createPlayer))
            self::$createPlayer = self::$pdo->prepare('INSERT INTO Player(name) VALUES (:name)');
        self::$createPlayer->bindValue(':name', $name, PDO::PARAM_STR);
        self::$createPlayer->execute();
        return self::selectPlayerByName($name);
    }

    public static function selectPlayerByName(string $name): ?Player
    {
        if (!isset(self::$selectPlayerByName))
            self::$selectPlayerByName = self::$pdo->prepare('SELECT * FROM Player WHERE name=:name');
        self::$selectPlayerByName->bindValue(':name', $name, PDO::PARAM_STR);
        self::$selectPlayerByName->execute();
        $player = self::$selectPlayerByName->fetchObject('Quantik2024\Player');
        return ($player instanceof Player) ? $player : null;
    }

    /* requêtes préparées pour l'entiteGameQuantik */
    private static PDOStatement $createGameQuantik;
    private static PDOStatement $saveGameQuantik;
    private static PDOStatement $addPlayerToGameQuantik;
    private static PDOStatement $selectGameQuantikById;
    private static PDOStatement $selectAllGameQuantik;
    private static PDOStatement $selectAllGameQuantikByPlayerName;

    /******** Gestion des requêtes relatives à QuantikGame *************/

    /**
     * initialisation et execution de $createGameQuantik la requête préparée pour enregistrer une nouvelle partie
     */
    public static function createGameQuantik(string $playerName, string $json): void
    {
        if (!isset(self::$createGameQuantik)) {
            self::$createGameQuantik = self::$pdo->prepare('INSERT INTO QuantikGame(playerOne, json) VALUES (:playerOne, :json)');
        }
        $player = self::selectPlayerByName($playerName);
        self::$createGameQuantik->bindValue(':playerOne', $player->getId(), PDO::PARAM_INT);
        self::$createGameQuantik->bindValue(':json', $json, PDO::PARAM_STR);
        self::$createGameQuantik->execute();
    }

    /**
     * initialisation et execution de $saveGameQuantik la requête préparée pour changer
     * l'état de la partie et sa représentation json
     */
    public static function saveGameQuantik(string $gameStatus, string $json, int $gameId): void
    {
        if (!isset(self::$saveGameQuantik)) {
            self::$saveGameQuantik = self::$pdo->prepare('UPDATE QuantikGame SET gameStatus = :gameStatus, json = :json WHERE gameId = :gameId');
        }
        self::$saveGameQuantik->bindValue(':gameStatus', $gameStatus, PDO::PARAM_STR);
        self::$saveGameQuantik->bindValue(':json', $json, PDO::PARAM_STR);
        self::$saveGameQuantik->bindValue(':gameId', $gameId, PDO::PARAM_INT);
        self::$saveGameQuantik->execute();
    }
    /**
     * initialisation et execution de $addPlayerToGameQuantik la requête préparée pour intégrer le second joueur
     */
    public static function addPlayerToGameQuantik(string $playerName, int $gameId): void
    {
        if (!isset(self::$addPlayerToGameQuantik)) {
            self::$addPlayerToGameQuantik = self::$pdo->prepare('UPDATE QuantikGame SET playerTwo = :playerTwo WHERE gameId = :gameId');
        }
        $player = self::selectPlayerByName($playerName);
        self::$addPlayerToGameQuantik->bindValue(':playerTwo', $player->getId(), PDO::PARAM_INT);
        self::$addPlayerToGameQuantik->bindValue(':gameId', $gameId, PDO::PARAM_INT);
        self::$addPlayerToGameQuantik->execute();
    }

    /**
     * initialisation et execution de $selectAllGameQuantikById la requête préparée pour récupérer
     * une instance de quantikGame en fonction de son identifiant
     */
    public static function getGameQuantikById(int $gameId): ?QuantikGame
    {
        if (!isset(self::$selectGameQuantikById)) {
            self::$selectGameQuantikById = self::$pdo->prepare('SELECT * FROM QuantikGame WHERE gameId = :gameId');
        }
        self::$selectGameQuantikById->bindValue(':gameId', $gameId, PDO::PARAM_INT);
        self::$selectGameQuantikById->execute();
        $game = self::$selectGameQuantikById->fetchObject('Quantik2024\QuantikGame');
        return ($game) ? $game : null;
    }
    /**
     * initialisation et execution de $selectAllGameQuantik la requête préparée pour récupérer toutes
     * les instances de quantikGame
     */
    public static function getAllGameQuantik(): array
    {
        if (!isset(self::$selectAllGameQuantik)) {
            self::$selectAllGameQuantik = self::$pdo->prepare('SELECT * FROM QuantikGame');
        }
        self::$selectAllGameQuantik->execute();
        return self::$selectAllGameQuantik->fetchAll(PDO::FETCH_CLASS, 'Quantik2024\QuantikGame');
    }


    /**
     * initialisation et execution de $selectAllGameQuantikByPlayerName la requête préparée pour récupérer les instances
     * de quantikGame accessibles au joueur $playerName
     * ne pas oublier les parties "à un seul joueur"
     */
    public static function getAllGameQuantikByPlayerName(string $playerName): array
    {
        if (!isset(self::$selectAllGameQuantikByPlayerName)) {
            self::$selectAllGameQuantikByPlayerName = self::$pdo->prepare('SELECT * FROM QuantikGame WHERE playerOne = :playerId OR playerTwo = :playerId');
        }
        $player = self::selectPlayerByName($playerName);
        self::$selectAllGameQuantikByPlayerName->bindValue(':playerId', $player->getId(), PDO::PARAM_INT);
        self::$selectAllGameQuantikByPlayerName->execute();
        return self::$selectAllGameQuantikByPlayerName->fetchAll(PDO::FETCH_CLASS, 'Quantik2024\QuantikGame');
    }
    /**
     * initialisation et execution de la requête préparée pour récupérer
     * l'identifiant de la dernière partie ouverte par $playername
     */
    public static function getLastGameIdForPlayer(string $playerName): int
    {
        if (!isset(self::$getLastGameIdForPlayer)) {
            self::$getLastGameIdForPlayer = self::$pdo->prepare('SELECT MAX(gameId) AS lastGameId FROM QuantikGame WHERE playerOne = :playerId OR playerTwo = :playerId');
        }
        $player = self::selectPlayerByName($playerName);
        self::$getLastGameIdForPlayer->bindValue(':playerId', $player->getId(), PDO::PARAM_INT);
        self::$getLastGameIdForPlayer->execute();
        $result = self::$getLastGameIdForPlayer->fetch(PDO::FETCH_ASSOC);
        return $result['lastGameId'] ?? 0;
    }
}
?>