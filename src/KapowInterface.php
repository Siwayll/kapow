<?php

namespace Siwayll\Kapow;

interface KapowInterface extends \Throwable
{
    /**
     * @return string
     */
    public function getMessageWithVariables(): string;
}
