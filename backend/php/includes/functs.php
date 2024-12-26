<?php 

  require_once 'conn.php';

  function connectDB() {

    $status = array(
      'success' => false,
      'database' => 'placeholder',
      'errors' => 'placeholder'
    );

    $db = new mysqli($server, $application, $password, $database);

    if($db->connect_error) {
    
      $status['success'] = false;
      $status['errors'] = array(
        'errors' => true,
        'errno' => mysqli_connect_errno(),
        'error' => mysqli_connect_error()
      );

      return $status;
    }

    # returns this if db connection succeeded
    $status['success'] = true;
    $status['database'] = $db;
    return $status;
  }

  function checkGET($request) {

    $status = array(
        'success' => false,
        'request' => 'placeholder',
        'errors' => 'placeholder'
    );

    # confirms the request exists
    if (!isset($request) || $request == null) { 
        $status['errors'] = array('error' => 'payload not set or is null');
        return $status
    }

    $sql = $request['sql'];

    # error-checking contents of request for invalid parameters
    foreach($sql as $table => $colValPairs) {
    
      # this checks for invalid table names
      if ($table != 'courses' || $table != 'exams' || $table != 'dates') {
        $status['errors'] = array('error' => 'payload keys must be valid db tables (courses, exams, or dates)');
        return $status;
      }

      # this makes sure there are no null values
      foreach($colValPairs as $column => $value) {
        if ($value == null) {
            $status['errors'] = array('error' => 'column ' . $column . ' had a null associated value. column values cannot be null');
            return $status;
        }
      }
    }
  
    $status['success'] = true;
    $status['request'] = $request;
    return $status;
}

function fetchPDF($pdfName) {
  
  $results = array();
  $files = scandir('../exams/');

  foreach($files as $file) {
    if (strpos($file, $pdfName) !== false)
    $results[] =  'exams/' . $file;
  }

  if (count($results) == 0) {
    return $results;
  }

  return $results;
}

function spitErrors($status) {
  echo '<h3>WARNING: An Error Occurred in PHP file</h3>';
  foreach($status['errors'] as $key => $value) {
    echo '<p> ' . $key . ':   ' . $value . '</p>';
  }
  echo '<p>end of errors. exiting php file.</php>';
}

function uploadBinary($filepath) {
  
  $db = connectDB();

  $filePath = $filepath;
  $fileName = basename($filePath);
  $fileData = file_get_contents($filePath);


  $dbStatus = connectDB();
 
  if ($dbStatus['success'] == false) {

    echo '<h3>WARNING: Error with connecting to db</h3>';
    foreach($dbStatus['errors'] as $key => $value) {
      echo '<p> ' . $key . ':   ' . $value . '</p>';
    }
    echo '<p>end of errors. exiting php file.</php>';
    exit;
  }

  $db = $dbStatus['database'];

  $insertStatement = $db->prepare("INSERT INTO exams (name, exam_pdf VALUES (:name, :data)");
  $stmt->execute([':name' => $fileName, ':data' => $fileData]);
?>

} 
?>