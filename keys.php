<?php
require_once __DIR__ . '/vendor/autoload.php';

// Identificador de su tienda
Lyra\Client::setDefaultUsername("~ CHANGE_ME_USER_ID ~");

// Clave de Test o Producción
Lyra\Client::setDefaultPassword("~ CHANGE_ME_PASSWORD ~");

// Clave Pública de Test o Producción
Lyra\Client::setDefaultPublicKey("~ CHANGE_ME_PUBLIC_KEY ~");

// Clave HMAC-SHA-256 de Test o Producción
Lyra\Client::setDefaultSHA256Key("~ CHANGE_ME_HMAC_SHA_256 ~");

Lyra\Client::setDefaultEndpoint("https://api.micuentaweb.pe");
Lyra\Client::setDefaultClientEndpoint("https://static.micuentaweb.pe");