<?php

declare(strict_types=1);

namespace Magebit\Faq\Model\ResourceModel\Faq;

use Magebit\Faq\Model\Faq;
use Magebit\Faq\Model\ResourceModel\Faq as FaqResource;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(Faq::class, FaqResource::class);
    }
}
