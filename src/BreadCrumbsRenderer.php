<?php
namespace A3gZ\AdminLteMenu;

class BreadCrumbsRenderer
{
  public function toHtml(\AdminLteMenu\BreadCrumbs $breadCrumbs) {
    ob_start();

    $crumbs = $breadCrumbs->getCrumbs();
    ?>
    <ol class="breadcrumb">
      <li><a href="<?php echo $breadCrumbs->getUrlRoot(); ?>"><i class="fa fa-fw fa-dashboard fa-lg"></i></a></li>

      <?php for ($i=0, $n=count($crumbs); $i < $n; $i++) : $crumb = $crumbs[$i]; ?>
        <li <?php if ($i == ($n-1)) echo 'class="last"'; ?>>
          <?php if (($url = $crumb->getUrl()) && (substr($url, -1) != '#') && ($i < $n-1)) : ?>
            <a href="<?php echo $crumb->getUrl(); ?>"><?php echo $crumb->getName(); ?></a>
          <?php else: ?>
            <?php echo $crumb->getName(); ?>
          <?php endif; ?>
        </li>
      <?php endfor; ?>
    </ol>
    <?php
    $html = ob_get_clean();
    return $html;
  }
} // class

// EOF
