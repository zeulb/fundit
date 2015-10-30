<?php
namespace ContributionController {

include_once __DIR__ . '../model/Contribution.php';
include_once __DIR__ . '../db/DBHandler.php';

function createNewContribution($projectId, $amount) {
  date_default_timezone_set("Asia/Singapore");

  $contributorUsername = $_SESSION['username'];
  $contributionDate = date("Y-m-d H:i:s");
  $amount = floatval($amount);
  $projectId = intval($projectId);

  $statement = "INSERT INTO fundit_contribution (contributorUsername, projectId, data, amount) VALUES ('{$contributorUsername}', '{$projectId}', '{$projectId}', '{$contributionDate}', '{$amount}')";
  $result = \DBHandler::execute($statement, false);

  if (!$result) {
    return null;
  } else {
    $statement = "SELECT fundit_contribution_seq.CURRVAL FROM dual";
    $result = \DBHandler::execute($statement, true);
    assert(isset($result) && count($result) == 1);

    $id = intval($result[0]);
    return new \Contribution($id, $contributorUsername, $projectId, $contributionDate, $amount);
  }
}

}
?>
