<?php
namespace ContributionController {

include_once __DIR__ . '/../model/Contribution.php';
include_once __DIR__ . '/../db/DBHandler.php';

function createNewContribution($projectId, $amount) {
  date_default_timezone_set("Asia/Singapore");

  $contributor = $_SESSION['username'];
  $contributionDate = date("d-M-yh:i:s.u", time());
  $inner = "TO_TIMESTAMP('{$contributionDate}','DD-MON-RRHH24:MI:SS.FF')";
  $statement = "SELECT {$inner} FROM dual";
  $contributionDate = \DBHandler::execute($statement, true)[0][strtoupper($inner)];
  $amount = floatval($amount);
  $projectId = intval($projectId);

  $statement = "INSERT INTO fundit_contribution (contributor, projectId, data, amount) VALUES ('{$contributor}', '{$projectId}', '{$projectId}', '{$contributionDate}', '{$amount}')";
  $result = \DBHandler::execute($statement, false);

  if (!$result) {
    return null;
  } else {
    $statement = "SELECT fundit_contribution_seq.CURRVAL FROM dual";
    $result = \DBHandler::execute($statement, true);
    assert(isset($result) && count($result) == 1);

    $id = intval($result[0]);
    return new \Contribution($id, $contributor, $projectId, $contributionDate, $amount);
  }
}

}
?>
