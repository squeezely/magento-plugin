<?php
/**
 * Copyright © Squeezely B.V. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Squeezely\Plugin\Controller\Adminhtml\Logger;

use Magento\Backend\App\Action;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\Result\Json;
use Magento\Framework\Controller\Result\JsonFactory;
use Squeezely\Plugin\Api\Log\RepositoryInterface as LogRepository;

/**
 * Download controller for log files
 */
class Stream extends Action
{

    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    public const ADMIN_RESOURCE = 'Squeezely_Plugin::config';

    /**
     * @var JsonFactory
     */
    private $resultJsonFactory;
    /**
     * @var LogRepository
     */
    private $logRepository;
    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * @param Action\Context $context
     * @param JsonFactory $resultJsonFactory
     * @param LogRepository $logRepository
     */
    public function __construct(
        Action\Context $context,
        JsonFactory $resultJsonFactory,
        LogRepository $logRepository
    ) {
        $this->resultJsonFactory = $resultJsonFactory;
        $this->request = $context->getRequest();
        $this->logRepository = $logRepository;
        parent::__construct($context);
    }

    /**
     * @return Json
     */
    public function execute(): Json
    {
        $resultJson = $this->resultJsonFactory->create();
        $type = $this->request->getParam('type') == 'error' ? 'error' : 'debug';
        $logFilePath = $this->logRepository->getLogFilePath($type);

        if ($logFilePath && $result = $this->logRepository->getLogEntriesAsArray($logFilePath)) {
            $result = ['result' => $result];
        } else {
            $result = __('Log is empty');
        }

        return $resultJson->setData($result);
    }
}
