<?php 
  require_once '/backend/php/includes/requests.inc.php';
  // this file is the target of ajax requests from frontend. api.php should then route the request to
  // one of the three options for database operations.

  
  echo 'here';
  ini_set('display_errors', 1);    // Display errors
  ini_set('display_startup_errors', 1);  // Display startup errors
  error_reporting(E_ALL);  // Report all errors, warnings, and notices


  $requestType = $_SERVER['REQUEST_METHOD'];
  $response = [];

  echo 'made it to api.php';

  if ($requestType === 'GET') {
    // Process GET request
    $response = handleGetRequest($_GET);
  } elseif ($requestType === 'POST') {
    // Process POST request
    $response = handlePostRequest($_POST);
  } elseif ($requestType === 'DELETE') {
    // Process DELETE request
    parse_str(file_get_contents("php://input"), $deleteData);
    $response = handleDeleteRequest($deleteData);
  } else {
    $response = ['error' => 'Invalid request type'];
  }
  
  header('Content-Type: application/json');
  echo json_encode($response);
?>