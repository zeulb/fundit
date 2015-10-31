<?php

include_once __DIR__ . '/../db/DBHandler.php';

class Contribution {
  private $id;
  private $contributor;
  private $projectId;
  private $date;
  private $amount;

  private function save() {
    $statement = "UPDATE fundit_contribution SET contributor='{$this->contributor}', projectId={$this->projectId}, amount={$this->amount}";
    return DBHandler::execute($statement, false);
  }

  public function __construct($id, $contributor, $projectId, $date, $amount) {
    $this->id = $id;
    $this->contributor = $contributor;
    $this->projectId = $projectId;
    $this->date = $date;
    $this->amount = $amount;
  }

  public function getId() {
    return $this->id;
  }

  public function getContributor() {
    return $this->contributor;
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
