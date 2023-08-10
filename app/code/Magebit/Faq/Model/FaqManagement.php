<?php

declare(strict_types=1);

namespace Magebit\Faq\Model;

use Magebit\Faq\Api\Data\FaqInterface;
use Magebit\Faq\Api\FaqManagementInterface;

class FaqManagement implements FaqManagementInterface
{
    public function enableFaq(FaqInterface $faq): void
    {
        $faq->setStatus($faq::STATUS_ENABLED);
    }

    public function disableFaq(FaqInterface $faq): void
    {
        $faq->setStatus($faq::STATUS_DISABLED);
    }
}
