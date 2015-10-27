<?php
class User {
  private $id;
  private $name;
  private $roles;
  private $email;
  private $password;

  public function __construct($name, $roles, $email, $password) {
    $this->name = $name;
    $this->roles = $roles;
    $this->email = $email;
    $this->password = $password;
    // create on database, fill id
  }

  public function getName($name) {
    return $this->name;
  }

  public function setName($name) {
    $this->name = $name;
    return $this->save();
  }

  public function getRoles($roles) {
    return $this->roles;
  }

  public function setRoles($roles) {
    $this->roles = $roles;
    return $this->save();
  }

  public function getEmail($email) {
    return $this->email;
  }

  public function setEmail($email) {
    $this->email = $email;
    return $this->save();
  }

  public function setPassword($password) {
    $this->password = $password;
    return $this->save();
  }

  public function getContribution() {
    // get contribution
  }

  private function save() {
    // update
  }

  private static function getUser($id) {
    // select this user, return user object
  }

}
?>