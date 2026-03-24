<?php
/**
 * Grand Mall de Conakry — Classe Database (PDO)
 * 
 * Singleton PDO avec requêtes préparées pour prévenir les injections SQL.
 */

class Database {
    private static ?PDO $instance = null;

    /**
     * Obtenir l'instance PDO (singleton)
     */
    public static function getInstance(): PDO {
        if (self::$instance === null) {
            try {
                $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET;
                self::$instance = new PDO($dsn, DB_USER, DB_PASS, [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES   => false,
                ]);
            } catch (PDOException $e) {
                if (DEBUG_MODE) {
                    die('Erreur DB : ' . $e->getMessage());
                }
                die('Erreur de connexion à la base de données.');
            }
        }
        return self::$instance;
    }

    /**
     * Exécuter une requête préparée avec paramètres
     */
    public static function query(string $sql, array $params = []): PDOStatement {
        $stmt = self::getInstance()->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    /**
     * Récupérer toutes les lignes
     */
    public static function fetchAll(string $sql, array $params = []): array {
        return self::query($sql, $params)->fetchAll();
    }

    /**
     * Récupérer une seule ligne
     */
    public static function fetch(string $sql, array $params = []): ?array {
        $result = self::query($sql, $params)->fetch();
        return $result ?: null;
    }

    /**
     * Insérer et retourner l'ID
     */
    public static function insert(string $table, array $data): int {
        $columns = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));
        $sql = "INSERT INTO {$table} ({$columns}) VALUES ({$placeholders})";
        self::query($sql, array_values($data));
        return (int) self::getInstance()->lastInsertId();
    }

    /**
     * Mettre à jour
     */
    public static function update(string $table, array $data, string $where, array $whereParams = []): int {
        $set = implode(', ', array_map(fn($k) => "{$k} = ?", array_keys($data)));
        $sql = "UPDATE {$table} SET {$set} WHERE {$where}";
        $stmt = self::query($sql, array_merge(array_values($data), $whereParams));
        return $stmt->rowCount();
    }

    /**
     * Supprimer
     */
    public static function delete(string $table, string $where, array $params = []): int {
        $sql = "DELETE FROM {$table} WHERE {$where}";
        return self::query($sql, $params)->rowCount();
    }

    /**
     * Compter
     */
    public static function count(string $table, string $where = '1', array $params = []): int {
        $result = self::fetch("SELECT COUNT(*) as cnt FROM {$table} WHERE {$where}", $params);
        return $result ? (int) $result['cnt'] : 0;
    }
}
