<?php

declare(strict_types=1);

namespace Magebit\Faq\Controller\Adminhtml\Faq;

use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\ForwardFactory;
use Magento\Backend\Model\View\Result\Forward;

class NewAction extends AbstractAction
{
    public function __construct(
        private readonly ForwardFactory $resultForwardFactory,
        Context $context,
    ) {
        parent::__construct($context);
    }

    public function execute()
    {
        /** @var Forward $resultForward */
        $resultForward = $this->resultForwardFactory->create();
        return $resultForward->forward('edit');
    }
}
