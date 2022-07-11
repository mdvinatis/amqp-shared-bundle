<?php

namespace Vinatis\Bundle\AmqpSharedBundle\Bridge\Symfony\Messenger\Message;

interface SharedMessageInterface
{
    public function getFrom(): string;

    public function getType(): string;

    public function getTo(): ?string;

    public function getContent(): array;
}