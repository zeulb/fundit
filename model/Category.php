<?php

include_once __DIR__ . '/../helper/DateHelper.php';
include_once __DIR__ . '/../db/DBHandler.php';
include_once __DIR__ . '/Project.php';

class Category {
  private $category;

  public function __construct($category) {
    $this->category = $category;
  }

  public function getCategory() {
    return $this->category;
  }

}

?>
