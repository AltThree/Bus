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

use AltThree\Bus\Dispatcher;
use GrahamCampbell\TestBenchCore\MockeryTrait;
use Illuminate\Container\Container;
use Illuminate\Contracts\Queue\Queue;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * This is the bus dispatcher test class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 * @author Taylor Otwell <taylorotwell@gmail.com>
 */
class BusDispatcherTest extends PHPUnit_Framework_TestCase
{
    use MockeryTrait;

    public function testBasicDispatchingOfCommandsToHandlers()
    {
        $container = new Container();
        $handler = Mockery::mock('StdClass');
        $handler->shouldReceive('handle')->once()->andReturn('foo');
        $container->instance('Handler', $handler);
        $dispatcher = new Dispatcher($container);
        $dispatcher->mapUsing(function () {
            return 'Handler@handle';
        });

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

        $dispatcher->dispatch(new BusDispatcherTestCustomQueueCommand());
    }

    public function testCommandsThatShouldQueueIsQueuedUsingCustomQueueAndDelay()
    {
        $container = new Container();
        $dispatcher = new Dispatcher($container, function () {
            $mock = Mockery::mock(Queue::class);
            $mock->shouldReceive('laterOn')->once()->with('foo', 10, Mockery::type('BusDispatcherTestSpecificQueueAndDelayCommand'));

            return $mock;
        });

        $dispatcher->dispatch(new BusDispatcherTestSpecificQueueAndDelayCommand());
    }

    public function testHandlersThatShouldQueueIsQueued()
    {
        $container = new Container();
        $dispatcher = new Dispatcher($container, function () {
            $mock = Mockery::mock(Queue::class);
            $mock->shouldReceive('push')->once();

            return $mock;
        });
        $dispatcher->mapUsing(function () {
            return 'BusDispatcherTestQueuedHandler@handle';
        });

        $dispatcher->dispatch(new BusDispatcherTestBasicCommand());
    }

    public function testDispatchNowShouldNeverQueue()
    {
        $container = new Container();
        $handler = Mockery::mock('StdClass');
        $handler->shouldReceive('handle')->once()->andReturn('foo');
        $container->instance('Handler', $handler);
        $dispatcher = new Dispatcher($container);
        $dispatcher->mapUsing(function () {
            return 'Handler@handle';
        });

        $result = $dispatcher->dispatch(Mockery::mock(ShouldQueue::class));
        $this->assertEquals('foo', $result);
    }

    public function testDispatchShouldCallAfterResolvingIfCommandNotQueued()
    {
        $container = new Container();
        $handler = Mockery::mock('StdClass')->shouldIgnoreMissing();
        $handler->shouldReceive('after')->once();
        $container->instance('Handler', $handler);
        $dispatcher = new Dispatcher($container);
        $dispatcher->mapUsing(function () {
            return 'Handler@handle';
        });

        $dispatcher->dispatch(new BusDispatcherTestBasicCommand(), function ($handler) {
            $handler->after();
        });
    }

    public function testDispatchingFromArray()
    {
        $instance = new Dispatcher(new Container());
        $result = $instance->dispatchFromArray('BusDispatcherTestSelfHandlingCommand', ['firstName' => 'taylor', 'lastName' => 'otwell']);
        $this->assertEquals('taylor otwell', $result);
    }

    public function testMarshallArguments()
    {
        $instance = new Dispatcher(new Container());
        $result = $instance->dispatchFromArray('BusDispatcherTestArgumentMapping', ['flag' => false, 'emptyString' => '']);
        $this->assertTrue($result);
    }
}

class BusDispatcherTestBasicCommand
{
}

class BusDispatcherTestArgumentMapping
{
    public $flag;
    public $emptyString;

    public function __construct($flag, $emptyString)
    {
        $this->flag = $flag;
        $this->emptyString = $emptyString;
    }

    public function handle()
    {
        return true;
    }
}

class BusDispatcherTestSelfHandlingCommand
{
    public $firstName;
    public $lastName;

    public function __construct($firstName, $lastName)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }

    public function handle()
    {
        return $this->firstName.' '.$this->lastName;
    }
}

class BusDispatcherTestQueuedHandler implements ShouldQueue
{
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
