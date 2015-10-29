<?php
include_once '../../config.php';

class DBHandler {
  private $dbh;

  public function __construct() {
    global $config;
    $this->dbh = ocilogon($config['username'], $config['password'], " (DESCRIPTION =
      (ADDRESS_LIST =
        (ADDRESS = (PROTOCOL = TCP)(HOST = {$config['host']})(PORT = {$config['port']}))
      )
      (CONNECT_DATA =
        (SERVICE_NAME = {$config['service_name']})
      )
    )");
  }

  public function execute($query, $needResult) {
    $stid = oci_parse($dbh, $query);
    oci_execute($stid);
    if ($needResult) {
      $result = array();
      while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
        array_push($result, $row);
      }
      return $result;
    }
  }

}

?>
