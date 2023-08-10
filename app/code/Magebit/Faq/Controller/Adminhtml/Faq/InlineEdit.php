<?php

declare(strict_types=1);

namespace Magebit\Faq\Controller\Adminhtml\Faq;

use Magebit\Faq\Api\FaqRepositoryInterface;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\Result\Json;
use Magento\Framework\Controller\Result\JsonFactory;
use Throwable;

class InlineEdit extends AbstractAction implements HttpPostActionInterface
{
    public function __construct(
        private JsonFactory $jsonFactory,
        private FaqRepositoryInterface $faqRepository,
        private \Psr\Log\LoggerInterface $logger,
        Context $context,
    ) {
        parent::__construct($context);
    }

    public function execute()
    {
        /** @var Json */
        $resultJson = $this->jsonFactory->create();

        /** @var mixed[] */
        $faqItems = $this->getRequest()->getParam('items', []);

        if (!($this->getRequest()->getParam('isAjax') && count($faqItems))) {
            return $resultJson->setData([
                'error' => true,
                'messages' => [__('Please correct the data sent.')],
            ]);
        }

        try {
            foreach ($faqItems as $id => $faqItem) {
                $id = (int) $id;

                $faq = $this->faqRepository->getById($id);

                $faq->setQuestion($faqItem[$faq::QUESTION]);
                $faq->setStatus((int) $faqItem[$faq::STATUS]);
                $faq->setPosition((int) $faqItem[$faq::POSITION]);

                $this->faqRepository->save($faq);
            }

            return $resultJson->setData([
                'error' => false,
            ]);
        }
        catch (Throwable) {
            return $resultJson->setData([
                'error' => true,
                'messages' => [__('Something went wrong.')],
            ]);
        }
    }
}
