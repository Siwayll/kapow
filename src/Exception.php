<?php

namespace Siwayll\Exception;

/**
 * class Exception
 */
class Exception extends \Exception
{
    const VARIABLE_REGEX = "/(\{[a-zA-Z0-9\_]+\})/";

    private $isLoaded = false;

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
        $this->loadMessageWithVariables();
    }

    /**
     * Get message with variables
     *
     * @throws \Exception
     *
     * @return string
     */
    protected function loadMessageWithVariables()
    {
        if (empty($this->message)) {
            throw new \Exception(sprintf(
                'Exception %s does not have a message',
                get_class($this)
           ), Level::CRITICAL);
        }

        preg_match(self::VARIABLE_REGEX, $this->message, $variables);

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

            $this->message = str_replace($variable, $this->$variableName, $this->message);
        }

        $this->isLoaded = true;
    }
}

