<?php

declare(strict_types=1);

namespace Magebit\Faq\Controller\Adminhtml\Faq;

use Exception;
use Magebit\Faq\Api\Data\FaqInterface;
use Magebit\Faq\Api\FaqManagementInterface;
use Magebit\Faq\Api\FaqRepositoryInterface;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Phrase;

class MassDisable extends AbstractMassStatusChange implements HttpPostActionInterface
{
    public function __construct(
        private FaqManagementInterface $faqManagement,
        FaqRepositoryInterface $faqRepository,
        FilterBuilder $filterBuilder,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        Context $context,
    ) {
        parent::__construct(
            $faqRepository,
            $filterBuilder,
            $searchCriteriaBuilder,
            $context,
        );
    }

    protected function updateFaqStatus(FaqInterface $faq): void
    {
        $this->faqManagement->disableFaq($faq);
    }

    protected function getSuccessMessage(): Phrase
    {
        return __('The FAQs has been disabled.');
    }

    protected function getFaqsNotFoundErrorMessage(): Phrase
    {
        return __('We can\'t find FAQs to disable.');
    }

    protected function getSomethingWentWrongErrorMessage(Exception $exception): Phrase
    {
        return __('Something went wrong. Selected FAQs are not disabled');
    }
}
