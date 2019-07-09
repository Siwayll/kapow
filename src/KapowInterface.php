<?php declare(strict_types = 1);

namespace Siwayll\Kapow;

interface KapowInterface extends \Throwable
{
    public function getMessageWithVariables(): string;
}
