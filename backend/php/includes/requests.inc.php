<?php

  # this could be done in api.php, but
  # the IA is better masked like this

  require_once '../get-exam.php';
  require_once '../post-exam.php';
  require_once '../delete-exam.php';
  

  function handleGetRequest($req) {
    echo 'going to get-exam.php';
    return getExamMain($req);
  }

  function handlePostRequest($req) {
    return postExamMain($req);
  }

  function handleDeleteRequest($req) {
    return deleteExamMain($req);
  }

?>