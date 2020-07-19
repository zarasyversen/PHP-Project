<?php 
namespace Controller;

/**
 * Base Controller
 */
abstract class Base {

  private $template;
  private $data = [];
  private $redirectTo;

  public function setData($data, $value = '') {

    // if data is an array, merge in to existing array
    if (is_array($data)) {
      $this->data = array_merge($this->data, $data);
    } else {
      // set single key and value in the array
      $this->data[$data] = $value;
    }
  }

  public function getData() {
    return $this->data;
  }

  public function setTemplate($template)  {
    $this->template = $template;
  }

  protected function displayTemplate($templatePath, $data = [])
  {

    // create variable variables $$
    foreach ($data as $key => $value) {
      $$key = $value; 
    }

    include(BASE . '/view/' . $templatePath . '.php');
  }

  public function renderHtml() {
    if ($this->redirectTo) {
      header("Location:" . $this->redirectTo);
      return;
    }

    return $this->displayTemplate($this->template, $this->data);
  }

  public function redirect($url) {
    $this->redirectTo = $url;
  }

  
}
