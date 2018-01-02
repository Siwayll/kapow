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
