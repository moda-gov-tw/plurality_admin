<?php

namespace App\Core\Adapters;

abstract class BootstrapBase
{
    public static function initBase()
    {
        theme()->addHtmlAttribute('body', 'id', 'kt_body');
        
        theme()->addHtmlAttribute('body', 'sha256', '8x79V4hKje9JJjwY4mh5Z3OSc8e4CLNcMJm6Mg');


        
    }

    public static function run()
    {
        if (theme()->getOption('layout', 'base') === 'docs') {
            return;
        }

        // Init	base
        static::initBase();

        // Init layout
        if (theme()->getOption('layout', 'main/type') === 'default') {
            static::initLayout();
        }
    }
}
