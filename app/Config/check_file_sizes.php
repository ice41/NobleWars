<?php
$files = [
    'c:/Users/edu_I/OneDrive/Ambiente de Trabalho/Silnik Plemiona v8.3.1 by Bartekst221 pt/new_engine/public/modelo/lib/command.php',
    'c:/Users/edu_I/OneDrive/Ambiente de Trabalho/Silnik Plemiona v8.3.1 by Bartekst221 pt/new_engine/public/modelo/lib/events.php',
    'c:/Users/edu_I/OneDrive/Ambiente de Trabalho/Silnik Plemiona v8.3.1 by Bartekst221 pt/new_engine/public/modelo/lib/functions.php'
];

foreach ($files as $file) {
    if (file_exists($file)) {
        echo basename($file) . ": " . filesize($file) . " bytes\n";
    } else {
        echo basename($file) . " does not exist\n";
    }
}
