<?php
namespace ProjectController {

include_once __DIR__ . '/../model/Project.php';

public static function createNewProject($ownerUsername, $title, $description, $goal, $deadline) {

  $statement = "INSERT INTO fundit_project (ownerUsername, title, description, goal, deadline) VALUES('{$this->ownerUsername}', '{$this->title}', '{$this->description}', '{$this->goal}', '{$this->deadline}')";
  $r = \DBHandler::execute($statement, false);
  if (!$r) {
    return null;
  } else {
    $statement = "SELECT fundit_project_seq.CURRVAL FROM dual";
    $result = \DBHandler::execute($statement, true)[0];
    $id = intval($result['CURRVAL']);

    return new \Project($id, $ownerUsername, $title, $description, $goal, $deadline);
  }
}

}

?>
