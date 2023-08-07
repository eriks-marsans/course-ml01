<?php

declare(strict_types=1);

namespace Magebit\Faq\Model;

use Magebit\Faq\Api\Data\FaqSearchResultsInterface;
use Magento\Framework\Api\SearchResults;

class FaqSearchResults extends SearchResults implements FaqSearchResultsInterface
{
    /**
     * @return Faq[]
     */
    public function getItems(): array
    {
        return parent::getItems();
    }

    /**
     * @param Faq[] $faqList
     */
    public function setItems(array $faqList): self
    {
        return parent::setItems($faqList);
    }
}
