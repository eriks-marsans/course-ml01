<?php

declare(strict_types=1);

namespace Learning\Component\Controller\Adminhtml\Grid;

use Magento\Backend\App\Action;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\View\Result\Page as ResultPage;
use Magento\Backend\Model\View\Result\Page;

class Index extends Action implements HttpGetActionInterface
{
    public function execute(): ResultPage
    {
        /** @var Page */
        $page = $this->resultFactory->create(ResultFactory::TYPE_PAGE);

        $page->setActiveMenu('Learning_Component::learning_grid');
        $page->getConfig()->getTitle()->prepend(__('Grid'));

        return $page;
    }
}
