<?php
namespace A3gZ\AdminLteMenu\Interfaces;

interface BreadCrumbsInterface
{
  /**
   * Returns the crumbs list
   *
   * @return string[]
   */
  public function getCrumbs();

  /**
   * Returns the application's URL root.
   *
   * @return string
   */
  public function getUrlRoot();

  /**
   * Each item is responsible for rendering itself via it's renderer.
   *
   * @return string HTML code for the rendered partial tree.
   */
  public function toHtml();
} // interface

// EOF
