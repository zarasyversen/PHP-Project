<?php 
namespace Model;

/**
 * Base Model
 */
abstract class Base implements \JsonSerializable {

  /**
   * Base Model
   * Returns Array
   */
  public function jsonSerialize() {
    $result = [];
    foreach ($this->visible as $func => $key) {
      if (is_string($func)) {
        $result[$func] = call_user_func(array($this, $key));
      } else {
        $result[$key] = $this->{$key};
      }
    }

    return $result;
  }

}
