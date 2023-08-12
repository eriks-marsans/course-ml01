<?php

declare(strict_types=1);

namespace Magebit\Faq\Block;

use Magebit\Faq\Api\Data\FaqInterface;
use Magebit\Faq\Api\Data\FaqSearchResultsInterface;
use Magebit\Faq\Api\FaqRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Api\SortOrderBuilder;
use Magento\Framework\View\Element\BlockInterface;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

class FaqList extends Template implements BlockInterface
{
    public function __construct(
        private readonly SearchCriteriaBuilder $searchCriteriaBuilder,
        private readonly SortOrderBuilder $sortOrderBuilder,
        private readonly FaqRepositoryInterface $faqRepository,
        Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);
    }

    public function getFaqList(): FaqSearchResultsInterface
    {
        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilter(FaqInterface::STATUS, FaqInterface::STATUS_ENABLED)
            ->addSortOrder($this->sortOrderBuilder
                ->setField(FaqInterface::POSITION)
                ->setDirection(SortOrder::SORT_ASC)
                ->create()
            )
            ->create();

        $faqList = $this->faqRepository->getList($searchCriteria);

        return $faqList;
    }
}
