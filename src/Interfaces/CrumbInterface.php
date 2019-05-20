<?php
namespace A3gZ\AdminLteMenu\Interfaces;

interface CrumbInterface
{
  /**
   * Returns the crumb's label.
   *
   * @return string
   */
  public function getName();

  /**
   * Returns the crumbs URL.
   *
   * @return string
   */
  public function getUrl();
} // interface

// EOF
