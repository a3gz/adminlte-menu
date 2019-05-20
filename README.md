# AdminLte Menu
Dynamic menu for PHP applications using [AdminLte template](https://github.com/ColorlibHQ/AdminLTE).

## Mode of use

### Build the menu before the page is rendered

Create the menu tree.

    $menuTree = new Item([
      'id' => 'root',
      'urlRoot' => 'http://localhost:80',
    ], new \AdminLteMenu\RootRenderer());

Add a menu entry without inner options

    $menuTree->add(
      new Item([
        'id' => 'dashboard',
        'label' => 'Dashboard',
        'path' => '',
        'icon' => 'fa-dashboard',
      ])
    );

Add a menu group with options

    $menuGroup = new Item([
      'id' => 'auth',
      'path' => 'auth',
      'label' => 'Authentication',
      'icon' => 'fa-lock',
    ]);

    $menuGroup->add(
      new Item([
        'id'=>'auth/users',
        'path'=>'/auth/users',
        'label'=> 'Users',
        'icon'=>'fa-users',
        'pattern'=>'#.*auth/users(/[0-9]+)?#',
      ])
    )

    $menuTree->add($menuGroup);

### In the view

    <aside class="main-sidebar">
      <section class="sidebar">
        <!-- user panel... -->
        <ul class="sidebar-menu tree" data-widget="tree">
          <?php echo $menuTree->toHtml(); ?>
        </ul>
      </section>
    </aside>
