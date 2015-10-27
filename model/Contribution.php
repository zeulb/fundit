<?php
class Contribution {
  private $id;
  private $contributorId;
  private $projectId;
  private $date;
  private $amount;

  public function __construct($contributorId, $projectId, $amount) {
    $this->contributorId = $contributorId;
    $this->projectId = $projectId;
    $this->amount = $amount;
    // create on database, fill id
  }

  public function getId() {
    return $this->id;
  }

  public function getContributorId() {
    return $this->contributorId;
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
