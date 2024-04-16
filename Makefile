# Prepare for production
production: ensure-composer ensure-permissions enable-cache build-assets

ensure-composer:
	composer install --ignore-platform-req=php --optimize-autoloader

ensure-permissions:
	chmod -R o+w storage

enable-cache:
	#php artisan optimize

build-assets:
	yarn
	npm run prod --demo1 --rtl
	npm run prod --demo2 --rtl
	npm run prod --demo3 --rtl
	npm run prod --demo4 --rtl
	npm run prod --demo5 --rtl
	npm run prod --demo6 --rtl
	npm run prod --demo7 --rtl
	npm run prod --demo8 --rtl
	npm run prod --demo9 --rtl
