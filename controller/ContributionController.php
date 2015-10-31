<?php
namespace ContributionController {

include_once __DIR__ . '/../model/Contribution.php';
include_once __DIR__ . '/../db/DBHandler.php';
include_once __DIR__ . '/../helper/DateHelper.php';
include_once __DIR__ . '/UserController.php';

function createNewContribution($projectId, $amount) {
  date_default_timezone_set("Asia/Singapore");

  $contributor = $_SESSION['username'];
  $contributionDate = \DateHelper\convertToSqlFormatFromUnixTime(time());
  $amount = floatval($amount);
  $projectId = intval($projectId);

  $statement = "SELECT fundit_contribution_seq.NEXTVAL FROM dual";
  $result = \DBHandler::execute($statement, true);
  $id = $result[0]['NEXTVAL'];

  $statement = "INSERT INTO fundit_contribution (id, contributor, project_id, timestamp, amount) VALUES ({$id}, '{$contributor}', {$projectId}, '{$contributionDate}', {$amount})";
  $result = \DBHandler::execute($statement, false);

  if (!$result) {
    return null;
  } else {
    return new \Contribution($id, $contributor, $projectId, $contributionDate, $amount);
  }
}

function getAllContribution() {
  $executingUser = isset($_SESSION['username']) ? \UserController\getUser($_SESSION['username']) : null;
  if ($executingUser == null || $executingUser->getRoles() != 'admin') {
    return null;
  }

  $statement = "SELECT * FROM fundit_contribution";
  $result = DBHandler::execute($statement, true);

  $contributionList = array();
  foreach ($result as $res) {
    $res['DATE'] = \DateHelper\beautifyDateFromSql($res['DATE']);
    $contributionList[] = new \Contribution($res['ID'], $res['CONTRIBUTOR'], $res['PROJECT_ID'], $res['DATE'], $res['AMOUNT']);
  }

  return $contributionList;
}

}
?>
