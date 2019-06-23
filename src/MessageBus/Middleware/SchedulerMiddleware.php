<?php declare(strict_types=1);

namespace Qlimix\MessageBus\MessageBus\Middleware;

use DateInterval;
use DateTimeImmutable;
use Qlimix\Message\Scheduler\SchedulerInterface;
use Qlimix\MessageBus\MessageBus\Middleware\Exception\MiddlewareException;
use Qlimix\Serializable\SerializableInterface;
use Throwable;

final class SchedulerMiddleware implements MiddlewareInterface
{
    /** @var SchedulerInterface */
    private $scheduler;

    /** @var DateInterval */
    private $interval;

    public function __construct(SchedulerInterface $scheduler, DateInterval $interval)
    {
        $this->scheduler = $scheduler;
        $this->interval = $interval;
    }

    /**
     * @inheritDoc
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
     */
    public function handle($message, MiddlewareHandlerInterface $handler): void
    {
        if (!$message instanceof SerializableInterface) {
            throw new MiddlewareException('Message need to implement serializable');
        }

        try {
            $this->scheduler->schedule($message, (new DateTimeImmutable())->add($this->interval));
        } catch (Throwable $exception) {
            throw new MiddlewareException('Could not schedule message', 0, $exception);
        }
    }
}
