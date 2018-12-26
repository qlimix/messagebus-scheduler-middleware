<?php declare(strict_types=1);

namespace Qlimix\MessageBus\Message;

use Qlimix\Serialize\GetClassNameTrait;
use Qlimix\Serialize\SerializableInterface;

final class ScheduledMessage
{
    use GetClassNameTrait;

    /** @var SerializableInterface */
    private $message;

    /** @var \DateTimeImmutable */
    private $scheduledAt;

    public function __construct(SerializableInterface $message, \DateTimeImmutable $scheduledAt)
    {
        $this->message = $message;
        $this->scheduledAt = $scheduledAt;
    }

    public function getMessage(): SerializableInterface
    {
        return $this->message;
    }

    public function getScheduledAt(): \DateTimeImmutable
    {
        return $this->scheduledAt;
    }
}
