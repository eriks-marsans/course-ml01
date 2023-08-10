<?php

declare(strict_types=1);

namespace Magebit\Faq\Controller\Adminhtml\Faq;

use Magento\Backend\App\Action;
use Magento\Backend\Model\View\Result\Redirect;

abstract class AbstractAction extends Action
{
    /**
     * @param array<string,string> $params
     */
    protected function createResultRedirect(string $route, array $params = []): Redirect
    {
        /** @var Redirect */
        $resultRedirect = $this->resultRedirectFactory->create();

        return $resultRedirect->setPath($route, $params);
    }

    /**
     * @param array<string,string> $params
     */
    protected function createResultRedirectBack(array $params = []): Redirect
    {
        return $this->createResultRedirect($this->_redirect->getRefererUrl(), $params);
    }
}
