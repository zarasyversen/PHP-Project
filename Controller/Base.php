<?php 
namespace Controller;

/**
 * Base Controller
 */
class Base {

  protected function displayTemplate($templatePath, $data) {

    foreach ($data as $key => $value) {
      //variable variables
      $$key = $value; 
    }

    include(BASE . $templatePath .'.php');
  }

}
