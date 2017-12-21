<?php

namespace Siwayll\Exception;

/**
 * class Exception
 */
class Exception extends \Exception
{
    const VARIABLE_REGEX = "/(\{[a-zA-Z0-9\_]+\})/";

    /**
     * Constructor
     *
     * @param integer $code
     * @param string  $message
     */
    public function __construct(
        int $code = 0,
        string $message = ''
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
    public function setCode(int $code): Exception
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
    public function setMessage(string $message): Exception
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
    public function getMessageWithVariables()
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

