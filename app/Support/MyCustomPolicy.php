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
        $routeName = \Request::route()->getName();

        // dd($routeName);

        if (str_contains($routeName, 'content-management') || str_contains($routeName, 'role')|| str_contains($routeName, 'user-management')) {
            $this
            ->addDirective(Directive::BASE, Keyword::SELF)
            ->addDirective(Directive::CONNECT, ['self'])
            ->addDirective('script-src-elem', ['self','unsafe-inline', 'cdn.amcharts.com', 'static.cloudflareinsights.com','login.microsoftonline.com'])
            ->addDirective('style-src-elem', ['self','unsafe-inline','fonts.googleapis.com', 'cdn.datatables.net', 'cdn.ckeditor.com','login.microsoftonline.com'])
            ->addDirective(Directive::IMG, ['self', 'data:'])
            ->addDirective(Directive::FONT, ['self', 'fonts.googleapis.com', 'fonts.gstatic.com'])
            ->addDirective(Directive::OBJECT, Keyword::NONE)
            ->addDirective(Directive::FORM_ACTION, ['self','login.microsoftonline.com'])
            ->addDirective('frame-src', Keyword::SELF)
            ->addDirective('frame-ancestors', Keyword::SELF)
            ->addDirective(Directive::MEDIA, Keyword::SELF)
            ->addDirective('worker-src', Keyword::SELF)
            ->addDirective('manifest-src', Keyword::SELF)
            ->addNonceForDirective(Directive::SCRIPT)
            ->addNonceForDirective(Directive::STYLE)
            ;
        }
        else{
            $this
            ->addDirective(Directive::BASE, Keyword::SELF)
            ->addDirective(Directive::CONNECT, ['self'])
            ->addDirective('script-src-elem', ['self', 'cdn.amcharts.com', 'static.cloudflareinsights.com','login.microsoftonline.com'])
            ->addDirective('style-src-elem', ['self','fonts.googleapis.com', 'cdn.datatables.net', 'cdn.ckeditor.com','login.microsoftonline.com'])
            ->addDirective(Directive::IMG, ['self', 'data:'])
            ->addDirective(Directive::FONT, ['self', 'fonts.googleapis.com', 'fonts.gstatic.com'])
            ->addDirective(Directive::OBJECT, Keyword::NONE)
            ->addDirective(Directive::FORM_ACTION, Keyword::SELF)
            ->addDirective('frame-src', Keyword::SELF)
            ->addDirective('frame-ancestors', Keyword::SELF)
            ->addDirective(Directive::MEDIA, Keyword::SELF)
            ->addDirective('worker-src', Keyword::SELF)
            ->addDirective('manifest-src', Keyword::SELF)
            ->addNonceForDirective(Directive::SCRIPT)
            ->addNonceForDirective(Directive::STYLE)
            ;
        }

        
    }
}

