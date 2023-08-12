<?php

declare(strict_types=1);

namespace Magebit\Faq\Ui\Component\Listing\Column;

use Magebit\Faq\Api\Data\FaqInterface;
use Magebit\Faq\Controller\Adminhtml\Faq\Delete as FaqDeleteAction;
use Magebit\Faq\Controller\Adminhtml\Faq\Edit as FaqEditAction;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

class FaqActions extends Column
{
    private const URL_ROUTE_EDIT = 'magebit_faq/faq/edit';
    private const URL_ROUTE_DELETE = 'magebit_faq/faq/delete';

    public function __construct(
        private readonly UrlInterface $urlBuilder,
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        array $components = [],
        array $data = [],
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * @inheritDoc
     */
    public function prepareDataSource(array $dataSource)
    {
        if (!isset($dataSource['data']['items'])) {
            return $dataSource;
        }

        foreach ($dataSource['data']['items'] as &$item) {
            $id = $item[FaqInterface::ID] ?? null;

            if ($id === null) {
                continue;
            }

            $actionsKey = $this->getData('name');

            $item[$actionsKey]['edit'] = [
                'href' => $this->urlBuilder->getUrl(self::URL_ROUTE_EDIT, [
                    FaqEditAction::PARAM_NAME_ID => $id,
                ]),
                'label' => __('Edit'),
            ];

            $item[$actionsKey]['delete'] = [
                'href' => $this->urlBuilder->getUrl(self::URL_ROUTE_DELETE, [
                    FaqDeleteAction::PARAM_NAME_ID => $id,
                ]),
                'label' => __('Delete'),
                'confirm' => [
                    'title' => __('Confirm'),
                    'message' => __('Are you sure you want to delete record with id "%1"?', $id),
                ],
                'post' => true,
            ];
        }

        return $dataSource;
    }
}
