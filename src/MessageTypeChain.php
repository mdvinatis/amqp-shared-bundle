<?php

namespace Vinatis\Bundle\AmqpSharedBundle;

class MessageTypeChain
{
    private array $messages = [];

    public function __construct(array $messages)
    {
        foreach ($messages as $message) {
            $this->messages[$message['type']] = $message['class'];
        }
    }

    public function getMessageByType(string $type): string
    {
        if (! array_key_exists($type, $this->messages)) {
            throw new \InvalidArgumentException('Message type '.$type.' do not exist');
        }

        return $this->messages[$type];
    }

    public function getMessages(): array
    {
        return $this->messages;
    }
}