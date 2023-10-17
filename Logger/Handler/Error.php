<?php
/**
 * Copyright © Squeezely B.V. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Squeezely\Plugin\Logger\Handler;

use Magento\Framework\Logger\Handler\Base;
use Monolog\Logger;

/**
 * Error logger handler class
 */
class Error extends Base
{

    /**
     * @var int
     */
    protected $loggerType = Logger::ERROR;

    /**
     * @var string
     */
    protected $fileName = '/var/log/squeezely-error.log';
}
