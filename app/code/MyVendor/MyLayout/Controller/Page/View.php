<?php

declare(strict_types=1);

namespace MyVendor\MyLayout\Controller\Page;

use Magento\Framework\App\ActionInterface;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\View\Result\Page;

class View implements ActionInterface
{
    public function __construct(
        private PageFactory $pageFactory,
    ) {
    }

    /**
     * @return Page
     */
    public function execute()
    {
        $page = $this->pageFactory->create();

        /** @var Template */
        $block = $page->getLayout()->getBlock('myvendor.mylayout.mytemplate');

        $block->setData('myVariable', 'From code');

        return $page;
    }
}
