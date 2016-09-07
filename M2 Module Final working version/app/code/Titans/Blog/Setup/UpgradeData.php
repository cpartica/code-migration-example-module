<?php

namespace Titans\Blog\Setup;

use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;


class UpgradeData implements UpgradeDataInterface
{
    /**
     * Sales setup factory
     *
     * @var BlogSetupFactory
     */
    protected $blogSetupFactory;

    /**
     * @var \Magento\Eav\Model\Config
     */
    protected $eavConfig;

    /**
     * @param BlogSetupFactory $blogSetupFactory
     * @param \Magento\Eav\Model\Config $eavConfig
     */
    public function __construct(
        BlogSetupFactory $blogSetupFactory,
        \Magento\Eav\Model\Config $eavConfig
    ) {
        $this->blogSetupFactory = $blogSetupFactory;
        $this->eavConfig = $eavConfig;
    }

    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        /** @var BlogSetup $blogSetup */
        $blogSetup = $this->blogSetupFactory->create(['setup' => $setup]);
        $blogSetup->getDefaultEntities();


        $this->eavConfig->clear();
        $setup->endSetup();
    }
}
