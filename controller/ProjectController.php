<?php

namespace ProjectController {

include_once __DIR__ . '/../model/Project.php';
include_once __DIR__ . '/../helper/DateHelper.php';
include_once __DIR__ . '/../db/DBHandler.php';
include_once __DIR__ . '/UserController.php';
include_once __DIR__ . '/../helper/ArrayHelper.php';

function createNewProject($title, $description, $goal, $deadline) {
  date_default_timezone_set("Asia/Singapore");

  $owner = $_SESSION['username'];
  $goal = floatval($goal);
  $deadline = \DateHelper\convertToSqlFormatFromString($deadline);

  $statement = "SELECT fundit_project_seq.NEXTVAL FROM dual";
  $r = \DBHandler::execute($statement, true);
  $id = $r[0]['NEXTVAL'];

  $statement = "INSERT INTO fundit_project (id, owner, title, description, goal, deadline) VALUES({$id}, '{$owner}', '{$title}', '{$description}', {$goal}, '{$deadline}')";
  $r = \DBHandler::execute($statement, false);
  if (!$r) {
    return null;
  } else {
    $deadline = \DateHelper\beautifyDateFromSql($deadline);
    return new \Project($id, $owner, $title, $description, $goal, $deadline);
  }
}

function getProject($id) {
  $statement = "SELECT * FROM fundit_project WHERE id = {$id}";

  $result = \DBHandler::execute($statement, true);

  if (count($result) != 1) {
    return null;
  } else {
    $result = $result[0];
    $result['DEADLINE'] = \DateHelper\beautifyDateFromSql($result['DEADLINE']);
    return new \Project($result['ID'], $result['OWNER'], $result['TITLE'], $result['DESCRIPTION'], $result['GOAL'], $result['DEADLINE']);
  }
}

function getAllProject($sortByColumn = null) {
  $statement = "SELECT * FROM fundit_project ORDER BY id DESC";

  if (isset($sortByColumn) && \ArrayHelper\is_assoc($sortByColumn)) {
    $statement .= " ORDER BY";
    $first = true;
    foreach ($sortByColumn as $key => $value) {
      if (!$first) {
        $statement .= ", {$key} {$value}";
      } else {
        $statement .= " {$key} {$value}";
      }
      $first = false;
    }
  }

  $result = \DBHandler::execute($statement, true);

  $projects = array();
  foreach ($result as $res) {
    $res['DEADLINE'] = \DateHelper\beautifyDateFromSql($res['DEADLINE']);
    $projects[] = new \Project($res['ID'], $res['OWNER'], $res['TITLE'], $res['DESCRIPTION'], $res['GOAL'], $res['DEADLINE']);
  }

  return $projects;
}

function getAllProjectPopular() {
  $statement = "SELECT p.title FROM fundit_project p LEFT OUTER JOIN (SELECT project_id AS pid, SUM(AMOUNT) as total FROM fundit_contribution GROUP BY project_id) s ON p.id = s.pid ORDER BY COALESCE(total, 0) DESC;";

  $result = \DBHandler::execute($statement, true);

  $projects = array();
  foreach ($result as $res) {
    $res['DEADLINE'] = \DateHelper\beautifyDateFromSql($res['DEADLINE']);
    $projects[] = new \Project($res['ID'], $res['OWNER'], $res['TITLE'], $res['DESCRIPTION'], $res['GOAL'], $res['DEADLINE']);
  }

  return $projects;
}

function removeProject($projectId) {
  if (\UserController\canActiveUserModifyProject($projectId)) {
    $statement = "DELETE FROM fundit_project WHERE project_id = {$projectId}";
    $result = \DBHandler::execute($statement, false);
    return $result;
  } else {
    return null;
  }
}

}

?>
