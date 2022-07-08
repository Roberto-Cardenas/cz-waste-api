<?php
  //Headers
  header('Content-Type: application/json');
  header('Access-Control-Allow-Origin: *');
  header('Access-Control-Allow-Headers: content-type');

  // Get saved auth info
  $wasteObject = file_get_contents("../json/waste-data.json");

  print_r($wasteObject);
?>