<?php declare(strict_types=1);

namespace Qlimix\MessageBus\Message;

use Qlimix\Serialize\GetClassNameTrait;
use Qlimix\Serialize\SerializableInterface;

final class ScheduledMessage
{
    use GetClassNameTrait;

    /** @var string */
    private $id;

    /** @var SerializableInterface */
    private $message;

    /** @var \DateTimeImmutable */
    private $scheduledAt;

    /**
     * @param string $id
     * @param SerializableInterface $message
     * @param \DateTimeImmutable $scheduledAt
     */
    public function __construct(string $id, SerializableInterface $message, \DateTimeImmutable $scheduledAt)
    {
        $this->id = $id;
        $this->message = $message;
        $this->scheduledAt = $scheduledAt;
    }

    /**
     * @inheritDoc
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return SerializableInterface
     */
    public function getMessage(): SerializableInterface
    {
        return $this->message;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getScheduledAt(): \DateTimeImmutable
    {
        return $this->scheduledAt;
    }
}
