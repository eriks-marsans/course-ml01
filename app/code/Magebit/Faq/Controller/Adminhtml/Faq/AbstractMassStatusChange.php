<?php

declare(strict_types=1);

namespace Magebit\Faq\Controller\Adminhtml\Faq;

use Exception;
use Magebit\Faq\Api\Data\FaqInterface;
use Magebit\Faq\Api\FaqRepositoryInterface;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\Api\Filter;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Phrase;

/**
 * Abstract class for MassDisable and MassEnable.
 */
abstract class AbstractMassStatusChange extends AbstractAction
{
    public function __construct(
        private FaqRepositoryInterface $faqRepository,
        private FilterBuilder $filterBuilder,
        private SearchCriteriaBuilder $searchCriteriaBuilder,
        Context $context,
    ) {
        parent::__construct($context);
    }

    /**
     * @return int One of FaqRepositoryInterface::STATUS_ constants.
     */
    abstract protected function updateFaqStatus(FaqInterface $faq): void;

    abstract protected function getSuccessMessage(): Phrase;

    /**
     * An error when faq request param in not set.
     */
    abstract protected function getFaqsNotFoundErrorMessage(): Phrase;

    abstract protected function getSomethingWentWrongErrorMessage(Exception $exception): Phrase;

    public function execute(): Redirect
    {
        /** @var string[]|null */
        $idList = $this->getRequest()->getParam('selected');

        if ($idList === null) {
            $this->messageManager->addErrorMessage($this->getFaqsNotFoundErrorMessage());

            return $this->createResultRedirectBack();
        }

        if (empty($idList)) {
            return $this->createResultRedirectBack();
        }

        /** @var Filter[] */
        $filterList = [];

        foreach ($idList as $id) {
            $id = (int) $id;
            $filterList[] = $this->createIdFilter($id);
        }

        $searchCriteria = $this->searchCriteriaBuilder->addFilters($filterList)->create();

        try {
            $collection = $this->faqRepository->getList($searchCriteria);

            foreach ($collection->getItems() as $faq) {
                $this->updateFaqStatus($faq);
                $this->faqRepository->save($faq);
            }

            $this->messageManager->addSuccessMessage($this->getSuccessMessage());

            return $this->createResultRedirectBack();
        }
        catch (Exception $exception) {
            $this->messageManager->addErrorMessage($this->getSomethingWentWrongErrorMessage($exception));

            return $this->createResultRedirectBack();
        }
    }

    private function createIdFilter(int $faqId): Filter
    {
        $filter = $this->filterBuilder->create();

        $filter->setField(FaqInterface::ID);
        $filter->setConditionType('eq');
        $filter->setValue($faqId);

        return $filter;
    }
}
