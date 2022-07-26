<?php

namespace User\Mapper;

use Aqilix\ORM\Mapper\MapperFactory as AbstractMapperFactory;

/**
 * Mapper with Doctrine support
 *
 * @author Dolly Aswin <dolly.aswin@gmail.com>
 */
class MapperFactory extends AbstractMapperFactory
{
    /**
     * @var string
     */
    protected $mapperPrefix = 'User\\Mapper';
}
