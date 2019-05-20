<?php
namespace A3gZ\AdminLteMenu;

use A3gZ\AdminLteMenu\Interfaces\BreadCrumbsInterface;
use A3gZ\AdminLteMenu\Interfaces\RendererInterface;
use A3gZ\AdminLteMenu\Interfaces\CrumbInterface;

class BreadCrumbs implements BreadCrumbsInterface
{
	protected $crumbs;

  protected $renderer;

	protected $menu;

	public function __construct(Item $menu, RendererInterface $renderer = null) {
    if (!isset($renderer)) {
      $renderer = new \AdminLteMenu\BreadCrumbsRenderer();
    }
    $this->renderer = $renderer;
    $this->menu = $menu;
		$this->crumbs = [];
    $this->fromMenu($menu);
	}

	public function add(CrumbInterface $crumb) {
		$this->crumbs[] = $crumb;
		return $this;
	}

  private function fromMenu($branch) {
    foreach ($branch->getChildren() as $priority => $children) {
      foreach ($children as $pr2 => $child) {
        if ($child->isActive()) {
          $this->add($child->asCrumb());
          if ($child->hasChildren()) {
            $this->fromMenu($child);
          }
        }
      }
    }
  }

  public function getCrumbs() {
    return $this->crumbs;
  }

  public function getUrlRoot() {
    return $this->menu->getUrlRoot();
  }

  public function toHtml() {
    return $this->renderer->toHtml($this);
  }
} // class

// EOF
