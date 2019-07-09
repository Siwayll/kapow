<?php declare(strict_types = 1);

namespace Siwayll\Kapow;

class Exception extends \Exception implements KapowInterface
{
    const VARIABLE_REGEX = "/(?<variable>\{[a-zA-Z0-9\_]+\})/";

    public function __construct(
        string $message = '',
        int $code = 0
    ) {
        parent::__construct($message, $code);
    }

    final public function setCode(int $code): self
    {
        $this->code = $code;

        return $this;
    }

    final public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @throws \Exception
     */
    final public function getMessageWithVariables(): string
    {
        if (empty($this->message)) {
            throw new \Exception(sprintf(
                'Exception %s does not have a message',
                get_class($this)
            ), Level::CRITICAL);
        }

        $message = $this->message;

        preg_match_all(self::VARIABLE_REGEX, $message, $matches);

        foreach ($matches['variable'] as $variable) {
            $variableName = substr($variable, 1, -1);

            if (!isset($this->$variableName)) {
                throw new \Exception(sprintf(
                    'Variable "%s" for exception "%s" not found',
                    $variableName,
                    get_class($this)
                ), Level::CRITICAL);
            }

            if (!is_string($this->$variableName)) {
                throw new \Exception(sprintf(
                    'Variable "%s" for exception "%s" must be a string, %s found',
                    $variableName,
                    get_class($this),
                    gettype($this->$variableName)
                ), Level::CRITICAL);
            }

            $message = str_replace($variable, $this->$variableName, $message);
        }

        return $message;
    }
}
