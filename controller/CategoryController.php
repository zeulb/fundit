<?php

namespace CategoryController {

include_once __DIR__ . '../db/DBHandler.php';

function getProjectWithCategory($category) {
  $statement = "SELECT * FROM fundit_project WHERE category='{$category}'";
  $result = DBHandler::execute($statement, true);

  $projects = array();
  foreach ($result as $res) {
    $res['DEADLINE'] = DateHelper\beautifyDateFromSql($res['DEADLINE']);
    $projects[] = new Project($res['ID'], $res['OWNER'], $res['TITLE'], $res['DESCRIPTION'], $res['GOAL'], $res['DEADLINE'], $res['CATEGORY']);
  }

  return $projects;
}

function getAllCategories() {
  $statement = "SELECT * FROM fundit_category";
  $result = DBHandler::execute($statement, true);

  $categories = array();
  foreach ($result as $res) {
    $categories[] = new Category($res['CATEGORY']);
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
