<?php

declare(strict_types=1);

namespace Magebit\Faq\Controller\Adminhtml\Faq;

use Magebit\Faq\Api\Data\FaqInterface;
use Magebit\Faq\Api\FaqRepositoryInterface;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Throwable;

class Save extends AbstractAction implements HttpPostActionInterface
{
    public function __construct(
        private readonly FaqRepositoryInterface $faqRepository,
        Context $context,
    ) {
        parent::__construct($context);
    }

    public function execute(): Redirect
    {
        $id = (int) $this->getRequest()->getParam(FaqInterface::ID);
        $question = $this->getRequest()->getParam(FaqInterface::QUESTION);
        $answer = $this->getRequest()->getParam(FaqInterface::ANSWER);
        $status = (int) $this->getRequest()->getParam(FaqInterface::STATUS);

        if ($this->isCreationForm()) {
            try {
                $newFaq = $this->faqRepository->createEmpty();

                $newFaq->setQuestion($question);
                $newFaq->setAnswer($answer);
                $newFaq->setStatus($status);

                $this->faqRepository->save($newFaq);

                $this->messageManager->addSuccessMessage(__('You created the FAQ.'));
                return $this->createSuccessResultRedirect($newFaq);
            }
            catch (Throwable) {
                $this->messageManager->addErrorMessage(__('Something went wrong.'));
                return $this->createResultRedirectBack();
            }
        }

        try {
            $faq = $this->faqRepository->getById($id);

            $faq->setQuestion($question);
            $faq->setAnswer($answer);
            $faq->setStatus($status);

            $this->faqRepository->save($faq);

            $this->messageManager->addSuccessMessage(__('You saved the FAQ.'));
            return $this->createSuccessResultRedirect($faq);
        }
        catch (Throwable) {
            $this->messageManager->addErrorMessage(__('Something went wrong.'));
            return $this->createResultRedirectBack();
        }
    }

    /**
     * @return bool True if the request is from a create form, false if it is from an edit form.
     */
    private function isCreationForm(): bool
    {
        return empty($this->getRequest()->getParam(FaqInterface::ID));
    }

    private function createSuccessResultRedirect(FaqInterface $faq): Redirect
    {
        $backParam = $this->getRequest()->getParam('back');

        if ($this->isCreationForm() && $backParam === 'edit') {
            $redirect = $this->createResultRedirect('*/*/edit/', [
                Edit::PARAM_NAME_ID => $faq->getId(),
            ]);
        }
        else if ($backParam === 'edit') {
            $redirect = $this->createResultRedirectBack();
        }
        else {
            $redirect = $this->createResultRedirect('*/*/');
        }

        return $redirect;
    }
}
