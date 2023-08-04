<?php

declare(strict_types=1);

namespace Learning\Layout\Controller\Json;

use Magento\Framework\App\ActionInterface;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Controller\Result\Json;

class Index implements ActionInterface
{
    public function __construct(
        private JsonFactory $jsonFactory
    ) {
    }

    /**
     * @return Json
     */
    public function execute()
    {
        $json = $this->jsonFactory->create();

        $json->setData([
            'hihihi' => 'mimimi'
        ]);

        return $json;
    }
}
