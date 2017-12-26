<?php

namespace Siwayll\Exception;

interface ExceptionInterface
{
    /**
     * @return string
     */
    public function getMessageWithVariables(): string;
}
