<?php

declare(strict_types=1);

namespace Magebit\Faq\Controller\Adminhtml\Faq;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Backend\Model\View\Result\Page;

class Index extends AbstractAction implements HttpGetActionInterface
{
    public function execute(): Page
    {
        /** @var Page */
        $page = $this->resultFactory->create(ResultFactory::TYPE_PAGE);

        $page->setActiveMenu('Magebit_Faq::faq');
        $page->getConfig()->getTitle()->prepend(__('Frequently Asked Questions'));

        return $page;
    }
}
