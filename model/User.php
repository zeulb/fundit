<?php
include_once __DIR__ . '/Contribution.php';
include_once __DIR__ . '/../db/DBHandler.php';

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

    $statement = "SELECT * FROM fundit_contribution WHERE contributor_username = '{$username}'";
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
    $oldEmail = $this->email;
    $this->email = $email;
    $success = $this->save();
    if (!$success) {
      $this->email = $oldEmail;
    }
  }

  public function setPassword($password) {
    $this->password = md5($password);
    return $this->save();
  }

  public function getContribution() {
    $contributions = fetchConstribution();
    $totalContribution = 0;
    foreach ($contributions as $contribution) {
      $totalContributions += $contribution['AMOUNT'];
    }
    return $totalContributions;
  }

  public function verifyPassword($guess) {
    $guess = md5($guess);
    return $this->password == $guess;
  }
}
?>
