<?php

declare(strict_types=1);

namespace Magebit\Faq\Api;

use Magebit\Faq\Api\Data\FaqInterface;

interface FaqManagementInterface
{
    public function enableFaq(FaqInterface $faq): void;

    public function disableFaq(FaqInterface $faq): void;
}
