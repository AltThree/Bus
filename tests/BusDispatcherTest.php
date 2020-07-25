<?php

declare(strict_types=1);

/*
 * This file is part of Alt Three Bus.
 *
 * (c) Alt Three Services Limited
 * (c) Taylor Otwell
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AltThree\Tests\Bus;

use AltThree\Bus\Dispatcher;
use AltThree\Tests\Bus\Stubs\BusDispatcherBasicCommand;
use AltThree\Tests\Bus\Stubs\BusDispatcherTestBasicCommand;
use AltThree\Tests\Bus\Stubs\BusDispatcherTestCustomQueueCommand;
use AltThree\Tests\Bus\Stubs\BusInjectionStub;
use AltThree\Tests\Bus\Stubs\BusDispatcherTestSpecificQueueAndDelayCommand;
use AltThree\Tests\Bus\Stubs\Handlers\BusDispatcherTestBasicCommandHandler;
use AltThree\Tests\Bus\Stubs\StandAloneCommand;
use AltThree\Tests\Bus\Stubs\StandAloneHandler;
use GrahamCampbell\TestBenchCore\MockeryTrait;
use Illuminate\Container\Container;
use Illuminate\Contracts\Queue\Queue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mockery;
use PHPUnit\Framework\TestCase;

/**
 * This is the bus dispatcher test class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 * @author Taylor Otwell <taylorotwell@gmail.com>
 */
class BusDispatcherTest extends TestCase
{
    use MockeryTrait;

    public function testBasicDispatchingOfCommandsToHandlers()
    {
        $container = new Container();
        $handler = new BusDispatcherTestBasicCommandHandler();
        $container->instance(BusDispatcherTestBasicCommandHandler::class, $handler);
        $dispatcher = new Dispatcher($container);
        $dispatcher->mapUsing(function ($command) {
            return Dispatcher::simpleMapping($command, 'AltThree\Tests\Bus\Stubs', 'AltThree\Tests\Bus\Stubs\Handlers');
        });

        $result = $dispatcher->dispatch(new BusDispatcherTestBasicCommand());
        $this->assertSame('foo', $result);

        $result = $dispatcher->dispatch(new BusDispatcherTestBasicCommand());
        $this->assertSame('foo', $result);

        $this->assertSame(2, $handler->count);
    }

    public function testCommandsThatShouldQueueIsQueued()
    {
        $container = new Container();
        $dispatcher = new Dispatcher($container, function () {
            $mock = Mockery::mock(Queue::class);
            $mock->shouldReceive('push')->once();

            return $mock;
        });

        $dispatcher->dispatch(Mockery::mock(ShouldQueue::class));
    }

    public function testCommandsThatShouldQueueIsQueuedUsingCustomHandler()
    {
        $container = new Container();
        $dispatcher = new Dispatcher($container, function () {
            $mock = Mockery::mock(Queue::class);
            $mock->shouldReceive('push')->once();

            return $mock;
        });

        $dispatcher->dispatch(new BusDispatcherTestCustomQueueCommand());
    }

    public function testCommandsThatShouldQueueIsQueuedUsingCustomQueueAndDelay()
    {
        $container = new Container();
        $dispatcher = new Dispatcher($container, function () {
            $mock = Mockery::mock(Queue::class);
            $mock->shouldReceive('laterOn')->once()->with('foo', 10, Mockery::type(BusDispatcherTestSpecificQueueAndDelayCommand::class));

            return $mock;
        });

        $dispatcher->dispatch(new BusDispatcherTestSpecificQueueAndDelayCommand());
    }

    public function testDispatchNowShouldNeverQueue()
    {
        $container = new Container();
        $mock = Mockery::mock(Queue::class);
        $mock->shouldReceive('push')->never();
        $dispatcher = new Dispatcher($container, function () use ($mock) {
            return $mock;
        });

        $dispatcher->dispatch(new BusDispatcherBasicCommand());
    }

    public function testDispatcherCanDispatchStandAloneHandler()
    {
        $container = new Container();
        $mock = Mockery::mock(Queue::class);
        $dispatcher = new Dispatcher($container, function () use ($mock) {
            return $mock;
        });

        $dispatcher->map([StandAloneCommand::class => StandAloneHandler::class]);

        $dispatcher->mapUsing(function ($command) {
            return Dispatcher::simpleMapping($command, '', '');
        });

        $response = $dispatcher->dispatch(new StandAloneCommand());

        $this->assertInstanceOf(StandAloneCommand::class, $response);
    }
}
