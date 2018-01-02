# Kapow !

Simple exception with variables in it.

## Quick start
Create an Exception

```php
use Siwayll\Kapow\Exception as Kapow;
use Siwayll\Kapow\Level;
...

class TagMalformed extends Kapow
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

## Contributing

- Fork it!
- Create your feature branch: `git checkout -b my-new-feature`
- Commit your changes: `git commit -am 'Add some feature'`
- Push to the branch: `git push origin my-new-feature`
- Submit a pull request


## Development

```bash
make install
./bin/atoum
```

## License

MIT
