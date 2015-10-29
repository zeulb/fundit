<?php

include_once __DIR__ . '/../db/DBHandler.php';

class Contribution {
  private $id;
  private $contributorUsername;
  private $projectId;
  private $date;
  private $amount;

  public function __construct($contributorUsername, $projectId, $amount) {
    $this->contributorUsername = $contributorUsername;
    $this->projectId = $projectId;
    $this->amount = $amount;
    // create on database, fill id
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
