<?php $menu = [
    'business' => [
        'class' => 'menu-title',
        'icon' => 'fa fa-menu-title fa-briefcase',
        'url' => ['controller' => 'pages', 'action' => 'display', 'business-solutions'],
		'title' => __('Business Solutions')
    ],
    'showcase' => [
        'class' => 'menu-title mt30',
        'icon' => 'fa fa-menu-title fa-desktop',
        'url' => ['controller' => 'projects'],
		'title' => __('Showcase')
    ]
];
?>
<ul class="footer-menu business-solution">
    <?= $this->App->menuItems($menu); ?>
</ul>
