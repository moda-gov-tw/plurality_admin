<?php
return array(
    
    // Set this option false to remove demo in the assets path
    'use_demo' => true,

    'permissions'   =>  array(
        'user',
        'role',
        'news',
        'exhibition'
    ),

    // Product
    'product'  => array(
        'name'        => 'Plurality Backend',
        'description' => '次世代數位寶島成果網站管理系統',
        'preview'     => '',
        'home'        => 'http://admin.plurality.moda.gov.tw/',
        
        'demos'       => array(
            'demo1' => array(
                'title'       => 'Demo 1',
                'description' => 'Default Dashboard',
                'published'   => true,
                'thumbnail'   => 'demos/demo1.png',
            ),
        ),
    ),

    // Meta
    'meta'     => array(
        'title'       => '次世代數位寶島成果網站管理系統',
        'description' => '次世代數位寶島成果網站管理系統',
        'keywords'    => '次世代數位寶島成果網站管理系統',
        'canonical'   => 'http://admin.plurality.moda.gov.tw/',
    ),

    // General
    'general'  => array(
        'website'             => 'https://keenthemes.com',
        'about'               => 'https://keenthemes.com',
        'contact'             => 'mailto:support@keenthemes.com',
        'support'             => 'https://keenthemes.com/support',
        'bootstrap-docs-link' => 'https://getbootstrap.com/docs/5.0',
        'licenses'            => 'https://keenthemes.com/licensing',
        'social-accounts'     => array(
            array(
                'name' => 'Youtube', 'url' => 'https://www.youtube.com/c/KeenThemesTuts/videos', 'logo' => 'svg/social-logos/youtube.svg', "class" => "h-20px",
            ),
            array(
                'name' => 'Github', 'url' => 'https://github.com/KeenthemesHub', 'logo' => 'svg/social-logos/github.svg', "class" => "h-20px",
            ),
            array(
                'name' => 'Twitter', 'url' => 'https://twitter.com/keenthemes', 'logo' => 'svg/social-logos/twitter.svg', "class" => "h-20px",
            ),
            array(
                'name' => 'Instagram', 'url' => 'https://www.instagram.com/keenthemes', 'logo' => 'svg/social-logos/instagram.svg', "class" => "h-20px",
            ),

            array(
                'name' => 'Facebook', 'url' => 'https://www.facebook.com/keenthemes', 'logo' => 'svg/social-logos/facebook.svg', "class" => "h-20px",
            ),
            array(
                'name' => 'Dribbble', 'url' => 'https://dribbble.com/keenthemes', 'logo' => 'svg/social-logos/dribbble.svg', "class" => "h-20px",
            ),
        ),
    ),

    // Layout
    'layout'   => array(
        // Docs
        'docs'          => array(
            'logo-path'  => array(
                'default' => 'logos/logo-1.svg',
                'dark'    => 'logos/logo-1-dark.svg',
            ),
            'logo-class' => 'h-25px',
        ),

        // Illustration
        'illustrations' => array(
            'set' => 'sketchy-1',
        ),
    ),

    // Vendors
    'vendors'  => array(
        "datatables"             => array(
            "css" => array(
                "plugins/custom/datatables/datatables.bundle.css",
            ),
            "js"  => array(
                "plugins/custom/datatables/datatables.bundle.js",
            ),
        ),
        "formrepeater"           => array(
            "js" => array(
                "plugins/custom/formrepeater/formrepeater.bundle.js",
            ),
        ),
        "fullcalendar"           => array(
            "css" => array(
                "plugins/custom/fullcalendar/fullcalendar.bundle.css",
            ),
            "js"  => array(
                "plugins/custom/fullcalendar/fullcalendar.bundle.js",
            ),
        ),
        "flotcharts"             => array(
            "js" => array(
                "plugins/custom/flotcharts/flotcharts.bundle.js",
            ),
        ),
        "google-jsapi"           => array(
            "js" => array(
                "//www.google.com/jsapi",
            ),
        ),
        "tinymce"                => array(
            "js" => array(
                "plugins/custom/tinymce/tinymce.bundle.js",
            ),
        ),
        "ckeditor-classic"       => array(
            "js" => array(
                "plugins/custom/ckeditor/ckeditor-classic.bundle.js",
            ),
        ),
        "ckeditor-inline"        => array(
            "js" => array(
                "plugins/custom/ckeditor/ckeditor-inline.bundle.js",
            ),
        ),
        "ckeditor-balloon"       => array(
            "js" => array(
                "plugins/custom/ckeditor/ckeditor-balloon.bundle.js",
            ),
        ),
        "ckeditor-balloon-block" => array(
            "js" => array(
                "plugins/custom/ckeditor/ckeditor-balloon-block.bundle.js",
            ),
        ),
        "ckeditor-document"      => array(
            "js" => array(
                "plugins/custom/ckeditor/ckeditor-document.bundle.js",
            ),
        ),
        "draggable"              => array(
            "js" => array(
                "plugins/custom/draggable/draggable.bundle.js",
            ),
        ),
        "fslightbox"             => array(
            "js" => array(
                "plugins/custom/fslightbox/fslightbox.bundle.js",
            ),
        ),
        "jkanban"                => array(
            "css" => array(
                "plugins/custom/jkanban/jkanban.bundle.css",
            ),
            "js"  => array(
                "plugins/custom/jkanban/jkanban.bundle.js",
            ),
        ),
        "typedjs"                => array(
            "js" => array(
                "plugins/custom/typedjs/typedjs.bundle.js",
            ),
        ),
        "cookiealert"            => array(
            "css" => array(
                "plugins/custom/cookiealert/cookiealert.bundle.css",
            ),
            "js"  => array(
                "plugins/custom/cookiealert/cookiealert.bundle.js",
            ),
        ),
        "cropper"                => array(
            "css" => array(
                "plugins/custom/cropper/cropper.bundle.css",
            ),
            "js"  => array(
                "plugins/custom/cropper/cropper.bundle.js",
            ),
        ),
        "vis-timeline"           => array(
            "css" => array(
                "plugins/custom/vis-timeline/vis-timeline.bundle.css",
            ),
            "js"  => array(
                "plugins/custom/vis-timeline/vis-timeline.bundle.js",
            ),
        ),
        "jstree"                 => array(
            "css" => array(
                "plugins/custom/jstree/jstree.bundle.css",
            ),
            "js"  => array(
                "plugins/custom/jstree/jstree.bundle.js",
            ),
        ),
        "prismjs"                => array(
            "css" => array(
                "plugins/custom/prismjs/prismjs.bundle.css",
            ),
            "js"  => array(
                "plugins/custom/prismjs/prismjs.bundle.js",
            ),
        ),
        "leaflet"                => array(
            "css" => array(
                "plugins/custom/leaflet/leaflet.bundle.css",
            ),
            "js"  => array(
                "plugins/custom/leaflet/leaflet.bundle.js",
            ),
        ),
        "amcharts"               => array(
            "js" => array(
                "https://cdn.amcharts.com/lib/5/index.js",
                "https://cdn.amcharts.com/lib/5/xy.js",
                "https://cdn.amcharts.com/lib/5/percent.js",
                "https://cdn.amcharts.com/lib/5/radar.js",
                "https://cdn.amcharts.com/lib/5/themes/Animated.js",
            ),
        ),
        "amcharts-maps"          => array(
            "js" => array(
                "https://cdn.amcharts.com/lib/5/index.js",
                "https://cdn.amcharts.com/lib/5/map.js",
                "https://cdn.amcharts.com/lib/5/geodata/worldLow.js",
                "https://cdn.amcharts.com/lib/5/geodata/continentsLow.js",
                "https://cdn.amcharts.com/lib/5/geodata/usaLow.js",
                "https://cdn.amcharts.com/lib/5/geodata/worldTimeZonesLow.js",
                "https://cdn.amcharts.com/lib/5/geodata/worldTimeZoneAreasLow.js",
                "https://cdn.amcharts.com/lib/5/themes/Animated.js",
            ),
        ),
        "amcharts-stock"         => array(
            "js" => array(
                "https://cdn.amcharts.com/lib/5/index.js",
                "https://cdn.amcharts.com/lib/5/xy.js",
                "https://cdn.amcharts.com/lib/5/themes/Animated.js",
            ),
        ),
        'bootstrap-select'       => array(
            'css' => array(
                'plugins/custom/bootstrap-select/bootstrap-select.bundle.css',
            ),
            'js'  => array(
                'plugins/custom/bootstrap-select/bootstrap-select.bundle.js',
            ),
        ),
    ),

);
