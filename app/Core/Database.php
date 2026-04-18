<?php

namespace App\Core;

use PDO;
use PDOException;

class Database
{
    private static ?PDO $connection = null;

    public static function connection(): PDO
    {
        if (self::$connection === null) {
            $dsn = sprintf(
                'mysql:host=%s;port=%s;dbname=%s;charset=%s',
                config('db.host'),
                config('db.port'),
                config('db.name'),
                config('db.charset')
            );

            try {
                self::$connection = new PDO($dsn, config('db.username'), config('db.password'), [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ]);
            } catch (PDOException $e) {
                http_response_code(500);
                exit('Database connection failed: ' . $e->getMessage());
            }
        }

        return self::$connection;
    }
}
