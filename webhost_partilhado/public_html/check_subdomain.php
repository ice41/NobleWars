<?php
echo "<pre>";
echo "Subdomínio atual: " . $_SERVER['HTTP_HOST'] . "\n";
echo "IP do servidor: " . gethostbyname($_SERVER['HTTP_HOST']) . "\n";
echo "Document Root: " . $_SERVER['DOCUMENT_ROOT'] . "\n";
echo "</pre>";