<?php

declare(strict_types=1);

namespace Magebit\Faq\Model\ResourceModel;

use Magebit\Faq\Api\Data\FaqInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Faq extends AbstractDb
{
    private const TABLE_NAME = 'faq';
    public const FORMAT_CREATED_AT = 'Y-m-d H:i:s';

    protected function _construct()
    {
        $this->_init(self::TABLE_NAME, FaqInterface::ID);
    }
}
