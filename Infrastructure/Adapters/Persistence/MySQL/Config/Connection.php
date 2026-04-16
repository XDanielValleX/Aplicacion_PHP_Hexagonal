<?php

declare(strict_types=1);

namespace App\Infrastructure\Adapters\Persistence\MySQL\Config;

use PDO;
use PDOException;

final class Connection
{
    private PDO $pdo;

    /**
     * @param array{host:string,port:int,database:string,username:string,password:string,charset:string} $config
     */
    public function __construct(array $config)
    {
        $dsn = sprintf(
            'mysql:host=%s;port=%d;dbname=%s;charset=%s',
            $config['host'],
            $config['port'],
            $config['database'],
            $config['charset'],
        );

        try {
            $this->pdo = new PDO($dsn, $config['username'], $config['password'], [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]);
        } catch (PDOException $e) {
            // Do not leak credentials in errors
            throw new PDOException('Error conectando a la base de datos.', (int) $e->getCode());
        }
    }

    public function getConnection(): PDO
    {
        return $this->pdo;
    }
}
