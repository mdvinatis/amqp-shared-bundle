<?php

namespace Vinatis\Bundle\AmqpSharedBundle\Bridge\Symfony\Messenger\Serializer;

use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Exception\MessageDecodingFailedException;
use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface;
use Vinatis\Bundle\AmqpSharedBundle\Bridge\Symfony\Messenger\Message\SharedMessageInterface;
use Vinatis\Bundle\AmqpSharedBundle\MessageTypeChain;

use function json_decode;

final class SharedSerializer implements SerializerInterface, SharedSerializerInterface
{
    private MessageTypeChain $messageTypeChain;

    public function __construct(MessageTypeChain $messageTypeChain)
    {
        $this->messageTypeChain = $messageTypeChain;
    }

    /**
     * {@inheritDoc}
     */
    public function decode(array $encodedEnvelope): Envelope
    {
        if (!$body = json_decode($encodedEnvelope['body'], true)) {
            throw new MessageDecodingFailedException('The body is not a valid JSON.');
        }

        $content = $body['content'] ?? null;
        $metadata = $body['metadata'] ?? null;

        if (empty($metadata) || empty($content)) {
            throw new MessageDecodingFailedException('Content and Metadata is required');
        }

        try {
            $class = $this->messageTypeChain->getMessageByType($metadata['type']);
            $object = new $class($content, $metadata['from'], $metadata['to']);
            if (!($class instanceof SharedMessageInterface)) {
                throw new \RuntimeException('Message "'.$object::class.'" must implement "SharedMessageInterface"');
            }

            return new Envelope($object);
        } catch (\Exception) {
            throw new MessageDecodingFailedException('Metadata type is not valid');
        }
    }

    /**
     * {@inheritDoc}
     */
    public function encode(Envelope $envelope): array
    {
        $message = $envelope->getMessage();

        if ($message instanceof SharedMessageInterface) {
            return [
                'body' => \json_encode([
                    'metadata' => [
                        'type' => $message->getType(),
                        'from' => $message->getFrom(),
                        'to' => $message->getTo(),
                    ],
                    'content' => $message->getContent(),
                ]),
                'headers' => [],
            ];
        }
    }
}