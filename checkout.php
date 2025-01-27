<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once 'keys.php';

// Crear el objeto client
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

<!DOCTYPE html>
<html>

<head>
  <title>Form Token</title>
  <link rel='stylesheet' href='css/style.css' />
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!-- Bootstrap -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootswatch@4.5.2/dist/journal/bootstrap.min.css"
      integrity="sha384-QDSPDoVOoSWz2ypaRUidLmLYl4RyoBWI44iA5agn6jHegBxZkNqgm2eHb6yZ5bYs" crossorigin="anonymous" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

  <!-- Libreria JS de la pasarela, debe incluir la clave pública -->
  <script type="text/javascript"
    src="https://static.micuentaweb.pe/static/js/krypton-client/V4.0/stable/kr-payment-form.min.js"
    kr-public-key="<?= $client->getPublicKey() ?>"
    kr-post-url-success="result.php" kr-language="es-Es">
  </script>

  <!-- Estilos de la pasarela de pagos -->
  <link rel="stylesheet" href="https://static.micuentaweb.pe/static/js/krypton-client/V4.0/ext/classic.css">
  <script type="text/javascript" src="https://static.micuentaweb.pe/static/js/krypton-client/V4.0/ext/classic.js">
  </script>
</head>
<body>
  <nav class="navbar bg-primary" style="background-color: #FF2D46!important;">
    <div class="container-fluid">
        <a href="/" class="navbar-brand mb-1"><img src="https://iziweb001b.s3.amazonaws.com/webresources/img/logo.png" width="80"></a>
    </div>
  </nav>
<section class="container">
  <div class="row">
    <div class="col-md-3"></div>
    <div class="center-column col-md-6">
      <section class="payment-form">
        <div class="row">
          <li>Pago con tarjeta de crédito/débito</li>
          <img src="https://github.com/izipay-pe/Imagenes/blob/main/logo_tarjetas_aceptadas/logo-tarjetas-aceptadas-351x42.png?raw=true" alt="Tarjetas aceptadas" style="width: 200px;">
        </div>
        <hr>
        <!-- HTML para incrustar pasarela de pagos -->  
        <div id="micuentawebstd_rest_wrapper">
          <div class="kr-embedded" kr-popin kr-form-token="<?= $formToken; ?>"></div>
        </div>
          <!---->
      </section>
    </div>
    <div class="col-md-3"></div>
  </div>
</section>
</body>
</html>