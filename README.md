<h1 align="center">
Kapow !
</h1>

[![FOSSA Status](https://app.fossa.io/api/projects/git%2Bgithub.com%2FSiwayll%2Fkapow.svg?type=shield)](https://app.fossa.io/projects/git%2Bgithub.com%2FSiwayll%2Fkapow?ref=badge_shield)
[![Build Status](https://travis-ci.org/Siwayll/kapow.svg?branch=master)](https://travis-ci.org/Siwayll/kapow)
[![Coverage Status](https://coveralls.io/repos/github/Siwayll/kapow/badge.svg?branch=master)](https://coveralls.io/github/Siwayll/kapow?branch=master)

Simple exception with variables in it.

## Quick examples
Create an Exception

```php
use Siwayll\Kapow\Exception as Kapow;
use Siwayll\Kapow\Level;
...

class DodgeSpecialAttack extends Kapow
{
    protected $superVillain;

    protected $superHero;

    protected $specialAttack;

    /**
     * Message of the exception
     */
    public $message = 'The super villain {superVillain} has dodge {superHero} super hero special attack {specialAttack}';

    public $code = Level::CRITICAL;

    public function __construct(Mutant $superVillain, Mutant $superHero, string $specialAttack)
    {
        $this->superVillain = $superVillain->getName();
        $this->superHero = $superHero->getName();
        $this->specialAttack = $specialAttack;
    }
}
```
Throw it !
```php
throw new DodgeSpecialAttack($villan, $hero, 'ultra smash 2');
```

## Contributing

- Fork it!
- Create your feature branch: `git checkout -b my-new-feature`
- Commit your changes: `git commit -am 'Add some feature'`
- Push to the branch: `git push origin my-new-feature`
- Submit a pull request


## Running the tests

```bash
make install
./bin/atoum
```

## License

MIT


[![FOSSA Status](https://app.fossa.io/api/projects/git%2Bgithub.com%2FSiwayll%2Fkapow.svg?type=large)](https://app.fossa.io/projects/git%2Bgithub.com%2FSiwayll%2Fkapow?ref=badge_large)
