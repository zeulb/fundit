<?php

class Project {
  private $id;
  private $owner_id;
  private $title;
  private $description;
  private $goal;
  private $endTime;

  private function save() {
    // update to db
  }

  public static function createNewUser($owner_id, $title, $description, $goal, $endTime

  public function __constructor($id, $owner_id, $title, $description, $goal, $endTime) {
    $this->id = $id;
    $this->owner_id = $owner_id;
    $this->title = $title;
    $this->description = $description;
    $this->goal = $goal;
    $this->endTime = $endTime;
  }

  public function getId() {
    return $this->id;
  }

  public function getOwnerId() {
    return $this->owner_id;
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

  public function getEndTime() {
    return $this->endTime;
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

  public function setEndTime($endTime) {
    $this->endTime = $endTime;
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
