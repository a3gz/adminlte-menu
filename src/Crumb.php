<?php
namespace A3gZ\AdminLteMenu;

class Crumb implements Interfaces\CrumbInterface
{
  protected $name;

  protected $url;

  public function __construct($name, $url = null) {
		if (!is_string($name)) {
      throw new \Exception('Invalid argument type; string expected ' . gettype($name) . ' given.');
		}
		if ( isset($url) && !is_string($url) ) {
      throw new \Exception('Invalid argument type; string expected ' . gettype($url) . ' given.');
		}

    $this->name = $name;
    $this->url = $url;
  }

  public function getName() {
    return $this->name;
  }

  public function getUrl() {
    return $this->url;
  }
} // interface

// EOF
