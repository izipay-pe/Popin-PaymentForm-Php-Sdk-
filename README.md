<p align="center">
  <img src="https://github.com/izipay-pe/Imagenes/blob/main/logos_izipay/logo-izipay-banner-1140x100.png?raw=true" alt="Formulario" width=100%/>
</p>

# Popin-PaymentForm-Php-Sdk

## Índice

➡️ [1. Introducción](#-1-introducci%C3%B3n)  
🔑 [2. Requisitos previos](#-2-requisitos-previos)  
🚀 [3. Ejecutar ejemplo](#-3-ejecutar-ejemplo)  
🔗 [4. Pasos de integración](#4-pasos-de-integraci%C3%B3n)  
💻 [4.1. Desplegar pasarela](#41-desplegar-pasarela)  
💳 [4.2. Analizar resultado de pago](#42-analizar-resultado-del-pago)  
📡 [4.3. Pase a producción](#43pase-a-producci%C3%B3n)  
🎨 [5. Personalización](#-5-personalizaci%C3%B3n)  
📚 [6. Consideraciones](#-6-consideraciones)

## ➡️ 1. Introducción

En este manual podrás encontrar una guía paso a paso para configurar un proyecto de **[PHP]** con la pasarela de pagos de IZIPAY a través de nuestro **[SDK]**. Te proporcionaremos instrucciones detalladas y credenciales de prueba para la instalación y configuración del proyecto, permitiéndote trabajar y experimentar de manera segura en tu propio entorno local.
Este manual está diseñado para ayudarte a comprender el flujo de la integración de la pasarela para ayudarte a aprovechar al máximo tu proyecto y facilitar tu experiencia de desarrollo.

> [!IMPORTANT]
> En la última actualización se agregaron los campos: **nombre del tarjetahabiente** y **correo electrónico** (Este último campo se visualizará solo si el dato no se envía en la creación del formtoken). 

<p align="center">
  <img src="https://github.com/izipay-pe/Imagenes/blob/main/formulario_popin/Imagen-Formulario-Popin.png?raw=true" alt="Formulario" width="350"/>
</p>

## 🔑 2. Requisitos Previos

- Comprender el flujo de comunicación de la pasarela. [Información Aquí](https://secure.micuentaweb.pe/doc/es-PE/rest/V4.0/javascript/guide/start.html)
- Extraer credenciales del Back Office Vendedor. [Guía Aquí](https://github.com/izipay-pe/obtener-credenciales-de-conexion)
- Para este proyecto utilizamos la herramienta Visual Studio Code.
- Servidor Web
- PHP 7.0 o superior
> [!NOTE]
> Tener en cuenta que, para que el desarrollo de tu proyecto, eres libre de emplear tus herramientas preferidas.

## 🚀 3. Ejecutar ejemplo

### Instalar Xampp u otro servidor local compatible con php

Xampp, servidor web local multiplataforma que contiene los intérpretes para los lenguajes de script de php. Para instalarlo:

1. Dirigirse a la página web de [xampp](https://www.apachefriends.org/es/index.html)
2. Descargarlo e instalarlo.
3. Inicia los servicios de Apache desde el panel de control de XAMPP.


### Clonar el proyecto
```sh
git https://github.com/izipay-pe/Popin-PaymentForm-Php-Sdk.git
``` 

### Instalar SDK
El SDK (Lyra Network) está disponible vía `Composer/Packagist`. En el presente ejemplo ya se encuentra importado.
```sh
composer require lyracom/rest-php-sdk:4.0.*

``` 

### Datos de conexión 

Reemplace **[CHANGE_ME]** con sus credenciales de `API REST` extraídas desde el Back Office Vendedor, revisar [Requisitos previos](#-2-requisitos-previos).

- Editar el archivo `keys.php` en la ruta raiz del proyecto:
```php
// Identificador de su tienda
Lyra\Client::setDefaultUsername("~ CHANGE_ME_USER_ID ~");

// Clave de Test o Producción
Lyra\Client::setDefaultPassword("~ CHANGE_ME_PASSWORD ~");

// Clave Pública de Test o Producción
Lyra\Client::setDefaultPublicKey("~ CHANGE_ME_PUBLIC_KEY ~");

// Clave HMAC-SHA-256 de Test o Producción
Lyra\Client::setDefaultSHA256Key("~ CHANGE_ME_HMAC_SHA_256 ~");
```

### Ejecutar proyecto

1. Mover el proyecto y descomprimirlo en la carpeta htdocs en la ruta de instalación de Xampp: `C://xampp/htdocs/[proyecto_php]`

2.  Abrir el navegador web(Chrome, Mozilla, Safari, etc) con el puerto 80 que abrió xampp : `http://localhost/[nombre_de_proyecto]`


## 🔗4. Pasos de integración

<p align="center">
  <img src="https://i.postimg.cc/pT6SRjxZ/3-pasos.png" alt="Formulario" />
</p>

## 💻4.1. Desplegar pasarela
### Autentificación
Extraer las claves de `usuario` y `contraseña` del Backoffice Vendedor, configurarlo en el archivo `./keys.php`  para que el SDK lo utilice en el proceso de autenticación al consumir nuestros servicios REST.
```php
// Identificador de su tienda
Lyra\Client::setDefaultUsername("~ CHANGE_ME_USER_ID ~");

// Clave de Test o Producción
Lyra\Client::setDefaultPassword("~ CHANGE_ME_PASSWORD ~");
```
ℹ️ Para más información: [Autentificación](https://secure.micuentaweb.pe/doc/es-PE/rest/V4.0/javascript/guide/embedded/keys.html)
### Crear formtoken
Para configurar la pasarela se necesita generar un formtoken. Se realizará una solicitud API REST a la api de creación de pagos:  `https://api.micuentaweb.pe/api-payment/V4/Charge/CreatePayment` con los datos de la compra para generar el formtoken. Podrás encontrarlo en el archivo `checkout.php` (con el SDK este proceso es sencillo) . 

```php
$client = new Lyra\Client();

$store = [
    "amount" => $_POST["amount"] * 100,
    "currency" => $_POST["currency"],
    "orderId" => $_POST["orderId"],
    "customer" => [
      "email" => $_POST["email"],
      "billingDetails" => [
        "firstName"=>  $_POST["firstName"],
        "lastName"=>  $_POST["lastName"],
        "phoneNumber"=>  $_POST["phoneNumber"],
        "identityType"=>  $_POST["identityType"],
        "identityCode"=>  $_POST["identityCode"],
        "address"=>  $_POST["address"],
        "country"=>  $_POST["country"],
        "city"=>  $_POST["city"],
        "state"=>  $_POST["state"],
        "zipCode"=>  $_POST["zipCode"],
      ]
    ],
];

$response = $client->post("V4/Charge/CreatePayment", $store);

$formToken = $response["answer"]["formToken"];
?>

```
ℹ️ Para más información: [Formtoken](https://secure.micuentaweb.pe/doc/es-PE/rest/V4.0/javascript/guide/embedded/formToken.html)
### Visualizar formulario
Para desplegar la pasarela, configura la llave `public key` en el encabezado (Header) del archivo `checkout.php`. Esta llave debe ser extraída desde el Back Office del Vendedor (El SDK ya realiza este proceso).

Header: 
Se coloca el script de la libreria necesaria para importar las funciones y clases principales de la pasarela.
```javascript
<script type="text/javascript"
    src="https://static.micuentaweb.pe/static/js/krypton-client/V4.0/stable/kr-payment-form.min.js"
    kr-public-key="<?= $client->getPublicKey() ?>"
    kr-post-url-success="result.php" kr-language="es-Es">
</script>

<!-- Estilos de la pasarela de pagos -->
<link rel="stylesheet" href="https://static.micuentaweb.pe/static/js/krypton-client/V4.0/ext/classic.css">
<script type="text/javascript" src="https://static.micuentaweb.pe/static/js/krypton-client/V4.0/ext/classic.js">
</script>
```
Además, se inserta en el body una etiqueta div con la clase `kr-embedded` que deberá tener el atributo `kr-form-token` e incrustarle el `formtoken` generado en la etapa anterior.

Body:
```javascript
<div id="micuentawebstd_rest_wrapper">
  <div class="kr-embedded" kr-popin kr-form-token="<?= $formToken; ?>"></div>
</div>
```
ℹ️ Para más información: [Visualizar formulario](https://secure.micuentaweb.pe/doc/es-PE/rest/V4.0/javascript/guide/embedded/formToken.html)

## 💳4.2. Analizar resultado del pago

### Validación de firma
Se invoca a la función `checkhash()` del SDK que realizará la validación de los datos del parámetro `kr-answer` utilizando una clave de encriptación definida por el parámetro `kr-hash-key`. Podrás encontrarlo en el archivo `result.php`.

```php
$client = new Lyra\Client();

if (empty($_POST)) {
    throw new Exception("No post data received!");
}

// Validación de firma
if (!$client->checkHash()) {
    throw new Exception("Invalid signature");
}
```

En caso que la validación sea exitosa, se puede extraer los datos de `kr-answer` a través de un JSON y mostrar los datos del pago realizado.

```php
// Obtenemos el resultado del pago
$formAnswer = $client->getParsedFormAnswer();

$answer = $formAnswer["kr-answer"];
```
ℹ️ Para más información: [Analizar resultado del pago](https://secure.micuentaweb.pe/doc/es-PE/rest/V4.0/kb/payment_done.html)

### IPN
La IPN es una notificación de servidor a servidor (servidor de Izipay hacia el servidor del comercio) que facilita información en tiempo real y de manera automática cuando se produce un evento, por ejemplo, al registrar una transacción.


Se realiza la verificación de la firma utilizando la función `checkHash`. Se devuelve al servidor de izipay un mensaje confirmando el estado del pago.

Se recomienda verificar el parámetro `orderStatus` para determinar si su valor es `PAID` o `UNPAID`. De esta manera verificar si el pago se ha realizado con éxito.

Podrás encontrarlo en el archivo `ipn.php`.

```php
$client = new Lyra\Client();  

// Validación de firma en IPN
if (!$client->checkHash()) {
    throw new Exception('Invalid signature');
}

$rawAnswer = $client->getParsedFormAnswer();
$answer = $rawAnswer['kr-answer'];
$transaction = $answer['transactions'][0];

//Verificar orderStatus: PAID / UNPAID
$orderStatus = $answer['orderStatus'];
$orderId = $answer['orderDetails']['orderId'];
$transactionUuid = $transaction['uuid'];

print 'OK! OrderStatus is ' . $orderStatus;
```

La ruta o enlace de la IPN debe ir configurada en el Backoffice Vendedor, en `Configuración -> Reglas de notificación -> URL de notificación al final del pago`

<p align="center">
  <img src="https://i.postimg.cc/XNGt9tyt/ipn.png" alt="Formulario" width=80%/>
</p>

ℹ️ Para más información: [Analizar IPN](https://secure.micuentaweb.pe/doc/es-PE/rest/V4.0/api/kb/ipn_usage.html)

### Transacción de prueba

Antes de poner en marcha su pasarela de pago en un entorno de producción, es esencial realizar pruebas para garantizar su correcto funcionamiento.

Puede intentar realizar una transacción utilizando una tarjeta de prueba con la barra de herramientas de depuración (en la parte inferior de la página).

<p align="center">
  <img src="https://i.postimg.cc/3xXChGp2/tarjetas-prueba.png" alt="Formulario"/>
</p>

- También puede encontrar tarjetas de prueba en el siguiente enlace. [Tarjetas de prueba](https://secure.micuentaweb.pe/doc/es-PE/rest/V4.0/api/kb/test_cards.html)

## 📡4.3.Pase a producción

Reemplace **[CHANGE_ME]** con sus credenciales de PRODUCCIÓN de `API REST` extraídas desde el Back Office Vendedor, revisar [Requisitos Previos](#-2-requisitos-previos).

- Editar en `keys.example.php` en la ruta raiz del proyecto:
```php
// Identificador de su tienda
Lyra\Client::setDefaultUsername("~ CHANGE_ME_USER_ID ~");

// Clave de Test o Producción
Lyra\Client::setDefaultPassword("~ CHANGE_ME_PASSWORD ~");

// Clave Pública de Test o Producción
Lyra\Client::setDefaultPublicKey("~ CHANGE_ME_PUBLIC_KEY ~");

// Clave HMAC-SHA-256 de Test o Producción
Lyra\Client::setDefaultSHA256Key("~ CHANGE_ME_HMAC_SHA_256 ~");
```

## 🎨 5. Personalización

Si deseas aplicar cambios específicos en la apariencia de la pasarela de pago, puedes lograrlo mediante la modificación de código CSS. En este enlace [Código CSS - Popin](https://github.com/izipay-pe/Personalizacion/blob/main/Formulario%20Popin/Style-Personalization-PopIn.css) podrá encontrar nuestro script para un formulario popin.

<p align="center">
  <img src="https://github.com/izipay-pe/Imagenes/blob/main/formulario_popin/Imagen-Formulario-Custom-Popin.png?raw=true" alt="Formulario"/>
</p>

## 📚 6. Consideraciones

Para obtener más información, echa un vistazo a:

- [Formulario incrustado: prueba rápida](https://secure.micuentaweb.pe/doc/es-PE/rest/V4.0/javascript/quick_start_js.html)
- [Primeros pasos: pago simple](https://secure.micuentaweb.pe/doc/es-PE/rest/V4.0/javascript/guide/start.html)
- [Servicios web - referencia de la API REST](https://secure.micuentaweb.pe/doc/es-PE/rest/V4.0/api/reference.html)
