<?php
include_once __DIR__ . '/../config.php';

class DBHandler {
  public $dbh;

  public function __construct() {
    global $config;
    putenv("ORACLE_HOME={$config['ORACLE_HOME']}");
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

  public function close() {
    oci_close($this->dbh);
  }

  public static function execute($query, $needResult) {
    $instance = new DBHandler();
    $stid = oci_parse($instance->dbh, $query);
    $r;
    try {
      $r = oci_execute($stid);
    } catch (Exception $e) {
      //do nothing
    }
    if ($needResult) {
      if (!$r) {
        $instance->close();
        unset($instance);
        return null;
      } else {
        $result = array();
        while (($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) != false) {
          $result[] = $row;
        }
        $instance->close();
        unset($instance);
        return $result;
      }
    } else {
      $instance->close();
      unset($instance);
      return $r;
    }
  }

}

?>
