<?php

namespace App\Common;

class Environment
{

    /**
     * Metodo que carrega as variaveis .env do projeto
     */
    public static function loadEnv()
    {
        $path = __DIR__.'/../../.env';

        // Checar se o arquivo existe;
        if (!file_exists($path)) {
            return false;
        }

        // Definir variaveis de ambiente;
        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $lines = array_filter(array_map('trim', $lines), 'strlen');

        foreach ($lines as $line) {
            if ($line[0] == '#') {
                continue;
            }
            putenv($line);
        }
    }

}

?>
