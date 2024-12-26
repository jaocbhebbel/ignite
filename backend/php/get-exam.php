<?php
  function getExamMain($request) {
    
  require_once 'includes/functs.php';

  function getExamMain($request) {
    
    # establishing a connection to the database

    $dbStatus = connectDB();  # defined in functs.php
    if ($dbStatus['success'] == false) {
      spitErrors($dbStatus);  # defined in functs.php
      exit;
    }

    $db = $dbStatus['database'];

    # now time to error check the get request
    
    # it should have a field 'payload'
    # payload is a collection of key/json pairs.
    # each key is a table, and each json is
    # a collection of col-val pairs to SELECT from

    # first check if payload is set
    $reqStatus = checkGET(json_decode($request['payload'], true););  # defined in functs.php
    if ($reqStatus['success'] == false) {
      spitErrors($reqStatus);  # defined in functs.php
      exit;
    }
    
    # how we want the response we send to front end to look like
    # 
    #  response = {
    #                exams = [
    #                           {major: _, course: _, crn: _, teacher: _, year: _, semester: _, exam-number: _},
    #                           {major: _, course: _, crn: _, teacher: _, year: _, semester: _, exam-number: _},
    #                           {major: _, course: _, crn: _, teacher: _, year: _, semester: _, exam-number: _}
    #                     ],
    #                 pdfs = {exam-name: binary}
    # }
    #   

    echo 'have connected to db and checked request';
    # copying variables from request 
    $payload = $reqStatus['request'];                   # is the actual get request 
    $sql = $payload['sql'];                             # a json of { table: {column: value} } data like that
    $returnExamBinaries = $payload['returnExamFiles'];  # a boolean that represents if the frontend wants pdf files
    
    $ids_for_join = array(                              # holds kv pairs of table and ids
      'courses' => array(),                             # used for the join statement
      'dates' => array()
    );

    # loops through sql to collect all relevant ids from db
    # when done, $ids_for_join has the relevant ids for each table under the proper key
    foreach($sql as $table => $colValPairs) {
      
      # template SQL statement to execute on db for collecting ids of relevant entries
      $tableStatement = 'select id from ' . $table . ' where 1=1';

      # prevents reading null in foreach loop
      if($colValPairs != null) {
        foreach($colValPairs as $column => $value) {
          $tableStatement .= " and " . $column . "=" . $value;
        }
      }
      
      # now executing sql statement + gathering exam info
      $table_ids = $db->query($tableStatement);
      $num_ids = $ids->num_rows();

      # collects all relevant ids grouped by table
      while($row = $table_ids->fetch_assoc()) {
        $ids_for_join[{$table}] =  $row['id'];
      }
    }
  
    /* now execute a 3-table join that selects the following:
      -major
      -course_name
      -course_number
      -crn
      -teacher
      -year
      -semester
      -exam number

      this is pretty much a select all excluding ids
      
      3 steps to do this:
      1. define the sql join query
      2. collect the ids of the relevant exams into a str specific to the id's table
      3. put the table-specific id str into the WHERE clause
    */


    # join statement changes if we want pdf files or not
    #implode function joins the contents of an array with some char

    $joinStatement = "
    SELECT courses.major, courses.course_name, courses.course_number, courses.crn, courses.teacher,
           dates.year, dates.semester, dates.exam_number" .
    ($returnExamBinaries ? ", exams.exam_name" : "") . "
    FROM courses
    JOIN exams ON courses.id = exams.id_courses
    JOIN dates ON dates.id = exams.id_dates
    WHERE exams.id_courses IN (" . implode(", ", $ids_for_join['courses']) . ") 
      AND exams.id_dates IN (" . implode(", ", $ids_for_join['dates']) . ")"; 


    $result = $db->query($joinStatement);

    # response variable needs to be sent to frontend
    $response = array('data' => array());

    while($row = $result->fetch_assoc()) {
      
      # exam array holds table data
      $exam = array(
        'major' => $row['major'],
        'course' => $row['course_name'],
        'crn' => $row['crn'],
        'teacher' => $row['teacher_name'],
        'year' => $row['year'],
        'semester' => $row['semester'],
        'number' => $row['exam_number']
      );

      $response['exams'][] = $exam;

      # if we want binaries, we add them here
      if($returnExamBinaries) {
        $filepath = '../exams/' . $row['exam_name'] . '.pdf';
        $response['pdfs'][$row['exam_name']] = file_exists($filepath) ? 
        base64_encode(file_get_contents($filepath)) : null; # sets as null if file doesn't exist
      }
    }

    return $response;
  }
  
  

  }
?>