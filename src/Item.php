<?php
namespace A3gZ\AdminLteMenu;

use A3gZ\AdminLteMenu\Interfaces\MenuItemInterface;
use A3gZ\AdminLteMenu\Interfaces\RendererInterface;

class Item implements MenuItemInterface
{
  protected $children;

  public $level = 0;

  public $owner = null;

  protected $renderer;

  protected $settings;

  public function __construct($params, RendererInterface $renderer = null) {
    $params['crumb'] = function($id, $url) {
      return new Crumb($id, $url);
    };
    if (!isset($renderer)) {
      $renderer = $this->getRenderer();
    }

    $defaults = [
      'label' => null,
      'meta' => null,
      'path' => null,
      'icon' => null,
    ];
    $settings = array_merge($defaults, $params);

    if (!isset($settings['id'])) {
      throw new \Exception('Menu ID is missing.');
    }

    if (!isset($settings['label'])) {
      $settings['label'] = $settings['id'];
    }

    if (!isset($settings['crumb'])) {
      $settings['crumb'] = function($id, $url) {
        return new Crumb($id, $url);
      };
    }

    $this->renderer = $renderer;
    $this->children = [];
    $this->settings = $settings;
  }

  public function add(
    MenuItemInterface $item,
    $priority = self::DEFAULT_PRIORITY,
    RendererInterface $renderer = null
  ) {
    if (!isset($renderer)) {
      $renderer = $this->getRenderer();
    }

    $item->renderer = $renderer;
    $item->owner = $this;
    $item->level = $this->getLevel();

    $this->children[$priority][] = $item;

    return $this;
  }

  public function asCrumb() {
    $url = null;
    if (isset($this->settings['path'])) {
      $url = $this->getUrl();
    }

    $crumb = $this->settings['crumb']($this->settings['id'], $url);
    return $crumb;
  }

  public function find($id) {
    if ($id == $this->getId()) {
      return $this;
    }

    foreach ($this->children as $pr1 => $childrenItems) {
      foreach ($childrenItems as $pr2 => $childrenItem) {
        if ($found = $childrenItem->find($id)) {
          return $found;
        }
      }
    }

    return null;
  }

  public function getActivePattern() {
    return (isset($this->settings['pattern']) ? $this->settings['pattern'] : false);
  }

  public function getChildren() {
    return $this->children;
  }

  public function getIcon() {
    if (isset($this->settings['icon'])) {
      $iconClass = "fa fa-fw {$this->settings['icon']} ";
      if ($this->isRoot()) {
        $iconClass .= "fa-lg ";
      }
      $icon = "<i class=\"{$iconClass}\"></i>";
    } else {
      $icon = '<i class="fa fa-fw fa-link"></i>';

      if (isset($this->settings['icon'])) {
        $icon = $this->settings['icon'];
      }
    }
    return $icon;
  }

  public function getId() {
    return $this->settings['id'];
  }

  public function getLabel() {
    return $this->settings['label'];
  }

  protected function getRenderer() {
    return new ItemRenderer();
  }

  public function getUrl() {
    $root = $this->getUrlRoot();
    $path = $this->settings['path'];
    if (substr($path, 0, 1) != '/') {
      $path = "/{$path}";
    }

    return $root . $path;
  }

  protected function getLevel() {
    if ($this->owner == null) {
      return 0;
    }

    return $this->owner->level + 1;
  }

  public function getUrlRoot() {
    if (isset($this->settings['urlRoot'])) {
      $urlRoot = $this->settings['urlRoot'];
      if (substr($urlRoot, -1) == '/') {
        $urlRoot = substr($urlRoot, 0, -1);
      }
      return $urlRoot; 
    } elseif ($this->owner == null) {
      return '';
    }
    return $this->owner->getUrlRoot();
  }

  public function hasActiveChild() {
    if (!$this->hasChildren()) return false;

    foreach($this->children as $pr1 => $children) {
      foreach($children as $pr2 => $child) {
        if ($child->isActive()) {
          return true;
        }
      }
    }

    return false;
  }

  public function hasChildren() {
    if (count($this->children) < 1) {
      return false;
    }

    return true;
  }

  public function isActive() {
    $currentPath = "{$_SERVER['REQUEST_URI']}";
    if (substr($currentPath, -1) !== '/') {
      $currentPath .= '/';
    }
    $parts = parse_url($this->getUrl());
    $path = $parts['path'];
    if (substr($path, -1) !== '/') {
      $path .= '/';
    }
    $isActive = ($path === $currentPath);
    if ($pattern = $this->getActivePattern()) {
      $isActive = $isActive || (preg_match($pattern, $currentPath));
    }
    return ($isActive || $this->hasActiveChild());
  }

  /**
   * Declares whether the object is the root of a sub-tree.
   * The menu tree is organized like this:
   *  TheRoot ->
   *    menu-01 -> THIS IS CONSIDERED A ROOT
   *      option-11
   *      option-12...
   *    option-02 (this doesn't have a menu)
   *    menu-02 -> THIS IS ROOT
   *      menu-021 -> THIS IS NOT ROOT
   *        option-0211
   *        option-0212
   * Only ONE node should return true and that would be non-renderable.
   *
   * So, given that all menus are trees below "TheRoot", an item would be considered a
   * root in this context if the owner's owner is NULL, that is: the owner is "TheRoot"
   *
   * @return bool TRUE if the node is the root.
   */
  public function isRoot() {
    return ($this->owner->owner == null);
  }

  protected function sortTree(array &$branch) {
    uksort($branch, function($a, $b) {
      if ($a == $b) {
        return 0;
      }

      return (($a < $b) ? -1 : 1);
    });

    return $this;
  }

  public function toHtml() {
    $this->sortTree($this->children);

    return $this->renderer->toHtml($this);
  }
} // class

// EOF
