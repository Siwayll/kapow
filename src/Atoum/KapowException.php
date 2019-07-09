<?php declare(strict_types = 1);

namespace Siwayll\Kapow\Atoum;

use mageekguy\atoum\asserters\exception;
use Siwayll\Kapow\KapowInterface;

class KapowException extends exception
{
    public function hasKapowMessage($message, $failMessage = null)
    {
        if (!$this->valueIsSet()->value instanceof KapowInterface) {
            $this->fail(
                $failMessage ?:
                    $this->_(
                        '%s does not implement \Siwayll\Kapow\KapowInterface',
                        get_class($this->valueIsSet()->value)
                    )
            );
        }

        if ($this->valueIsSet()->value->getMessageWithVariables() == (string) $message) {
            $this->pass();
            return $this;
        }

        $this->fail(
            $failMessage ?:
                $this->_(
                    'Kapow message \'%s\' is not identical to \'%s\'',
                    $this->value->getMessageWithVariables(),
                    $message
                )
        );

        return $this;
    }
}
