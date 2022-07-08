<?php
  //Headers
  header('Content-Type: application/json');
  header('Access-Control-Allow-Origin: *');
  header('Access-Control-Allow-Headers: content-type');
  header('Access-Control-Allow-Methods: PUT');

  // Imports
  require '../vendor/autoload.php';

  // Get passed in info
  $object = json_decode(file_get_contents("php://input"), true);
  $token = $object['token'];
  $data = $object['object'];

  // Get saved auth info
  $authObject = json_decode(file_get_contents("../json/auth-data.json"), true);

  // Authenticate token
  if (hash("sha512", $token) == $authObject['tokenHash']) {
    // Validate object format
    $pattern = [
      "data" => [
        "*" => [
          "name" => ":string",
          "id" => ":string :regexp('#\d*#')",
          "description" => ":string",
          "entries" => [
            "*" => [
              "id" => ":string :regexp('#\d*#')",
              "name" => ":string"
            ],
          ],
          "titleCardColor" => ":number",
          "itemsListColor" => ":string"
        ],
      ],
    ];

    $builder = \PASVL\Validation\ValidatorBuilder::forArray($pattern);
    $validator = $builder->build();

    try {
        $validator->validate($data);
    } catch (Exception $e) {
      die(json_encode(array(
        'ok' => 0,
        'message' => "Waste object is not formatted correctly. Refer to the GitHub ReadMe for more information."
      )));
    }

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