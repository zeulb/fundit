<?php
namespace ProjectController {

include_once __DIR__ . '/../model/Project.php';

function createNewProject($title, $description, $goal, $deadline) {
  date_default_timezone_set("Asia/Singapore");

  $owner = $_SESSION['username'];
  $goal = floatval($goal);

  $unixTime = strtotime($deadline);
  if (!$unixTime) {
    return null;
  } else {
    $deadline = date("d-M-yh:i:s.u", $unixTime);
    $inner = "TO_TIMESTAMP('{$deadline}', 'DD-Mon-RRHH24:MI:SS.FF')";
    $statement = "SELECT {$inner} FROM dual";
    $deadline = \DBHandler::execute($statement, true)[$inner];
  }

  $statement = "INSERT INTO fundit_project (owner, title, description, goal, deadline) VALUES('{$owner}', '{$title}', '{$description}', {$goal}, '{$deadline}')";
  $r = \DBHandler::execute($statement, false);
  if (!$r) {
    return null;
  } else {
    $statement = "SELECT fundit_project_seq.CURRVAL FROM dual";
    $result = \DBHandler::execute($statement, true)[0];
    $id = intval($result['CURRVAL']);

    return new \Project($id, $ownerUsername, $title, $description, $goal, $deadline);
  }
}

function getProject($id) {
  $statement = "SELECT * FROM fundit_contribution WHERE project_id = {$id}";

  $result = \DBHandler::execute($statement, true);

  if (count($result) != 1) {
    return null;
  } else {
    $result = $result[0];
    return new \Project($result['ID'], $result['OWNERUSERNAME'], $result['TITLE'], $result['DESCRIPTION'], $result['GOAL'], $result['DEADLINE']);
  }
}

}

?>
