<?php

namespace Siwayll\Kapow\Specs\Units;

use Siwayll\Kapow\Tests\Units\Test;

class Exception extends Test
{
    public function shouldWorkAsAnException()
    {
        $this
            ->given($this->newTestedInstance('message', 200))
            ->class(get_class($this->testedInstance))
                ->hasParent('Exception')
        ;
    }

    public function shouldImplementSiwayllExceptionInterface()
    {
        $this
            ->given($this->newTestedInstance('message', 200))
            ->class(get_class($this->testedInstance))
                ->hasInterface('\Siwayll\Kapow\KapowInterface')
        ;
    }

    public function shouldHaveSetterToMessage()
    {
        $this
            ->given(
                $message = 'message',
                $newMessage = 'newMessage',
                $code = 200,
                $this->newTestedInstance($message, $code)
            )
            ->string($this->testedInstance->getMessage())
                ->isEqualTo($message)
            ->object($this->testedInstance->setMessage($newMessage))
                ->isTestedInstance()
            ->string($this->testedInstance->getMessage())
                ->isEqualTo($newMessage)
        ;
    }

    public function shouldHaveSetterToCode()
    {
        $this
            ->given(
                $message = 'message',
                $newCode = 418,
                $code = 200,
                $this->newTestedInstance($message, $code)
            )
            ->integer($this->testedInstance->getCode())
                ->isEqualTo($code)
            ->object($this->testedInstance->setCode($newCode))
                ->isTestedInstance()
            ->integer($this->testedInstance->getCode())
                ->isEqualTo($newCode)
        ;
    }

    public function shouldUseVariableToComposeMessage()
    {
        $this
            ->given(
                $message = 'message with {varOne}',
                $code = 200,
                $this->newTestedInstance($message, $code)
            )
            ->if($this->testedInstance->varOne = 'varOneContent')
            ->string($this->testedInstance->getMessageWithVariables())
                ->isEqualTo('message with varOneContent')
        ;
    }

    public function shouldThrowExceptionWhenVariableIsNotFound()
    {
        $this
            ->given(
                $message = 'message with {varOne}',
                $this->newTestedInstance($message)
            )
            ->exception(
                function () {
                    $this->testedInstance->getMessageWithVariables();
                }
            )
                ->hasMessage('Variable "varOne" for exception "' . $this->testedClass . '" not found')
        ;
    }

    public function shouldThrowExceptionWhenMessageIsEmpty()
    {
        $this
            ->given(
                $this->newTestedInstance()
            )
            ->exception(
                function () {
                    $this->testedInstance->getMessageWithVariables();
                }
            )
            ->hasMessage('Exception ' . $this->testedClass . ' does not have a message')
        ;
    }

    public function shouldThrowExceptionWhenUsedVariableIsNotAString()
    {
        $this
            ->given(
                $message = 'message with {varOne}',
                $this->newTestedInstance($message)
            )
            ->if($this->testedInstance->varOne = new \stdClass())
            ->exception(
                function () {
                    $this->testedInstance->getMessageWithVariables();
                }
            )
            ->hasMessage(
                'Variable "varOne" for exception "' . $this->testedClass . '" must be a string, object found'
            )
        ;
    }
}
