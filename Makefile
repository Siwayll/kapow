define executable
chmod u+x $1
endef

.PHONY: bin
bin:
	$(call executable,bin/atoum) && $(call executable,bin/composer)

.PHONY: install
install: bin
	./bin/composer install
