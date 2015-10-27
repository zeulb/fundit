<?php
class Contribution {
  private $contributionId;
  private $contributorId;
  private $projectId;
  private $date;
  private $amount;

  public function __construct($contributorId, $projectId, $amount) {
    $this->contributionId = $contributorId;
    $this->projectId = $projectId;
    $this->amount = $amount;
  }

  public function getContributionId() {
    return $this->contributionId;
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
