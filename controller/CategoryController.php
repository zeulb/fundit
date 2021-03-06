<?php

namespace CategoryController {

include_once __DIR__ . '/../db/DBHandler.php';
include_once __DIR__ . '/../model/Category.php';
include_once __DIR__ . '/../model/Project.php';

function getProjectWithCategory($category) {
  $statement = "SELECT * FROM fundit_project WHERE category='{$category}'";
  $result = \DBHandler::execute($statement, true);

  $projects = array();
  foreach ($result as $res) {
    $res['DEADLINE'] = \DateHelper\beautifyDateFromSql($res['DEADLINE']);
    $res['CREATED_DATE'] = \DateHelper\beautifyDateFromSql($res['CREATED_DATE']);
    $projects[] = new \Project($res['ID'], $res['OWNER'], $res['TITLE'], $res['DESCRIPTION'], $res['GOAL'], $res['DEADLINE'], $res['CATEGORY'], $res['CREATED_DATE']);
  }

  return $projects;
}

function getAllCategories() {
  $statement = "SELECT * FROM fundit_category";
  $result = \DBHandler::execute($statement, true);

  $categories = array();
  foreach ($result as $res) {
    $categories[] = new \Category($res['CATEGORY']);
  }

  return $categories;
}

function addCategory($category) {
  $statement = "INSERT INTO fundit_category (category) VALUES ('{$category}')";
  $result = \DBHandler::execute($statement, false);

  return $result;
}

}

?>
