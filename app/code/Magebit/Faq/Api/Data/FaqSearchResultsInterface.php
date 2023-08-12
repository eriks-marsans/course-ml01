<?php

declare(strict_types=1);

namespace Magebit\Faq\Api\Data;

use Magento\Framework\Data\SearchResultInterface;

interface FaqSearchResultsInterface extends SearchResultInterface
{
    /**
     * @return FaqInterface[]
     */
    public function getItems(): array;

    /**
     * @param FaqInterface[] $items
     */
    public function setItems(array $items): self;
}
