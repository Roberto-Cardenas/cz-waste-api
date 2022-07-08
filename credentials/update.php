<?php
  // Headers
  header('Content-Type: application/json');
  header('Access-Control-Allow-Origin: *');
  header('Access-Control-Allow-Headers: content-type');
  header('Access-Control-Allow-Methods: PUT');

  // Config (For showcase server)
  $allow_update = false;

  // Get passed in info
  $object = json_decode(file_get_contents("php://input"), true);
  $token = $object['token'];
  $oldUsername = $object['oldUsername'];
  $oldPass = $object['oldPassphrase'];
  $newUsername = $object['newUsername'];
  $newPass = $object['newPassphrase'];

  // Get saved auth info
  $authObject = json_decode(file_get_contents("../json/auth-data.json"), true);

  // Authenticate information
  if ($allow_update
      && $oldUsername == $authObject['user'] 
      && password_verify($oldPass, $authObject['passphraseHash'])
      && hash("sha512", $token) == $authObject['tokenHash']) {

    // Update the user credentials in the auth object
    $authObject['user'] = $newUsername;
    $authObject['passphraseHash'] = password_hash($newPass, PASSWORD_DEFAULT); 

    // Save information to disk
    $file = fopen("../json/auth-data.json", "w") or die("No write permissions");
    fwrite($file, json_encode($authObject));
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