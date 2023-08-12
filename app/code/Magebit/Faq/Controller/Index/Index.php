<?php

declare(strict_types=1);

namespace Magebit\Faq\Controller\Index;

use Magento\Framework\App\ActionInterface;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\View\Result\Page;

class Index implements ActionInterface
{
    public function __construct(
        private readonly PageFactory $pageFactory,
    ) {
    }

    public function execute(): Page
    {
        $page = $this->pageFactory->create();

        return $page;
    }
}
