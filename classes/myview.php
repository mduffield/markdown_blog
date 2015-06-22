<?php
class MyView {
  protected $template_dir = 'templates/';
  protected $vars = array();
  public function __construct($template_dir = null) {
    if ($template_dir !== null) {
        // Check here whether this directory really exists
        $this->template_dir = $template_dir;
    }
  }
  public function render($template_file, $render_to_var=FALSE) {
    if (file_exists($this->template_dir.$template_file)) {
      if($render_to_var)
      {
        ob_start();
      }
      include $this->template_dir.$template_file;
      if($render_to_var)
      {
        return ob_get_clean();
      }
      
    } else {
        throw new Exception('no template file ' . $template_file . ' present in directory ' . $this->template_dir);
    }
  }
  public function __set($name, $value) {
    $this->vars[$name] = $value;
  }
  public function __get($name) {
    return $this->vars[$name];
  }
}

