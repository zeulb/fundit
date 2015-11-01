<?php
include_once __DIR__ . '/Contribution.php';
include_once __DIR__ . '/../db/DBHandler.php';
include_once __DIR__ . '/../helper/DateHelper.php';
include_once __DIR__ . '/Project.php';

date_default_timezone_set("Asia/Singapore");

class User {
  private $username;
  private $name;
  private $roles;
  private $email;
  private $password;

  private function save() {
    $statement = "UPDATE fundit_user SET name='{$this->name}', roles='{$this->roles}', email='{$this->email}', password='{$this->password}' WHERE username='{$this->username}'";
    return DBHandler::execute($statement, false);
  }

  private function fetchContribution() {
    $statement = "SELECT * FROM fundit_contribution WHERE contributor = '{$this->username}'";
    $result = DBHandler::execute($statement, true);
    return $result;
  }

  public function __construct($username, $name, $roles, $email, $password) {
    $this->username = $username;
    $this->name = $name;
    $this->roles = $roles;
    $this->email = $email;
    $this->password = $password;
  }

  public function getUsername() {
    return $this->username;
  }

  public function getName() {
    return $this->name;
  }

  public function setName($name) {
    $this->name = $name;
    return $this->save();
  }

  public function getRoles() {
    return $this->roles;
  }

  public function setRoles($roles) {
    $this->roles = $roles;
    return $this->save();
  }

  public function getEmail() {
    return $this->email;
  }

  public function setEmail($email) {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) === true) {
      return null;
      $oldEmail = $this->email;
      $this->email = $email;
      $success = $this->save();
      if (!$success) {
        $this->email = $oldEmail;
        return null;
      } else {
        return true;
      }
    } else {
      return null;
    }
  }

  //$password -> password in plaintext
  public function setPassword($password) {
    $this->password = md5($password);
    return $this->save();
  }

  public function getTotalContribution() {
    $statement = "SELECT SUM(AMOUNT) FROM fundit_contribution WHERE contributor = '{$this->username}'";

    $result = DBHandler::execute($statement, true);

    if (isset($result[0]['SUM(AMOUNT)'])) {
      return $result[0]['SUM(AMOUNT)'];
    } else {
      return 0.0;
    }
  }

  public function getContributionList() {
    $statement = "SELECT * FROM fundit_contribution WHERE contributor = '{$this->username}' ORDER BY timestamp DESC";

    $result = DBHandler::execute($statement, true);

    $contributions = array();
    foreach ($result as $res) {
      $res['TIMESTAMP'] = \DateHelper\beautifyDateFromSql($res['TIMESTAMP']);
      $contributions[] = new Contribution($res['ID'], $res['CONTRIBUTOR'], $res['PROJECT_ID'], $res['TIMESTAMP'], $res['AMOUNT'], $res['COMMENT']);
    }

    return $contributions;
  }

  //$user -> user object
  public function canModifyUser($user) {
    return $this->roles == 'admin' || $this->username == $user->getUsername();
  }

  //$project -> project object
  public function canModifyProject($project) {
    return $this->roles == 'admin' || $this->username == $project->getOwner();
  }

  //$contribution -> contribution object
  public function canModifyContribution($contribution) {
    return $this->roles == 'admin';
  }

  //$guess -> guess in plaintext
  public function verifyPassword($guess) {
    $guess = md5($guess);
    return $this->password == $guess;
  }

  public function getProjectList() {
    $statement = "SELECT * FROM fundit_project WHERE owner = '{$this->username}'";

    $result = DBHandler::execute($statement, true);

    $projectList = array();
    foreach ($result as $res) {
      $res['DEADLINE'] = \DateHelper\beautifyDateFromSql($res['DEADLINE']);
      $res['CREATED_DATE'] = \DateHelper\beautifyDateFromSql($res['CREATED_DATE']);
      $projectList[] = new Project($res['ID'], $res['OWNER'], $res['TITLE'], $res['DESCRIPTION'], $res['GOAL'], $res['DEADLINE'], $res['CATEGORY'], $res['CREATED_DATE']);
    }

    return $projectList;
  }
}
?>
