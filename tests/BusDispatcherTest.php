<?php

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
use GrahamCampbell\TestBenchCore\MockeryTrait;
use Illuminate\Container\Container;
use Illuminate\Contracts\Queue\Queue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mockery;
use PHPUnit_Framework_TestCase as TestCase;

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
        $handler = Mockery::mock('StdClass');
        $handler->shouldReceive('handle')->twice()->andReturn('foo');
        $container->instance('AltThree\Foo\BusDispatcherTestBasicCommandHandler', $handler);
        $dispatcher = new Dispatcher($container);
        $dispatcher->mapUsing(function ($command) {
            return Dispatcher::simpleMapping($command, 'AltThree\Tests\Bus', 'AltThree\Foo');
        });

        $result = $dispatcher->dispatch(new BusDispatcherTestBasicCommand());
        $this->assertEquals('foo', $result);

        $result = $dispatcher->dispatch(new BusDispatcherTestBasicCommand());
        $this->assertEquals('foo', $result);
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

        $dispatcher->dispatch(new BusDispatcherTestCustomQueueCommand);
    }

    public function testCommandsThatShouldQueueIsQueuedUsingCustomQueueAndDelay()
    {
        $container = new Container();
        $dispatcher = new Dispatcher($container, function () {
            $mock = Mockery::mock(Queue::class);
            $mock->shouldReceive('laterOn')->once()->with('foo', 10, Mockery::type(BusDispatcherTestSpecificQueueAndDelayCommand::class));

            return $mock;
        });

        $dispatcher->dispatch(new BusDispatcherTestSpecificQueueAndDelayCommand);
    }

    public function testDispatchNowShouldNeverQueue()
    {
        $container = new Container;
        $mock = Mockery::mock(Queue::class);
        $mock->shouldReceive('push')->never();
        $dispatcher = new Dispatcher($container, function () use ($mock) {
            return $mock;
        });

        $dispatcher->dispatch(new BusDispatcherBasicCommand);
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

        $response = $dispatcher->dispatch(new StandAloneCommand);

        $this->assertInstanceOf(StandAloneCommand::class, $response);
    }
}

class BusInjectionStub
{
}

class BusDispatcherTestBasicCommand
{
}

class BusDispatcherBasicCommand
{
    public $name;

    public function __construct($name = null)
    {
        $this->name = $name;
    }

    public function handle(BusInjectionStub $stub)
    {
        //
    }
}

class BusDispatcherTestCustomQueueCommand implements ShouldQueue
{
    public function queue($queue, $command)
    {
        $queue->push($command);
    }
}

class BusDispatcherTestSpecificQueueAndDelayCommand implements ShouldQueue
{
    public $queue = 'foo';
    public $delay = 10;
}

class StandAloneCommand
{
}

class StandAloneHandler
{
    public function handle(StandAloneCommand $command)
    {
        return $command;
    }
}
