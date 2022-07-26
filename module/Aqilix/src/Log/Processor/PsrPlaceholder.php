<?php

namespace Aqilix\Log\Processor;

use Laminas\Log\Processor\PsrPlaceholder as LaminasPsrPlaceholder;

/**
 * Overwrite Zend\Log\Processor\PsrPlaceholder
 *
 * @author Dolly Aswin <dolly.aswin@gmail.com>
 */
class PsrPlaceholder extends LaminasPsrPlaceholder
{
    /**
     * @param  array $event
     * @return array
     */
    public function process(array $event)
    {
        $event = parent::process($event);
        $event["extra"] = null;
        return $event;
    }
}
