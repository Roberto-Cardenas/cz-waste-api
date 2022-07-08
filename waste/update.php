<?php
  //Headers
  header('Content-Type: application/json');
  header('Access-Control-Allow-Origin: *');
  header('Access-Control-Allow-Headers: content-type');
  header('Access-Control-Allow-Methods: PUT');

  // Get passed in info
  $object = json_decode(file_get_contents("php://input"), true);
  $token = $object['token'];
  $data = $object['object'];

  // Get saved auth info
  $authObject = json_decode(file_get_contents("../json/auth-data.json"), true);

  // Authenticate token
  if ($token == $authObject['token']) {
    // Save information to disk
    $file = fopen("../json/waste-data.json", "w") or die("No write permissions");
    fwrite($file, json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    fclose($file);

    // Print response body
    print_r(json_encode(array(
      'ok' => 1
    )));
  } else {
    // Print response body
    print_r(json_encode(array(
      'ok' => 0
    )));
  }
?>