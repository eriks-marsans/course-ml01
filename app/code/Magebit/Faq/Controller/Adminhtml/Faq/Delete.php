<?php

declare(strict_types=1);

namespace Magebit\Faq\Controller\Adminhtml\Faq;

use Exception;
use Magebit\Faq\Api\FaqRepositoryInterface;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Action\HttpPostActionInterface;

class Delete extends AbstractAction implements HttpPostActionInterface
{
    public const PARAM_NAME_ID = 'faq_id';

    public function __construct(
        private FaqRepositoryInterface $faqRepository,
        Context $context,
    ) {
        parent::__construct($context);
    }

    public function execute(): Redirect
    {
        $id = (int) $this->getRequest()->getParam(self::PARAM_NAME_ID) ?: null;

        if ($id === null) {
            $this->messageManager->addErrorMessage(__('We can\'t find a FAQ to delete.'));

            return $this->createResultRedirectBack();
        }

        try {
            $this->faqRepository->deleteById($id);

            $this->messageManager->addSuccessMessage(__('The FAQ has been deleted.'));

            return $this->createResultRedirectBack();
        }
        catch (Exception) {
            $this->messageManager->addErrorMessage(__('Something went wrong. FAQ is not deleted.'));

            return $this->createResultRedirectBack();
        }
    }
}
