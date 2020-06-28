<?php 
namespace Controller;

/**
 * Base Controller
 */
abstract class Base {

  private $template;
  private $data;
  private $redirectTo;

  public function setTemplate($template)  {
    $this->template = $template;
  }

  public function setData($data) {
    $this->data = $data;
  }

  protected function displayTemplate($templatePath, $data = [])
  {
    // create variable variables $$
    foreach ($data as $key => $value) {
      $$key = $value; 
    }

    include(BASE . '/view/' . $templatePath . '.php');
  }

  public function redirect($url) {
    $this->redirectTo = $url;
  }

  public function renderHtml() {
    if ($this->redirectTo) {
      header("Location:" . $this->redirectTo);
      return;
    }

    return $this->displayTemplate($this->template, $this->data);
  }

  public function getData() {

    // var_dump($this->data);


    if ($this->redirectTo) {
      return;
    }

    return $this->data;
  }
}
