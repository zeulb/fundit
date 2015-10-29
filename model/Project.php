<?php
include __DIR__ . '/../db/DBHandler.php';

class Project {
  private $id;
  private $ownerUsername;
  private $title;
  private $description;
  private $goal;
  private $deadline;

  private function save() {

    $statement = "UPDATE fundit_project SET ownerUsername={$this->ownerUsername}, title={$this->title}, description={$this->description}, goal={$this->goal}, deadline={$this->deadline} WHERE id={$this->id}";
    DBHandler::execute($statement, false);
  }

  public static function createNewProject($ownerUsername, $title, $description, $goal, $deadline) {

    $statement = "INSERT INTO fundit_project (ownerUsername, title, description, goal, deadline) VALUES('{$this->ownerUsername}', '{$this->title}', '{$this->description}', '{$this->goal}', '{$this->deadline}')";
    DBHandler::execute($statement, false);

    $statement = "SELECT fundit_project_seq.CURRVAL FROM dual";
    $result = DBHandler::execute($statement, true);
    $id = intval($result['CURRVAL']);

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

    $statement = "SELECT * FROM fundit_contribution WHERE project_id = {$this->id}";
  }

  public function getTotalContribution() {
    
  }

  public static function getProject($id) {
    // select this project, return project object
  }

}

?>
