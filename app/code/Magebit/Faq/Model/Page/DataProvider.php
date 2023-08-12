<?php

declare(strict_types=1);

namespace Magebit\Faq\Model\Page;

use Magebit\Faq\Api\FaqRepositoryInterface;
use Magebit\Faq\Model\ResourceModel\Faq\Grid\CollectionFactory;
use Magento\Framework\App\RequestInterface;
use Magento\Ui\DataProvider\Modifier\PoolInterface;
use Magento\Ui\DataProvider\ModifierPoolDataProvider;

/**
 * Data provider for FAQ forms.
 */
class DataProvider extends ModifierPoolDataProvider
{
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        PoolInterface $pool,
        CollectionFactory $collectionFactory,
        private readonly FaqRepositoryInterface $faqRepository,
        private readonly RequestInterface $request,
        array $meta = [],
        array $data = [],
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data, $pool);

        $this->collection = $collectionFactory->create();
    }

    /**
     * @return mixed[]
     */
    public function getData(): array
    {
        $faqId = (int) $this->request->getParam($this->getRequestFieldName()) ?: null;

        // If is creation form
        if ($faqId === null) {
            return [];
        }

        $faq = $this->faqRepository->getById($faqId);

        return [
            (string) $faq->getId() => $faq->getAllData(),
        ];
    }
}
