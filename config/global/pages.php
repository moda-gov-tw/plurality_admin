<?php
return array(
    '' => array(
        'title'       => 'Dashboard',
        'description' => '',
        'view'        => 'index',
        'layout'      => array(
            'page-title' => array(
                'description' => true,
                'breadcrumb'  => false,
            ),
        ),
        'assets'      => array(
            'custom'  => array(
                'js' => array(
                    'js/widgets.bundle.js',
                ),
            ),
        ),
    ),

    //內容管理
    'content-management' => array(

        //最新消息列表
        'news-list' => array(
            'title'  => 'news-list',
            'assets' => array(
                'custom' => array(
                    'js' => array(
                        'js/custom/content-management/news/list-datatable.js',
                        'js/custom/content-management/news/delete.js',
                    ),
                ),
                'vendors' => array('datatables'),
            ),
        ),
        //新增最新消息
        'create-news' => array(
            'title'  => 'create-news',
            'assets' => array(
                'custom' => array(
                    'js' => array(
                        'js/custom/content-management/news/date-picker.js',
                        'js/custom/content-management/news/submit-form.js',
                        'js/custom/content-management/news/ckeditor.js',
                    ),
                ),

                'vendors' => array('ckeditor-classic'),
            ),
        ),
        //編輯最新消息
        'edit-news' => array(
            'title'  => 'edit-news',
            'assets' => array(
                'custom' => array(
                    'js' => array(
                        'js/custom/content-management/news/date-picker.js',
                        'js/custom/content-management/news/submit-form.js',
                        'js/custom/content-management/news/ckeditor.js',
                    ),
                ),
                
                'vendors' => array('ckeditor-classic'),
            ),
        ),

        //活動資訊列表
        'exhibition-list' => array(
            'title'  => 'exhibition-list',
            'assets' => array(
                'custom' => array(
                    'js' => array(
                        'js/custom/content-management/exhibition/list-datatable.js',
                        'js/custom/content-management/exhibition/delete.js',
                    ),
                ),
                'vendors' => array('datatables'),
            ),
        ),
        //新增活動資訊
        'create-exhibition' => array(
            'title'  => 'create-exhibition',
            'assets' => array(
                'custom' => array(
                    'js' => array(
                        'js/custom/content-management/exhibition/date-picker.js',
                        'js/custom/content-management/exhibition/submit-form.js',
                    ),
                ),
            ),
        ),
        //編輯活動資訊
        'edit-exhibition' => array(
            'title'  => 'edit-exhibition',
            'assets' => array(
                'custom' => array(
                    'js' => array(
                        'js/custom/content-management/exhibition/date-picker.js',
                        'js/custom/content-management/exhibition/submit-form.js',
                    ),
                ),
            ),
        ),
    ),

    //用戶管理
    'user-management' => array(

        //後台使用者列表
        'admin' => array(
            'title'  => 'admin',
            'assets' => array(
                'custom' => array(
                    'js' => array(
                        'js/custom/user-management/admin/admin-table.js',
                        'js/custom/user-management/admin/change-user-role.js',
                        'js/custom/user-management/admin/delete-user.js',
                    ),
                ),
                'vendors' => array('datatables'),
            ),
        ),
        //後台使用者列表
        'new' => array(
            'title'  => 'create-user',
            'assets' => array(
                'custom' => array(
                    'js' => array(
                        'js/custom/user-management/admin/submit-form.js',
                    ),
                ),
                'vendors' => array('datatables'),
            ),
        ),
    ),
    'account' => array(
        'settings' => array(
            'title'       => 'account-settings',
            'assets'      => array(
                'custom' => array(
                    'js' => array(
                        'js/custom/account/settings/change-password.js',
                    ),
                ),
            ),
        ),
    ),
    
    'login'           => array(
        'title'  => 'Login',
        'assets' => array(
            'custom' => array(
                'js' => array(
                    'js/custom/authentication/sign-in/general.js',
                ),
            ),
        ),
        'layout' => array(
            'main' => array(
                'type' => 'blank', // Set blank layout
                'body' => array(
                    'class' => theme()->isDarkMode() ? '' : 'bg-body',
                ),
            ),
        ),
    ),
    'register'        => array(
        'title'  => 'Register',
        'assets' => array(
            'custom' => array(
                'js' => array(
                    'js/custom/authentication/sign-up/general.js',
                ),
            ),
        ),
        'layout' => array(
            'main' => array(
                'type' => 'blank', // Set blank layout
                'body' => array(
                    'class' => theme()->isDarkMode() ? '' : 'bg-body',
                ),
            ),
        ),
    ),
    'forgot-password' => array(
        'title'  => 'Forgot Password',
        'assets' => array(
            'custom' => array(
                'js' => array(
                    'js/custom/authentication/password-reset/password-reset.js',
                ),
            ),
        ),
        'layout' => array(
            'main' => array(
                'type' => 'blank', // Set blank layout
                'body' => array(
                    'class' => theme()->isDarkMode() ? '' : 'bg-body',
                ),
            ),
        ),
    ),

    'log' => array(
        'audit'  => array(
            'title'  => 'Audit Log',
            'assets' => array(
                'custom' => array(
                    'css' => array(
                        'plugins/custom/datatables/datatables.bundle.css',
                    ),
                    'js'  => array(
                        'plugins/custom/datatables/datatables.bundle.js',
                    ),
                ),
            ),
        ),
        'system' => array(
            'title'  => 'System Log',
            'assets' => array(
                'custom' => array(
                    'css' => array(
                        'plugins/custom/datatables/datatables.bundle.css',
                    ),
                    'js'  => array(
                        'plugins/custom/datatables/datatables.bundle.js',
                    ),
                ),
            ),
        ),
    ),

    'error' => array(
        'error-404' => array(
            'title' => 'Error 404',
        ),
        'error-500' => array(
            'title' => 'Error 500',
        ),
    ),

   

    'users'         => array(
        'title' => 'User List',

        '*' => array(
            'title' => 'Show User',

            'edit' => array(
                'title' => 'Edit User',
            ),
        ),
    ),

    // Documentation pages
    'documentation' => array(
        '*' => array(
            'assets' => array(
                'vendors' => array('prismjs'),
                'custom'  => array(
                    'js' => array(
                        'js/custom/documentation/documentation.js',
                    ),
                ),
            ),

            'layout' => array(
                'base'    => 'docs', // Set base layout: default|docs

                // Content
                'content' => array(
                    'width'  => 'fixed', // Set fixed|fluid to change width type
                    'layout' => 'documentation'  // Set content type
                ),
            ),
        ),

        'getting-started' => array(
            'overview' => array(
                'title'       => 'Overview',
                'description' => '',
                'view'        => 'documentation/getting-started/overview',
            ),

            'build' => array(
                'title'       => 'Gulp',
                'description' => '',
                'view'        => 'documentation/getting-started/build/build',
            ),

            'multi-demo' => array(
                'overview' => array(
                    'title'       => 'Overview',
                    'description' => '',
                    'view'        => 'documentation/getting-started/multi-demo/overview',
                ),
                'build'    => array(
                    'title'       => 'Multi-demo Build',
                    'description' => '',
                    'view'        => 'documentation/getting-started/multi-demo/build',
                ),
            ),

            'file-structure' => array(
                'title'       => 'File Structure',
                'description' => '',
                'view'        => 'documentation/getting-started/file-structure',
            ),

            'customization' => array(
                'sass'       => array(
                    'title'       => 'SASS',
                    'description' => '',
                    'view'        => 'documentation/getting-started/customization/sass',
                ),
                'javascript' => array(
                    'title'       => 'Javascript',
                    'description' => '',
                    'view'        => 'documentation/getting-started/customization/javascript',
                ),
            ),

            'dark-mode' => array(
                'title' => 'Dark Mode Version',
                'view'  => 'documentation/getting-started/dark-mode',
            ),

            'rtl' => array(
                'title' => 'RTL Version',
                'view'  => 'documentation/getting-started/rtl',
            ),

            'troubleshoot' => array(
                'title' => 'Troubleshoot',
                'view'  => 'documentation/getting-started/troubleshoot',
            ),

            'changelog' => array(
                'title'       => 'Changelog',
                'description' => 'version and update info',
                'view'        => 'documentation/getting-started/changelog/changelog',
            ),

            'updates' => array(
                'title'       => 'Updates',
                'description' => 'components preview and usage',
                'view'        => 'documentation/getting-started/updates',
            ),

            'references' => array(
                'title'       => 'References',
                'description' => '',
                'view'        => 'documentation/getting-started/references',
            ),
        ),

        'general' => array(
            'datatables'   => array(
                'overview' => array(
                    'title'       => 'Overview',
                    'description' => 'plugin overview',
                    'view'        => 'documentation/general/datatables/overview/overview',
                ),
            ),
            'remove-demos' => array(
                'title'       => 'Remove Demos',
                'description' => 'How to remove unused demos',
                'view'        => 'documentation/general/remove-demos/index',
            ),
        ),

        'configuration' => array(
            'general'     => array(
                'title'       => 'General Configuration',
                'description' => '',
                'view'        => 'documentation/configuration/general',
            ),
            'menu'        => array(
                'title'       => 'Menu Configuration',
                'description' => '',
                'view'        => 'documentation/configuration/menu',
            ),
            'page'        => array(
                'title'       => 'Page Configuration',
                'description' => '',
                'view'        => 'documentation/configuration/page',
            ),
            'npm-plugins' => array(
                'title'       => 'Add NPM Plugin',
                'description' => 'Add new NPM plugins and integrate within webpack mix',
                'view'        => 'documentation/configuration/npm-plugins',
            ),
        ),
    ),
);
