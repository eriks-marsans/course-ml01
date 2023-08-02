<?php

declare(strict_types=1);

namespace Learning\DataPatch\Setup\Patch\Data;

use Magento\Cms\Api\Data\PageInterfaceFactory;
use Magento\Cms\Api\PageRepositoryInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchRevertableInterface;

class CreateCMSPage implements DataPatchInterface, PatchRevertableInterface
{
    private const KEY_IDENTIFIER = 1;
    private const KEY_TITLE = 2;
    private const KEY_CONTENT = 3;

    public function __construct(
        private ModuleDataSetupInterface $moduleDataSetup,
        private PageRepositoryInterface $pageRepository,
        private PageInterfaceFactory $pageFactory,
    ) {
    }

    /**
     * @inheritdoc
     */
    public function apply(): void
    {
        $data = [
            [ self::KEY_IDENTIFIER => 'test-1', self::KEY_TITLE => 'Test Title 1', self::KEY_CONTENT => 'Test Content 1' ],
            [ self::KEY_IDENTIFIER => 'test-2', self::KEY_TITLE => 'Test Title 2', self::KEY_CONTENT => 'Test Content 2' ],
            [ self::KEY_IDENTIFIER => 'test-3', self::KEY_TITLE => 'Test Title 3', self::KEY_CONTENT => 'Test Content 3' ],
        ];

        $this->moduleDataSetup->getConnection()->startSetup();

        try {
            foreach ($data as $pageData) {
                $page = $this->pageFactory->create();

                $page->setIdentifier($pageData[self::KEY_IDENTIFIER]);
                $page->setTitle($pageData[self::KEY_TITLE]);
                $page->setContent($pageData[self::KEY_CONTENT]);

                $this->pageRepository->save($page);
            }
        } catch (LocalizedException $e) {
            echo $e->getMessage();
        }

        $this->moduleDataSetup->getConnection()->endSetup();
    }

    /**
     * @inheritdoc
     */
    public static function getDependencies(): array
    {
        return [];
    }

    public function revert(): void
    {
        $this->moduleDataSetup->getConnection()->startSetup();
        $this->moduleDataSetup->getConnection()->endSetup();
    }

    /**
     * @inheritdoc
     */
    public function getAliases(): array
    {
        return [];
    }
}
