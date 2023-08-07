<?php

declare(strict_types=1);

namespace Magebit\Faq\Model;

use Magebit\Faq\Api\Data\FaqInterface;
use Magebit\Faq\Api\FaqManagementInterface;
use Magebit\Faq\Api\FaqRepositoryInterface;

class FaqManagement implements FaqManagementInterface
{
    public function __construct(
        private FaqRepositoryInterface $faqRepository
    ) {
    }

    public function enableFaq(FaqInterface $faq): void
    {
        $faq->setStatus($faq::STATUS_ENABLED);

        $this->faqRepository->save($faq);
    }

    public function disableFaq(FaqInterface $faq): void
    {
        $faq->setStatus($faq::STATUS_DISABLED);

        $this->faqRepository->save($faq);
    }
}
