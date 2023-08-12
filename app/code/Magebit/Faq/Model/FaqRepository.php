<?php

declare(strict_types=1);

namespace Magebit\Faq\Model;

use Exception;
use Magebit\Faq\Api\Data\FaqInterface;
use Magebit\Faq\Api\FaqRepositoryInterface;
use Magebit\Faq\Model\ResourceModel\Faq as FaqResource;
use Magebit\Faq\Model\ResourceModel\Faq\Collection;
use Magebit\Faq\Model\ResourceModel\Faq\CollectionFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

class FaqRepository implements FaqRepositoryInterface
{
    public function __construct(
        private readonly FaqResource $faqResource,
        private readonly FaqFactory $faqFactory,
        private readonly CollectionProcessorInterface $collectionProcessor,
        private readonly CollectionFactory $faqCollectionFactory,
        private readonly FaqSearchResultsFactory $faqSearchResultsFactory,
    ) {
    }

    public function createEmpty(): Faq
    {
        return $this->faqFactory->create();
    }

    public function save(FaqInterface $faq): Faq
    {
        if (!($faq instanceof Faq)) {
            $faq = $this->makeFaqFromFaqInterface($faq);
        }

        try {
            $this->faqResource->save($faq);
            $this->faqResource->load($faq, $faq->getId());

            return $faq;
        }
        catch (Exception $exception) {
            throw new CouldNotSaveException(
                __('Could not save the page: %1', $exception->getMessage()),
                $exception
            );
        }
    }

    public function getById(int $faqId): Faq
    {
        /** @var Faq $faq */
        $faq = $this->faqFactory->create();

        $this->faqResource->load($faq, $faqId);

        if ($faq->getId() === null) {
            throw new NoSuchEntityException(__('The FAQ with the "%1" ID doesn\'t exist.', $faqId));
        }

        return $faq;
    }

    public function getList(SearchCriteriaInterface $searchCriteria): FaqSearchResults
    {
        /** @var Collection $collection */
        $collection = $this->faqCollectionFactory->create();

        $this->collectionProcessor->process($searchCriteria, $collection);

        /** @var FaqSearchResults */
        $searchResults = $this->faqSearchResultsFactory->create();

        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }

    public function delete(FaqInterface $faq): void
    {
        if (!($faq instanceof Faq)) {
            $faq = $this->makeFaqFromFaqInterface($faq);
        }

        try {
            $this->faqResource->delete($faq);
        }
        catch (Exception $exception) {
            throw new CouldNotDeleteException(
                __('Could not delete the page: %1', $exception->getMessage()),
                $exception,
            );
        }
    }

    public function deleteById(int $id): void
    {
        $faq = $this->getById($id);

        $this->delete($faq);
    }

    /**
     * Copy all data from the object that implements FaqInterface to the Faq object.
     */
    private function makeFaqFromFaqInterface(FaqInterface $faq): Faq
    {
        // TODO: Implement method.

        throw new \Exception('Please implements FaqRepository::makeFaqFromFaqInterface method');
    }
}
