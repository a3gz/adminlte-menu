<?php
namespace A3gZ\AdminLteMenu\Interfaces;

interface MenuItemInterface
{
  const DEFAULT_PRIORITY = 50;


  /**
   * @param A3gZ\AdminLteMenu\Interfaces\MenuItemInterface $item
   * @param int $priority Item priority within it's own branch
   * @param A3gZ\AdminLteMenu\Interfaces\RendererInterface $renderer The specialized renderer. If not given, default is used.
   *
   * @return A3gZ\AdminLteMenu\Interfaces\MenuItemInterface $this
   */
  public function add(MenuItemInterface $item, $priority = self::DEFAULT_PRIORITY);

  /**
   * Returns the defined expression pattern to determine if the item is active.
   *
   * @return string or false
   */
  public function getActivePattern();

  /**
   * Returns the items below a given partial tree root.
   *
   * @return A3gZ\AdminLteMenu\Interfaces\MenuItemInterface[] A list of zero or more items.
   */
  public function getChildren();

  /**
   * @return string HTML code to draw a relevant icon.
   */
  public function getIcon();

  /**
   * @return string The item identification string.
   */
  public function getId();

  /**
   * @return string URL to the associated page
   */
  public function getUrl();

  /**
   * @return bool True if the item has children.
   */
  public function hasChildren();

  /**
   * @return bool Wheter the queried item is active or not.
   */
  public function isActive();

  /**
   * Each item is responsible for rendering itself via it's renderer.
   *
   * @return string HTML code for the rendered partial tree.
   */
  public function toHtml();
} // interface

// EOF
