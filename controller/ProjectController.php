<?php

namespace ProjectController {

include_once __DIR__ . '/../model/Project.php';
include_once __DIR__ . '/../helper/DateHelper.php';
include_once __DIR__ . '/../db/DBHandler.php';
include_once __DIR__ . '/UserController.php';
include_once __DIR__ . '/../helper/ArrayHelper.php';

function createNewProject($title, $description, $goal, $deadline, $category) {
  date_default_timezone_set("Asia/Singapore");

  $owner = $_SESSION['username'];
  $goal = floatval($goal);
  $createdDate = \DateHelper\convertToSqlFormatFromUnixTime(time());
  $deadline = \DateHelper\convertToSqlFormatFromString($deadline);

  $statement = "SELECT fundit_project_seq.NEXTVAL FROM dual";
  $r = \DBHandler::execute($statement, true);
  $id = $r[0]['NEXTVAL'];

  $statement = "INSERT INTO fundit_project (id, owner, title, description, goal, deadline, category, created_date) VALUES({$id}, '{$owner}', '{$title}', '{$description}', {$goal}, '{$deadline}', '{$category}', '{$createdDate}')";
  $r = \DBHandler::execute($statement, false);
  if (!$r) {
    return null;
  } else {
    $deadline = \DateHelper\beautifyDateFromSql($deadline);
    $createdDate = \DateHelper\beautifyDateFromSql($createdDate);
    return new \Project($id, $owner, $title, $description, $goal, $deadline, $category, $createdDate);
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
    $result['CREATED_DATE'] = \DateHelper\beautifyDateFromSql($result['CREATED_DATE']);
    return new \Project($result['ID'], $result['OWNER'], $result['TITLE'], $result['DESCRIPTION'], $result['GOAL'], $result['DEADLINE'], $result['CATEGORY'], $result['CREATED_DATE']);
  }
}

function getAllProject() {
  $statement = "SELECT * FROM fundit_project ORDER BY id DESC";

  $result = \DBHandler::execute($statement, true);

  $projects = array();
  foreach ($result as $res) {
    $res['DEADLINE'] = \DateHelper\beautifyDateFromSql($res['DEADLINE']);
    $res['CREATED_DATE'] = \DateHelper\beautifyDateFromSql($res['CREATED_DATE']);
    $projects[] = new \Project($res['ID'], $res['OWNER'], $res['TITLE'], $res['DESCRIPTION'], $res['GOAL'], $res['DEADLINE'], $res['CATEGORY'], $res['CREATED_DATE']);
  }

  return $projects;
}

function getAllProjectPopular() {
  $statement = "SELECT p.* FROM fundit_project p LEFT OUTER JOIN (SELECT project_id AS pid, SUM(AMOUNT) as total FROM fundit_contribution GROUP BY project_id) s ON p.id = s.pid ORDER BY COALESCE(total, 0) DESC";

  $result = \DBHandler::execute($statement, true);

  $projects = array();
  foreach ($result as $res) {
    $res['DEADLINE'] = \DateHelper\beautifyDateFromSql($res['DEADLINE']);
    $res['CREATED_DATE'] = \DateHelper\beautifyDateFromSql($res['CREATED_DATE']);
    $projects[] = new \Project($res['ID'], $res['OWNER'], $res['TITLE'], $res['DESCRIPTION'], $res['GOAL'], $res['DEADLINE'], $res['CATEGORY'], $res['CREATED_DATE']);
  }

  return $projects;
}

function getActiveUserProject() {
  $activeUser = \UserController\getSignedInUser();
  if (!isset($activeUser)) {
    return null;
  } else {
    return $activeUser->getProjectList();
  }
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
