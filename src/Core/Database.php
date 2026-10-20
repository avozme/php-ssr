
<?php

class Database
{
    private PDO $pdo;

    public function __construct()
    {
        // Cargamos la configuración
        $config = require __DIR__ . '/config.php';

        $db = $config['db'];

        // Creamos la conexión PDO
        $dsn = "mysql:host={$db['host']};dbname={$db['dbname']};charset={$db['charset']}";

        $this->pdo = new PDO(
            $dsn,
            $db['user'],
            $db['pass'],
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]
        );
    }

    /**
     * Ejecuta una consulta SQL y devuelve el PDOStatement.
     */
    public function query(string $sql, array $params = []): PDOStatement
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);

        return $stmt;
    }

    /**
     * Ejecuta una consulta y devuelve todos los registros.
     */
    public function fetchAll(string $sql, array $params = []): ?array
    {
        $result = $this->query($sql, $params)->fetchAll();

        return $result ?: null;
    }

    /**
     * Ejecuta una consulta y devuelve el primer registro.
     */
    public function fetchOne(string $sql, array $params = []): ?array
    {
        $result = $this->query($sql, $params)->fetch();

        return $result === false ? null : $result;
    }
}
