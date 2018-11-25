<?php declare(strict_types=1);

namespace Qlimix\MessageBus\MessageBus\Middleware;

use Qlimix\Id\Generator\UUID\UUID4Generator;
use Qlimix\MessageBus\Message\ScheduledMessage;
use Qlimix\MessageBus\MessageBus\Middleware\Exception\MiddlewareException;
use Qlimix\MessageBus\Queue\Envelope\ScheduleEnvelope;
use Qlimix\MessageBus\Queue\Message\ScheduleMessage;
use Qlimix\Queue\Scheduler\SchedulerInterface;

final class SchedulerMiddleware implements MiddlewareInterface
{
    /** @var SchedulerInterface */
    private $scheduler;

    /** @var UUID4Generator */
    private $uuid4Generator;

    /**
     * @param SchedulerInterface $scheduler
     * @param UUID4Generator $uuid4Generator
     */
    public function __construct(SchedulerInterface $scheduler, UUID4Generator $uuid4Generator)
    {
        $this->scheduler = $scheduler;
        $this->uuid4Generator = $uuid4Generator;
    }

    /**
     * @inheritDoc
     */
    public function handle($message, MiddlewareHandlerInterface $handler): void
    {
        if ($message instanceof ScheduledMessage) {
            try {
                $this->scheduler->schedule(new ScheduleEnvelope(
                    new ScheduleMessage(
                        $this->uuid4Generator->generate()->getUuid4(),
                        $message->getMessage()->serialize()
                    )),
                    $message->getScheduledAt()
                );
            } catch (\Throwable $exception) {
                throw new MiddlewareException('Could not handle message asynchronous', 0, $exception);
            }

            return;
        }

        $handler->next($message, $handler);
    }
}
