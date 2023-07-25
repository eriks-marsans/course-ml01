<?php

declare(strict_types=1);

namespace Magebit\PageListWidget\Block\Widget;

use Magento\Cms\Api\Data\PageInterface;
use Magento\Cms\Api\PageRepositoryInterface;
use Magento\Framework\Api\Filter;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\Search\FilterGroup;
use Magento\Framework\Api\Search\FilterGroupBuilder;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Widget\Block\BlockInterface;

/**
 * Navigation widget class.
 */
class PageList extends Template implements BlockInterface
{
    private const NAME_TITLE = 'title';
    private const NAME_DISPLAY_MODE = 'display_mode';

    private const DISPLAY_MODE_ALL_PAGES = 'all_pages';
    private const DISPLAY_MODE_SPECIFIC_PAGES = 'specific_pages';

    protected $_template = 'page-list.phtml';

    public function __construct(
        private FilterBuilder $filterBuilder,
        private FilterGroupBuilder $filterGroupBuilder,
        private SearchCriteriaBuilder $searchCriteriaBuilder,
        private PageRepositoryInterface $pageRepository,
        Context $context,
        array $data = [],
    ) {
        parent::__construct($context, $data);
    }

    /**
     * Get the content title.
     */
    public function getTitle(): ?string
    {
        /** @var ?string */
        return $this->getData(self::NAME_TITLE);
    }

    /**
     * Main method that returns a list of pages.
     *
     * @return PageInterface[]
     */
    public function getPages(): array
    {
        /** @var FilterGroup[] */
        $resultFilterGroups = [];

        // Filter for disabled pages.
        $filterIsActive = $this->createFilter(PageInterface::IS_ACTIVE, 'eq', true);
        $resultFilterGroups[] = $this->createFilterGroup($filterIsActive);

        // Filters for specified pages, if necessary.
        if ($this->arePagesSpecific()) {
            /** @var Filter[] */
            $filterIsSelectedList = [];

            foreach ($this->getSelectedPages() as $pageIdentifier) {
                $filterIsSelected = $this->createFilter(PageInterface::IDENTIFIER, 'eq', $pageIdentifier);
                $filterIsSelectedList[] = $filterIsSelected;
            }

            $resultFilterGroups[] = $this->createFilterGroup($filterIsSelectedList);
        }

        $criteria = $this->searchCriteriaBuilder->create();
        $criteria->setFilterGroups($resultFilterGroups);

        return $this->pageRepository->getList($criteria)->getItems();
    }

    /**
     * Returns the URL of the given page.
     */
    public function createPageUrl(PageInterface $page): string
    {
        return $this->getUrl(null, [
            '_direct' => $page->getIdentifier(),
        ]);
    }

    /**
     * Returns one of self::DISPLAY_MODE_ constants.
     */
    private function getDisplayMode(): string
    {
        /** @var string */
        return $this->getData(self::NAME_DISPLAY_MODE);
    }

    /**
     * Is "Specific Pages" field selected.
     */
    private function arePagesSpecific(): bool
    {
        return $this->getDisplayMode() === self::DISPLAY_MODE_SPECIFIC_PAGES;
    }

    /**
     * Get identifiers of selected pages. If "All Pages" field is selected, then will return an empty array.
     *
     * @return string[]
     */
    private function getSelectedPages(): array
    {
        /** @var ?string */
        $selectedPages = $this->getData('selected_pages');

        if ($selectedPages === null) {
            return [];
        }

        return explode(',', $selectedPages);
    }

    /**
     * Create Filter for searching pages.
     *
     * @param string $pageField  One of PageInterface constants.
     * @param string $conditionType  Accepted values - 'eq' (equal), 'neq' (not equal).
     * @param mixed $fieldValue  Page field value.
     */
    private function createFilter(string $pageField, string $conditionType, mixed $fieldValue): Filter
    {
        $filter = $this->filterBuilder->create();

        $filter->setField($pageField);
        $filter->setConditionType($conditionType);
        $filter->setValue($fieldValue);

        return $filter;
    }

    /**
     * Create FilterGroup for searching pages.
     *
     * @param Filter|Filter[] $filters
     */
    private function createFilterGroup(Filter|array $filters): FilterGroup
    {
        if (!is_array($filters)) {
            $filters = [$filters];
        }

        /** @var FilterGroup */
        $filterGroup = $this->filterGroupBuilder->create();

        $filterGroup->setFilters($filters);

        return $filterGroup;
    }
}
