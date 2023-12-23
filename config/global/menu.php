<?php

return array(
    // Main menu
    'main'          => array(
        
        // //// Modules
        // array(
        //     'classes' => array('content' => 'pt-8 pb-2'),
        //     'content' => '<span class="menu-section text-muted text-uppercase fs-8 ls-1">Modules</span>',
        // ),

        // 內容管理
        array(
            'title'      => 'content-management',
            'icon'       => array(
                'svg'  => theme()->getSvgIcon("demo1/media/icons/duotune/general/gen055.svg", "svg-icon-2"),
                'font' => '<i class="bi bi-person fs-2"></i>',
            ),
            'classes'    => array('item' => 'menu-accordion show'),
            'arrow' => false,
            "role" => ["admin","editor"],
            'sub' => array(
                'class' => 'menu-sub-accordion menu-active-bg',
                'items' => array(
                    array(
                        'title'  => 'news-list',
                        'path'   => 'content-management/news-list',
                        'bullet' => '<span class="bullet bullet-dot"></span>',
                        'menu-title' => true,
                        "role" => ["admin","editor"],
                    ),
                    array(
                        'title'  => 'create-news',
                        'path'   => 'content-management/create-news',
                        'bullet' => '<span class="bullet bullet-dot"></span>',
                        'menu-title' => false,
                        "role" => ["admin","editor"],
                    ),
                    array(
                        'title'  => 'exhibition-list',
                        'path'   => 'content-management/exhibition-list',
                        'bullet' => '<span class="bullet bullet-dot"></span>',
                        'menu-title' => true,
                        "role" => ["admin","editor"],
                    ),
                ),
            ),
        ),

        // 用戶管理
        array(
            'title'      => 'user-management',
            'icon'       => array(
                'svg'  => theme()->getSvgIcon("demo1/media/icons/duotune/communication/com014.svg", "svg-icon-2"),
                'font' => '<i class="bi bi-person fs-2"></i>',
            ),

            'classes'    => array('item' => 'menu-accordion show'),
            'arrow' => false,
            "role" => ["admin"],
            'sub' => array(
                'class' => 'menu-sub-accordion menu-active-bg',
                'items' => array(
                    array(
                        'title'  => 'admin',
                        'path'   => 'user-management/admin',
                        'bullet' => '<span class="bullet bullet-dot"></span>',
                        'menu-title' => true,
                        "role" => ["admin"],
                    ),
                    array(
                        'title'  => 'create-user',
                        'path'   => 'user-management/new',
                        'bullet' => '<span class="bullet bullet-dot"></span>',
                        'menu-title' => false,
                        "role" => ["admin"],
                    ),
                    array(
                        'title'  => 'roles',
                        'path'   => 'user-management/roles',
                        'bullet' => '<span class="bullet bullet-dot"></span>',
                        'menu-title' => true,
                        "role" => ["admin"],
                    ),
                ),
            ),
        ),
        // 帳號管理
        array(
            'title'      => 'account',
            'icon'       => array(
                'svg'  => theme()->getSvgIcon("demo1/media/icons/duotune/general/gen051.svg", "svg-icon-2"),
                'font' => '<i class="bi bi-person fs-2"></i>',
            ),
            'classes'    => array('item' => 'menu-accordion show'),
            'arrow' => false,
            'sub' => array(
                'class' => 'menu-sub-accordion menu-active-bg',
                'items' => array(
                    array(
                        'title'  => 'account-settings',
                        'path'   => 'account/settings',
                        'bullet' => '<span class="bullet bullet-dot"></span>',
                        'menu-title' => true,
                    ),
                ),
            ),
        ),
        

    ),

    // Horizontal menu
    'horizontal'    => array(
        // Dashboard
        array(
            'title'   => 'Dashboard',
            'path'    => '',
            'classes' => array('item' => 'me-lg-1'),
        ),

    ),
);
