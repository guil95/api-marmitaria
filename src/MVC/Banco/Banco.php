<?php

namespace MVC\Banco;

/**
 * Description of BancoDeDados
 *
 * @author Guilherme
 */
class Banco {

    public static $instncia;

    private function __construct($u, $s, $h, $b) {
//       'mysql:dbname=phpconfbr;host=localhost';
    }

    public static function connectDb($u, $s, $h, $b) {
        if (self::$instncia === NULL) {
            $dsn = 'mysql:dbname=' . $b . ';host=' . $h;
            self::$instncia = new \PDO($dsn, $u, $s);
        }
        return self::$instncia;
    }

}
