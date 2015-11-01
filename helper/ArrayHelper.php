<?php

namespace ArrayHelper {

function is_assoc($var) {
  return is_array($var) && array_diff_key($var, array_keys(array_keys($var)));
}

}

?>
