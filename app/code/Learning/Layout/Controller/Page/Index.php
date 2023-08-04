<?php

declare(strict_types=1);

namespace Learning\Layout\Controller\Page;

use Magento\Framework\App\ActionInterface;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\View\Result\Page;

class Index implements ActionInterface
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
        $block = $page->getLayout()->getBlock('learning.layout.simple');

        $block->setData('simpleVariable', 'From code');

        return $page;
    }
}
