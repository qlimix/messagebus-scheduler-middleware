<?php declare(strict_types=1);

namespace Qlimix\MessageBus\Queue\Envelope;

use Qlimix\Queue\Envelope\EnvelopeInterface;
use Qlimix\Serializable\SerializableInterface;

final class ScheduleEnvelope implements EnvelopeInterface
{
    private const ROUTE = 'qlimix.messagebus.queue.async';

    /** @var SerializableInterface */
    private $message;

    /**
     * @param SerializableInterface $message
     */
    public function __construct(SerializableInterface $message)
    {
        $this->message = $message;
    }

    /**
     * @inheritDoc
     */
    public function getRoute(): string
    {
        return self::ROUTE;
    }

    /**
     * @inheritDoc
     */
    public function getMessage(): array
    {
        return $this->message->serialize();
    }
}
