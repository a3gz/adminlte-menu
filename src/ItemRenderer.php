<?php
namespace A3gZ\AdminLteMenu;

class ItemRenderer implements Interfaces\RendererInterface
{
  public function toHtml(\AdminLteMenu\Interfaces\MenuItemInterface $root) {
    ob_start();
    $href = $root->getUrl(); 

    $liItemClass = '';
    $aItemClass = '';

    if ($root->hasChildren()) {
      $href = "#sm-{$root->getId()}";
      $liItemClass .= 'treeview ';
    }

    if ($root->isActive()) {
      $liItemClass .= 'active ';
    }

    $aItemClass = "{$liItemClass} {$aItemClass} ";
    ?>
    <li
      <?php if ($liItemClass !== '') : ?>
        class="<?php echo $liItemClass; ?>"
      <?php endif; ?>
    >
      <a
        <?php if ($aItemClass !== '') : ?>
          class="<?php echo $aItemClass; ?>"
        <?php endif; ?>
        href="<?php echo "{$href}"; ?>" 
      >
        <?php
        if ($icon = $root->getIcon()) {
          echo $icon;
        }
        ?>
        <span><?php echo $root->getLabel(); ?></span>
        <?php
        if ($root->hasChildren()) {
          ?>
          <i class="fa fa-angle-left pull-right"></i>
          <?php
        }
        ?>
      </a>

      <?php
      if ($root->hasChildren()) {
        ?>
        <ul class="treeview-menu nav-<?php echo $root->level+2; ?>n-level" id="<?php echo $root->getId(); ?>">
          <?php
          foreach ($root->getChildren() as $pr1 => $children) {
            foreach ($children as $pr2 => $child) {
              echo $child->toHtml();
            }
          }
          ?>
        </ul>
        <?php
      }
      ?>
    </li>
    <?php
    $html = ob_get_clean();
    return $html;
  }
} // class

// EOF
