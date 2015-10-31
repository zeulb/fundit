<?php

namespace DateHelper {

include_once __DIR__ . '/../db/DBHelper.php';

date_default_timezone_set("Asia/Singapore");

function beautifyDateFromSql($dateFromSql) {
  $result = date_create_from_format('j-M-y h.i.s.u A', $dateFromSql);
  $result = $result->format('d M Y h:m A');
  return $result;
}

function convertToSqlFormatFromString($beautifulDate) {
  $unixTime = strtotime($beautifulDate);
  return convertToSqlFormatFromUnixTime($unixTime);
}

function convertToSqlFormatFromUnixTime($unixTime) {
  $deadline = date("d-M-yh:i:s.u", $unixTime);
  $inner = "TO_TIMESTAMP('{$deadline}','DD-MON-RRHH24:MI:SS.FF')";
  $statement = "SELECT {$inner} FROM dual";
  $deadline = \DBHandler::execute($statement, true)[0][strtoupper($inner)];
  return $deadline;
}

}

?>
