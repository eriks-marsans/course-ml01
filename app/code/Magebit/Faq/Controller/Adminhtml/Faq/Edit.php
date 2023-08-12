<?php

declare(strict_types=1);

namespace Magebit\Faq\Controller\Adminhtml\Faq;

use Magebit\Faq\Api\Data\FaqInterface;
use Magento\Backend\Model\View\Result\Page;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\ResultFactory;

class Edit extends AbstractAction implements HttpGetActionInterface
{
    public const PARAM_NAME_ID = 'faq_id';

    public function execute(): Page
    {
        /** @var Page $page */
        $page = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $page->setActiveMenu('Magebit_Faq::faq');

        if ($this->isCreationForm()) {
            $page->getConfig()->getTitle()->prepend(__('Create FAQ'));

            return $page;
        }

        $page->getConfig()->getTitle()->prepend(__('Edit FAQ'));

        return $page;
    }

    /**
     * @return bool True if the request is from a create form, false if it is from an edit form.
     */
    private function isCreationForm(): bool
    {
        return empty($this->getRequest()->getParam(FaqInterface::ID));
    }
}
