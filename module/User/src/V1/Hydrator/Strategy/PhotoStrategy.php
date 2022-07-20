<?php

namespace User\V1\Hydrator\Strategy;

use Laminas\Hydrator\Strategy\StrategyInterface;

class PhotoStrategy implements StrategyInterface
{
    /**
     * @var array
     */
    protected $config;

    /**
     * @param  array  $config
     */
    public function __construct($config)
    {
        $this->config = $config;
    }

    /**
     * Converts the given value so that it can be extracted by the hydrator.
     *
     * @param  mixed $value The original value.
     * @param  object $object (optional) The original object for context.
     * @return mixed Returns the value that should be extracted.
     * @throws \RuntimeException If object os not a User
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function extract($value, $object = null)
    {
        $photo = null;
        if (!empty($value)) {
            $photo = $this->config['base_url'] . '/' . $this->config['bucket'] . '/' . basename($value);
        }

        return $photo;
    }

    /**
     * Converts the given value so that it can be hydrated by the hydrator.
     *
     * @param  mixed $value The original value.
     * @param  array $data (optional) The original data for context.
     * @return mixed Returns the value that should be hydrated.
     * @throws \InvalidArgumentException
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function hydrate($value, array $data = null)
    {
        $photo = null;
        if (is_array($value) && isset($value['tmp_name'])) {
            $photo = basename($value['tmp_name']);
        } else {
            $photo = basename($value);
        }

        return $photo;
    }
}
