<?php 
namespace Controller;

/**
 * Base Controller
 */
class Base {

  protected function displayTemplate($templatePath, $data = [])
  {

    // create variable variables $$
    foreach ($data as $key => $value) {
      $$key = $value; 
    }

    include(BASE . '/view/' . $templatePath . '.php');
  }
}
