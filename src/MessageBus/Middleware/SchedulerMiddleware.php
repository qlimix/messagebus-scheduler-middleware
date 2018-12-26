<?php declare(strict_types=1);

namespace Qlimix\MessageBus\MessageBus\Middleware;

use Qlimix\Message\Scheduler\SchedulerInterface;
use Qlimix\MessageBus\Message\ScheduledMessage;
use Qlimix\MessageBus\MessageBus\Middleware\Exception\MiddlewareException;
use Throwable;

final class SchedulerMiddleware implements MiddlewareInterface
{
    /** @var SchedulerInterface */
    private $scheduler;

    public function __construct(SchedulerInterface $scheduler)
    {
        $this->scheduler = $scheduler;
    }

    /**
     * @inheritDoc
     */
    public function handle($message, MiddlewareHandlerInterface $handler): void
    {
        if ($message instanceof ScheduledMessage) {
            try {
                $this->scheduler->schedule($message->getMessage(), $message->getScheduledAt());
            } catch (Throwable $exception) {
                throw new MiddlewareException('Could not handle message asynchronous', 0, $exception);
            }

            return;
        }

        $handler->next($message, $handler);
    }
}
