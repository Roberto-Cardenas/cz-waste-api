<?php
  //Headers
  header('Content-Type: application/json');
  header('Access-Control-Allow-Origin: *');
  header('Access-Control-Allow-Headers: content-type');

  // Get passed in info
  $object = json_decode(file_get_contents("php://input"), true);
  $user = $object['user'];
  $pass = $object['passphrase'];

  // Get saved auth info
  $authObject = json_decode(file_get_contents("../json/auth-data.json"), true);

  // Authenticate information
  if ($user == $authObject['user'] && password_verify($pass, $authObject['passphraseHash'])) {
    // Create token for this login
    $token = hash("sha512", date('Y-m-d H:i:s') . random_bytes(32));
    $authObject['tokenHash'] = hash("sha512", $token);

    // Save information to disk
    $file = fopen("../json/auth-data.json", "w") or die("No write permissions");
    fwrite($file, json_encode($authObject));
    fclose($file);

    // Print response body
    print_r(json_encode(array(
      'ok' => 1,
      'token' => $token
    )));
  } else {
    // Print response body
    print_r(json_encode(array(
      'ok' => 0
    )));
  }
?>