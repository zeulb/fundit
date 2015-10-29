<?php
include "../db/DBHandler.php";

class Project {
  private $id;
  private $ownerUsername;
  private $title;
  private $description;
  private $goal;
  private $deadline;

  private function save() {
    $dbHandler = DBHandler::getInstance();

    $statement = "UPDATE fundit_project SET ownerUsername={$ownerUsername}, title={$title}, description={$description}, goal={$goal}, deadline={$deadline} WHERE id={$id}";
    $dbHandler->execute($statement, false);
  }

  public static function createNewProject($ownerUsername, $title, $description, $goal, $deadline) {
    $dbHandler = DBHandler::getInstance();

    $statement = "INSERT INTO fundit_project (ownerUsername, title, description, goal, deadline) VALUES({$ownerUsername}, {$title}, {$description}, {$goal}, {$deadline})";
    $dbHandler->execute($statement, false);

    $statement = "SELECT fundit_project_seq.CURRVAL FROM dual";
    $result = $dbHandler->execute($statement, true);
    $id = $result['CURRVAL'];

    return new Project($id, $ownerUsername, $title, $description, $goal, $deadline);
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
    // return list of contribution object
  }

  public function getTotalContribution() {
    
  }

  public static function getProject($id) {
    // select this project, return project object
  }

}

?>
