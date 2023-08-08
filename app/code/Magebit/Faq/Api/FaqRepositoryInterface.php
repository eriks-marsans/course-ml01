<?php

declare(strict_types=1);

namespace Magebit\Faq\Api;

use Magebit\Faq\Api\Data\FaqInterface;
use Magebit\Faq\Api\Data\FaqSearchResultsInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

interface FaqRepositoryInterface
{
    /**
     * Create empty FaqInterface object.
     */
    public function createEmpty(): FaqInterface;

    public function save(FaqInterface $faq): FaqInterface;

    public function getById(int $id): FaqInterface;

    public function getList(SearchCriteriaInterface $searchCriteria): FaqSearchResultsInterface;

    public function delete(FaqInterface $faq): void;

    public function deleteById(int $id): void;
}
