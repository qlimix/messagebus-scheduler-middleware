<?php declare(strict_types=1);

namespace Qlimix\Tests\MessageBus\Messagebus\Middleware;

use DateInterval;
use DateTimeImmutable;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Qlimix\Message\Scheduler\Exception\SchedulerException;
use Qlimix\Message\Scheduler\SchedulerInterface;
use Qlimix\MessageBus\MessageBus\Middleware\Exception\MiddlewareException;
use Qlimix\MessageBus\MessageBus\Middleware\MiddlewareHandlerInterface;
use Qlimix\MessageBus\MessageBus\Middleware\SchedulerMiddleware;
use Qlimix\Serializable\SerializableInterface;

final class SchedulerMiddlewareTest extends TestCase
{
    /** @var MockObject */
    private $scheduler;

    protected function setUp(): void
    {
        $this->scheduler = $this->createMock(SchedulerInterface::class);
    }

    /**
     * @test
     */
    public function shouldSchedule(): void
    {
        $interval = new DateInterval('P1DT1S');

        $this->scheduler->expects($this->once())
            ->method('schedule')
            ->with(
                $this->callback(static function ($message) {
                    return true;
                }),
                $this->callback(static function (DateTimeImmutable $dateTime) use (&$interval) {
                    return $dateTime->diff(new DateTimeImmutable())->days === 1;
                })
            );

        $scheduler = new SchedulerMiddleware($this->scheduler, $interval);

        $message = $this->createMock(SerializableInterface::class);
        $handler = $this->createMock(MiddlewareHandlerInterface::class);

        $scheduler->handle($message, $handler);
    }

    /**
     * @test
     */
    public function shouldThrowsOnScheduleFailure(): void
    {
        $interval = new DateInterval('P1DT1S');

        $this->scheduler->expects($this->once())
            ->method('schedule')
            ->willThrowException(new SchedulerException());

        $scheduler = new SchedulerMiddleware($this->scheduler, $interval);

        $message = $this->createMock(SerializableInterface::class);
        $handler = $this->createMock(MiddlewareHandlerInterface::class);

        $this->expectException(MiddlewareException::class);

        $scheduler->handle($message, $handler);
    }

    /**
     * @test
     */
    public function shouldThrowsOnNoneSerializableMessage(): void
    {
        $interval = new DateInterval('P1DT1S');

        $this->scheduler->expects($this->never())
            ->method('schedule');

        $scheduler = new SchedulerMiddleware($this->scheduler, $interval);

        $handler = $this->createMock(MiddlewareHandlerInterface::class);

        $this->expectException(MiddlewareException::class);

        $scheduler->handle('foobar', $handler);
    }
}
