MKDIR := mkdir -p
RM := rm -rf
CP := cp -r

define executable
chmod u+x $1
endef

bin/%:
	$(MKDIR) $@

.PHONY: composer/install
composer/install:
	docker run --rm --interactive --tty --volume ${PWD}:/app composer install

composer/require/%: composer/install
	docker run --rm --interactive --tty --volume ${PWD}:/app composer require $@

