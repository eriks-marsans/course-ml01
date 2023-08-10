<?php

declare(strict_types=1);

namespace Magebit\Faq\Controller\Adminhtml\Faq;

use Exception;
use Magebit\Faq\Api\FaqRepositoryInterface;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Action\HttpPostActionInterface;

class MassDelete extends AbstractAction implements HttpPostActionInterface
{
    public function __construct(
        private FaqRepositoryInterface $faqRepository,
        Context $context,
    ) {
        parent::__construct($context);
    }

    public function execute(): Redirect
    {
        /** @var string[]|null */
        $idList = $this->getRequest()->getParam('selected');

        if ($idList === null) {
            $this->messageManager->addErrorMessage(__('We can\'t find FAQs to delete.'));

            return $this->createResultRedirectBack();
        }

        try {
            foreach ($idList as $id) {
                $id = (int) $id;

                $this->faqRepository->deleteById($id);
            }

            $this->messageManager->addSuccessMessage(__('The FAQs has been deleted.'));

            return $this->createResultRedirectBack();
        }
        catch (Exception) {
            $this->messageManager->addErrorMessage(__('Something went wrong. Selected FAQs are not deleted.'));

            return $this->createResultRedirectBack();
        }
    }
}
