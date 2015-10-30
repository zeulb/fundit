<?php

include_once __DIR__ . '/../db/DBHandler.php';

class Contribution {
  private $id;
  private $contributorUsername;
  private $projectId;
  private $date;
  private $amount;

  private function addToDatabase() {
    $statement = "INSERT INTO fundit_contribution (contributorUsername, projectId, data, amount) VALUES ('{$contributorUsername}', '{$projectId}', '{$projectId}', '{$date}', '{$amount}')";

    return DBHandler::execute($statement, false);
  }

  public function __construct($contributorUsername, $projectId, $amount) {
    $this->contributorUsername = $contributorUsername;
    $this->projectId = $projectId;
    $this->amount = $amount;
    $this->addToDatabase();
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
