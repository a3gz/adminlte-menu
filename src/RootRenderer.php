<?php
namespace A3gZ\AdminLteMenu;

class RootRenderer implements Interfaces\RendererInterface
{
  public function toHtml(\AdminLteMenu\Interfaces\MenuItemInterface $root) {
    ob_start();
      foreach ($root->getChildren() as $priority => $children) {
        foreach ($children as $pr2 => $child) {
          echo $child->toHtml();
        }
      }
    $html = ob_get_clean();
    return $html;
  }
} // class

// EOF
