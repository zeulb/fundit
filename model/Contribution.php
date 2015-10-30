<?php

include_once __DIR__ . '/../db/DBHandler.php';

class Contribution {
  private $id;
  private $contributorUsername;
  private $projectId;
  private $date;
  private $amount;

  private function save() {
    $statement = "UPDATE fundit_contribution SET contributorUsername='{$contributorUsername}', projectId={$projectId}, date='{$date}', amount={$amount}";

    return DBHandler::execute($statement, false);
  }

  public function __construct($id, $contributorUsername, $projectId, $date, $amount) {
    $this->id = $id;
    $this->contributorUsername = $contributorUsername;
    $this->projectId = $projectId;
    $this->date = $date;
    $this->amount = $amount;
  }

  public function getId() {
    return $this->id;
  }

  public function getContributorId() {
    return $this->contributorUsername;
  }

  public function getProjectId() {
    return $this->projectId;
  }

  public function getDate() {
    return $this->date;
  }

  public function getAmount() {
    return $this->amount;
  }

}
?>
