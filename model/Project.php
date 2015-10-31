<?php
include_once __DIR__ . '/../db/DBHandler.php';
include_once __DIR__ . '/Contribution.php';

class Project {
  private $id;
  private $owner;
  private $title;
  private $description;
  private $goal;
  private $deadline;

  private function save() {
    $statement = "UPDATE fundit_project SET owner='{$this->owner}', title='{$this->title}', description='{$this->description}', goal='{$this->goal}', deadline='{$this->deadline}' WHERE id='{$this->id}'";
    return DBHandler::execute($statement, false);
  }

  public function __construct($id, $owner, $title, $description, $goal, $deadline) {
    $this->id = $id;
    $this->owner = $owner;
    $this->title = $title;
    $this->description = $description;
    $this->goal = $goal;
    $this->deadline = $deadline;
  }

  public function getId() {
    return $this->id;
  }

  public function getOwner() {
    return $this->owner;
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
      $result[] = new Contribution($res['ID'], $res['CONTRIBUTOR'], $res['PROJECTID'], $res['DATE'], $res['AMOUNT']);
    }

    return $result;
  }

  public function getContributorCount() {
    $statement = "SELECT COUNT(DISTINCT CONTRIBUTOR) FROM fundit_contribution WHERE project_id = {$this->id}";

    $result = DBHandler::execute($statement, true);

    $contributorCount = $result[0]['COUNT(DISTINCTCONTRIBUTOR)'];
    return $contributorCount;
  }

  public function getTotalContribution() {
    $statement = "SELECT SUM(AMOUNT) FROM fundit_contribution WHERE project_id = {$this->id}";

    $result = DBHandler::execute($statement, true);

    $totalContribution = $result[0]['SUM(AMOUNT)'];
    return $totalContribution;
  }

}

?>
