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

namespace AltThree\Bus;

use Illuminate\Bus\Dispatcher as IlluminateDispatcher;

/**
 * This is the dispatcher class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 * @author Taylor Otwell <taylorotwell@gmail.com>
 */
class Dispatcher extends IlluminateDispatcher
{
    /**
     * The fallback mapping callback.
     *
     * @var callable|null
     */
    protected $mapper;

    /**
     * Determine if the given command has a handler.
     *
     * @param mixed $command
     *
     * @return bool
     */
    public function hasCommandHandler($command)
    {
        $class = get_class($command);

        if (isset($this->handlers[$class])) {
            return true;
        }

        $callback = $this->mapper;

        if (!$callback || method_exists($command, 'handle')) {
            return false;
        }

        $this->handlers[$class] = $callback($command);

        return true;
    }

    /**
     * Register a fallback mapper callback.
     *
     * @param callable|null $mapper
     *
     * @return void
     */
    public function mapUsing(callable $mapper = null)
    {
        $this->mapper = $mapper;
    }

    /**
     * Map the command to a handler within a given root namespace.
     *
     * @param mixed  $command
     * @param string $commandNamespace
     * @param string $handlerNamespace
     *
     * @return string
     */
    public static function simpleMapping($command, $commandNamespace, $handlerNamespace)
    {
        $command = str_replace($commandNamespace, '', get_class($command));

        return $handlerNamespace.'\\'.trim($command, '\\').'Handler';
    }
}
