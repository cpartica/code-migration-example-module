<?php

namespace Titans\Blog\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;


/**
 * @codeCoverageIgnore
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class InstallData implements InstallDataInterface
{
    /**
     * Blog setup factory
     *
     * @var BlogSetupFactory
     */
    protected $blogSetupFactory;

    /**
     * Blog setup factory
     *
     * @var \Magento\Eav\Model\Config
     */
    protected $config;

    /**
     * @param BlogSetupFactory $setupFactory
     */
    public function __construct(
        BlogSetupFactory $setupFactory,
        \Magento\Eav\Model\Config $config
    ) {
        $this->blogSetupFactory = $setupFactory;
        $this->config = $config;
    }

    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        /** @var BlogSetup $installer */
        $installer = $this->blogSetupFactory->create(['setup' => $setup]);

        /**
         * Prepare database before module installation
         */
        $installer->installEntities();
        $this->config->clear();


    }
}
