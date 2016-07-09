all: init

init: \
	composer.phar \
	vendor \
	config/cookie-secret.php

composer.phar: runtime/composer/installer runtime/composer/installer.sig
	test `sha384sum -- $< | awk '{print $$1}'` = `cat runtime/composer/installer.sig`
	php $< --stable --filename=$@ 
	touch -r composer.lock $@

runtime/composer/installer:
	mkdir -p runtime/composer
	curl -sSL https://getcomposer.org/installer -o $@
	touch -t 201601010000.00 $@

runtime/composer/installer.sig:
	mkdir -p runtime/composer
	curl -sSL https://composer.github.io/installer.sig -o $@
	touch -t 201601010000.00 $@

composer.lock: composer.json composer.phar
	php composer.phar update -vvv
	touch -r $< $@

vendor: composer.lock composer.phar
	php composer.phar install --prefer-dist
	touch -r $< $@

clean:
	rm -rf \
		composer.phar \
		runtime/composer \
		vendor

config/cookie-secret.php: vendor
	test -f $@ || (./yii secret/cookie > $@)

.PHONY: all clean
