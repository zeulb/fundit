<?php
include_once __DIR__ . '/../config.php';

class DBHandler {
  private $dbh;

  public function __construct() {
    global $config;
    putenv('ORACLE_HOME=instantclient,/usr/local/bin');
    $this->dbh = ocilogon($config['username'], $config['password'], " (DESCRIPTION =
      (ADDRESS_LIST =
        (ADDRESS = (PROTOCOL = TCP)(HOST = " . $config['host'] . ")(PORT = " . $config['port'] . "))
      )
      (CONNECT_DATA =
        (SERVICE_NAME = " . $config['service_name'] . ")
      )
    )");
    if (!$this->dbh) {
      echo "ERROR <br />";
      $e = oci_error();
      echo $e['message'];
    }
  }

  public function execute($query, $needResult) {
    $stid = oci_parse($this->dbh, $query);
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
