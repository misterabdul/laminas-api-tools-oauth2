<?php

namespace Aqilix\Service;

use Symfony\Component\Process\Exception\InvalidArgumentException;
use Symfony\Component\Process\Exception\LogicException;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\ProcessUtils;

class ProcessBuilder
{
    /**
     * @var array
     */
    private $arguments;

    /**
     * @var string|null
     */
    private $cwd;

    /**
     * @var array
     */
    private $env = [];

    /**
     * @var mixed
     */
    private $input;

    /**
     * @var int|float|null
     */
    private $timeout = 60;

    /**
     * @var array
     */
    private $options;

    /**
     * @var array
     */
    private $prefix = [];

    /**
     * @var bool
     */
    private $outputDisabled = false;

    /**
     * @param  array  $arguments
     */
    public function __construct($arguments = [])
    {
        $this->arguments = $arguments;
    }

    /**
     * @param  string  $argument
     * @return self
     */
    public function add($argument)
    {
        $this->arguments[] = $argument;

        return $this;
    }

    /**
     * @param  string|array  $prefix
     * @return self
     */
    public function setPrefix($prefix)
    {
        $this->prefix = \is_array($prefix) ? $prefix : [$prefix];

        return $this;
    }

    /**
     * @param  array  $arguments
     * @return self
     */
    public function setArguments($arguments)
    {
        $this->arguments = $arguments;

        return $this;
    }

    /**
     * @param  string|null  $cwd
     * @return self
     */
    public function setWorkingDirectory($cwd)
    {
        $this->cwd = $cwd;

        return $this;
    }

    /**
     * @param  string       $name
     * @param  string|null  $value
     * @return self
     */
    public function setEnv($name, $value)
    {
        $this->env[$name] = $value;

        return $this;
    }

    /**
     * @param  array  $variables
     * @return self
     */
    public function addEnvironmentVariables($variables)
    {
        $this->env = array_replace($this->env, $variables);

        return $this;
    }

    /**
     * @param  resource|string|int|float|bool|\Traversable|null  $input
     * @return self
     * @throws \Symfony\Component\Process\Exception\InvalidArgumentException
     */
    public function setInput($input)
    {
        $this->input = ProcessUtils::validateInput(__METHOD__, $input);

        return $this;
    }

    /**
     * @param  int|float|null  $timeout
     * @return self
     * @throws \Symfony\Component\Process\Exception\InvalidArgumentException
     */
    public function setTimeout($timeout)
    {
        if (null === $timeout) {
            $this->timeout = null;

            return $this;
        }

        $timeout = (float) $timeout;

        if ($timeout < 0) {
            throw new InvalidArgumentException('The timeout value must be a valid positive integer or float number.');
        }

        $this->timeout = $timeout;

        return $this;
    }

    /**
     * @param  string  $name
     * @param  string  $value
     * @return self
     */
    public function setOption($name, $value)
    {
        $this->options[$name] = $value;

        return $this;
    }

    /**
     * @return self
     */
    public function disableOutput()
    {
        $this->outputDisabled = true;

        return $this;
    }

    /**
     * @return self
     */
    public function enableOutput()
    {
        $this->outputDisabled = false;

        return $this;
    }

    /**
     * @return \Symfony\Component\Process\Process
     * @throws \Symfony\Component\Process\Exception\LogicException
     */
    public function getProcess()
    {
        if (0 === \count($this->prefix) && 0 === \count($this->arguments)) {
            throw new LogicException('You must add() command arguments before calling getProcess().');
        }

        $arguments = array_merge($this->prefix, $this->arguments);
        $process = new Process(
            $arguments,
            $this->cwd,
            $this->env,
            $this->input,
            $this->timeout,
            $this->options
        );

        if ($this->outputDisabled) {
            $process->disableOutput();
        }

        return $process;
    }
}
