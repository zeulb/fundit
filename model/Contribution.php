<?php

include_once __DIR__ . '/../db/DBHandler.php';
include_once __DIR__ . '/../helper/DateHelper.php';

class Contribution {
  private $id;
  private $contributor;
  private $projectId;
  private $timestamp;
  private $amount;
  private $message;

  private function save() {
    $this->timestamp = \DateHelper\convertToSqlFormatFromString($this->timestamp);
    $statement = "UPDATE fundit_contribution SET contributor='{$this->contributor}', project_id={$this->projectId}, amount={$this->amount}, timestamp='{$this->timestamp}', message='{$this->message}' WHERE id={$this->id}";
    $this->timestamp = \DateHelper\beautifyDateFromSql($this->timestamp);
    return DBHandler::execute($statement, false);
  }

  public function __construct($id, $contributor, $projectId, $timestamp, $amount, $message) {
    $this->id = $id;
    $this->contributor = $contributor;
    $this->projectId = $projectId;
    $this->timestamp = $timestamp;
    $this->amount = $amount;
    $this->message = $message;
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
    return $this->timestamp;
  }

  public function getAmount() {
    return $this->amount;
  }

  public function getComment() {
    return $this->message;
  }

  public function setContributor($contributor) {
    $this->contributor = $contributor;
    return $this->save();
  }

  public function setProjectId($projectId) {
    $this->projectId = intval($projectId);
    return $this->save();
  }

  public function setTimestamp($timestamp) {
    $this->timestamp = $timestamp;
    return $this->save();
  }

  public function setAmount($amount) {
    $this->amount = $amount;
    return $this->save();
  }

  public function setComment($message) {
    $this->message = $message;
    return $this->save();
  }

}
?>
