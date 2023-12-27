<?php

namespace App\Support;

use Spatie\Csp\Directive;
use Spatie\Csp\Keyword;
use Spatie\Csp\Policies\Basic;

class MyCustomPolicy extends Basic
{
    public function configure()
    {
        // parent::configure();
        
        $this
        ->addDirective(Directive::BASE, Keyword::SELF)
        ->addDirective(Directive::CONNECT, 'self')
        ->addDirective('script-src-elem', ['self','unsafe-inline','unsafe-eval', 'cdn.amcharts.com', 'static.cloudflareinsights.com'])
        ->addDirective('style-src-elem', ['self','unsafe-inline','unsafe-eval','fonts.googleapis.com', 'cdn.datatables.net'])
        ->addDirective(Directive::IMG, ['self', 'data:'])
        ->addDirective(Directive::FONT, ['self', 'fonts.googleapis.com', 'fonts.gstatic.com'])
        ->addDirective(Directive::OBJECT, Keyword::NONE)
        ->addDirective(Directive::FORM_ACTION, Keyword::SELF)
        ->addDirective('frame-src', Keyword::SELF)
        ->addDirective('frame-ancestors', Keyword::SELF)
        ->addDirective(Directive::MEDIA, Keyword::SELF)
        ->addDirective('worker-src', Keyword::SELF)
        ->addDirective('manifest-src', Keyword::SELF)
        ;
    }
}

