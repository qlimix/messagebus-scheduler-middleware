<?php declare(strict_types=1);

namespace Qlimix\MessageBus\Queue\Message;

use Qlimix\Serializable\SerializableInterface;

final class ScheduleMessage implements SerializableInterface
{
    private const NAME = 'qlimix.messagebus.queue.scheduled';

    /** @var string */
    private $id;

    /** @var array */
    private $message;

    /**
     * @param string $id
     * @param array $message
     */
    public function __construct(string $id, array $message)
    {
        $this->id = $id;
        $this->message = $message;
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
    public function getName(): string
    {
        return self::NAME;
    }

    /**
     * @inheritDoc
     */
    public function serialize(): array
    {
        return [
            'id' => $this->id,
            'name' => self::NAME,
            'message' => $this->message
        ];
    }

    /**
     * @inheritDoc
     */
    public static function deserialize(array $data): SerializableInterface
    {
        return new self($data['id'], $data['message']);
    }
}
