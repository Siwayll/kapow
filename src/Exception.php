<?php

namespace Siwayll\Exception;

/**
 * class Exception
 */
class Exception extends \Exception implements ExceptionInterface
{
    const VARIABLE_REGEX = "/(\{[a-zA-Z0-9\_]+\})/";

    /**
     * Constructor
     *
     * @param integer $code
     * @param string  $message
     */
    public function __construct(
        string $message = '',
        int $code = 0
    ) {
        parent::__construct($message, $code);
    }

    /**
     * Set code
     *
     * @param integer $code
     *
     * @return self
     */
    final public function setCode(int $code): self
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Set message
     *
     * @param string $message
     *
     * @return self
     */
    final public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message with variables
     *
     * @throws \Exception
     *
     * @return string
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

        preg_match(self::VARIABLE_REGEX, $message, $variables);

        foreach ($variables as $variable) {
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
