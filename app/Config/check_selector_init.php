<?php
$content = file_get_contents('c:/Users/edu_I/OneDrive/Ambiente de Trabalho/Silnik Plemiona v8.3.1 by Bartekst221 pt/new_engine/public/js/core_combined.js');
preg_match_all('/.*LanguageSelector.*/', $content, $matches);
foreach ($matches[0] as $line) {
    echo $line . "\n";
}
