<?php

namespace Vinatis\Bundle\AmqpSharedBundle\Bridge\Symfony\Messenger\Message;

abstract class SharedMessage implements SharedMessageInterface
{
    protected array $content;
    protected string $from;
    protected ?string $to = null;

    public function __construct(array $content, string $from, ?string $to = null)
    {
        $this->content = $content;
        $this->from = $from;
        $this->to = $to;
    }

    public function getFrom(): string
    {
        return $this->from;
    }

    public function getTo(): ?string
    {
        return $this->to;
    }

    public function getContent(): array
    {
        return $this->content;
    }
}