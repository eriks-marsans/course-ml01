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
     * @param Faq[] $items
     */
    public function setItems(array $items): self
    {
        return parent::setItems($items);
    }
}
