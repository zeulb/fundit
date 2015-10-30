<?php
include_once __DIR__ . '/../db/DBHandler.php';
include_once __DIR__ . '/Contribution.php';

class Project {
  private $id;
  private $ownerUsername;
  private $title;
  private $description;
  private $goal;
  private $deadline;

  private function save() {
    $statement = "UPDATE fundit_project SET ownerUsername={$this->ownerUsername}, title={$this->title}, description={$this->description}, goal={$this->goal}, deadline={$this->deadline} WHERE id={$this->id}";
    return DBHandler::execute($statement, false);
  }

  public function __constructor($id, $ownerUsername, $title, $description, $goal, $deadline) {
    $this->id = $id;
    $this->ownerUsername = $ownerUsername;
    $this->title = $title;
    $this->description = $description;
    $this->goal = $goal;
    $this->deadline = $deadline;
  }

  public function getId() {
    return $this->id;
  }

  public function getOwnerId() {
    return $this->ownerUsername;
  }

  public function getTitle() {
    return $this->title;
  }

  public function getDescription() {
    return $this->description;
  }

  public function getGoal() {
    return $this->goal;
  }

  public function getDeadline() {
    return $this->deadline;
  }

  public function setTitle($title) {
    $this->title = $title;
    return $this->save();
  }

  public function setDescription($description) {
    $this->description = $description;
    return $this->save();
  }

  public function setGoal($goal) {
    $this->goal = $goal;
    return $this->save();
  }

  public function setDeadline($deadline) {
    $this->deadline = $deadline;
    return $this->save();
  }

  public function getContributionList() {
    $statement = "SELECT * FROM fundit_contribution WHERE project_id = {$this->id}";

    $result = DBHandler::execute($statement, true);

    $result = array();
    foreach ($result as $res) {
      $result[] = new Contribution($res['ID'], $res['CONTRIBUTORUSERNAME'], $res['PROJECTID'], $res['DATE'], $res['AMOUNT']);
    }

    return $result;
  }

  public function getTotalContribution() {
    $statement = "SELECT * FROM fundit_contribution WHERE project_id = {$this->id}";

    $result = DBHandler::execute($statement, true);

    $totalContribution = 0.0;
    foreach ($result as $res) {
      $totalContribution += floatval($res['AMOUNT']);
    }

    return $totalContribution;
  }

}

?>
