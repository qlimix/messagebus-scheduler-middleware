<?php declare(strict_types=1);

namespace Qlimix\MessageBus\Message;

use Qlimix\Serializable\GetNameTrait;
use Qlimix\Serializable\SerializableInterface;

final class ScheduledMessage implements SerializableInterface
{
    use GetNameTrait;

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
     * @inheritDoc
     */
    public function serialize(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->getName(),
            'scheduledAt' => $this->scheduledAt->format(DATE_ATOM),
            'message' => $this->message->serialize(),
            'messageName' => $this->message->getName()
        ];
    }

    /**
     * @inheritDoc
     */
    public static function deserialize(array $data): SerializableInterface
    {
        return new self($data['id'], $data['name']::deserialize($data['message']), $data['scheduledAt']);
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
