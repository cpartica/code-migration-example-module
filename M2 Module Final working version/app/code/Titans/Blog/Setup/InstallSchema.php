<?php

namespace Titans\Blog\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

/**
 * @codeCoverageIgnore
 */
class InstallSchema implements InstallSchemaInterface
{
    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        /**
         * Prepare database before module installation
         */
        $setup->startSetup();
        $baseTableName = $setup->getTable('titans_blog_post_entity');

        /**
         * Create table 'titans_testeav/entity'
         */
        $table = $setup->getConnection()
            ->newTable($baseTableName)
            ->addColumn('entity_id',  \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, null,array(
                'identity' => true,
                'nullable' => false,
                'primary' => true,
                'unsigned' => true,
            ), 'Entity Id')
            ->addColumn('entity_type_id',  \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT, null, array(
                'unsigned' => true,
                'nullable' => false,
                'default' => '0',
            ), 'Entity Type Id')
            ->addColumn('attribute_set_id',  \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT, null, array(
                'unsigned' => true,
                'nullable' => false,
                'default' => '0',
            ), 'Attribute Set Id')
            ->addColumn('increment_id',  \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, 50, array(
                'nullable' => false,
                'default' => '',
            ), 'Increment Id')
            ->addColumn('store_id',  \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT, null, array(
                'unsigned' => true,
                'nullable' => false,
                'default' => '0',
            ), 'Store Id')
            ->addColumn('created_at',  \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP, null, array(
                'nullable' => false,
            ), 'Created At')
            ->addColumn('updated_at',  \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP, null, array(
                'nullable' => false,
            ), 'Updated At')
            ->addColumn('is_active',  \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT, null, array(
                'unsigned' => true,
                'nullable' => false,
                'default' => '1',
            ), 'Defines Is Entity Active')
            ->addIndex($setup->getIdxName($baseTableName, array('entity_type_id')),
                array('entity_type_id'))
            ->addIndex($setup->getIdxName($baseTableName, array('store_id')),
                array('store_id'))
            ->addForeignKey(
                $setup->getFkName($baseTableName, 'entity_type_id', 'eav_entity_type', 'entity_type_id'),
                'entity_type_id',
                $setup->getTable('eav_entity_type'),
                'entity_type_id',
                \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
            )
            ->addForeignKey(
                $setup->getFkName($baseTableName, 'store_id', 'store', 'store_id'),
                'store_id', $setup->getTable('store'),
                'store_id',
                \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
            )
            ->setComment('Post Entity Main Table');
        $setup->getConnection()->createTable($table);


        /*
        * Datetime entity table for blog post
        */
        $table = $setup->getConnection()
            ->newTable($setup->getTable('titans_blog_post_entity_datetime'))
            ->addColumn('value_id', \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, null, array(
                'identity'  => true,
                'nullable'  => false,
                'primary'   => true,
            ), 'Value Id')
            ->addColumn('entity_type_id', \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT, null, array(
                'unsigned'  => true,
                'nullable'  => false,
                'default'   => '0',
            ), 'Entity Type Id')
            ->addColumn('attribute_id', \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT, null, array(
                'unsigned'  => true,
                'nullable'  => false,
                'default'   => '0',
            ), 'Attribute Id')
            ->addColumn('entity_id', \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, null, array(
                'unsigned'  => true,
                'nullable'  => false,
                'default'   => '0',
            ), 'Entity Id')
            ->addColumn('value', \Magento\Framework\DB\Ddl\Table::TYPE_DATETIME, null, array(
                'nullable'  => true,
                'default' => NULL
            ), 'Value')
            ->addIndex(
                $setup->getIdxName(
                    'titans_blog_post_entity_datetime',
                    array('entity_id', 'attribute_id'),
                    \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE
                ),
                array('entity_id', 'attribute_id'),
                array('type' => \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE))
            ->addIndex($setup->getIdxName('titans_blog_post_entity_datetime', array('entity_type_id')),
                array('entity_type_id'))
            ->addIndex($setup->getIdxName('titans_blog_post_entity_datetime', array('attribute_id')),
                array('attribute_id'))
            ->addIndex($setup->getIdxName('titans_blog_post_entity_datetime', array('entity_id')),
                array('entity_id'))
            ->addIndex($setup->getIdxName('titans_blog_post_entity_datetime', array('entity_id', 'attribute_id', 'value')),
                array('entity_id', 'attribute_id', 'value'))
            ->addForeignKey(
                $setup->getFkName('titans_blog_post_entity_datetime', 'attribute_id', 'eav_attribute', 'attribute_id'),
                'attribute_id', $setup->getTable('eav_attribute'), 'attribute_id',
                \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE)
            ->addForeignKey(
                $setup->getFkName('titans_blog_post_entity_datetime', 'entity_id', 'titans_blog_post_entity_datetime', 'entity_id'),
                'entity_id', $setup->getTable('titans_blog_post_entity_datetime'), 'entity_id',
                \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE)
            ->addForeignKey(
                $setup->getFkName(
                    'titans_blog_post_entity_datetime',
                    'entity_type_id',
                    'eav_entity_type',
                    'entity_type_id'
                ),
                'entity_type_id', $setup->getTable('eav_entity_type'), 'entity_type_id',
                \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE)
            ->setComment('Blog Post Entity Datetime');
        $setup->getConnection()->createTable($table);

        /*
         * Decimal entity table for blog post
         */
        $table = $setup->getConnection()
            ->newTable($setup->getTable('titans_blog_post_entity_decimal'))
            ->addColumn('value_id', \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, null, array(
                'identity'  => true,
                'nullable'  => false,
                'primary'   => true,
            ), 'Value Id')
            ->addColumn('entity_type_id', \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT, null, array(
                'unsigned'  => true,
                'nullable'  => false,
                'default'   => '0',
            ), 'Entity Type Id')
            ->addColumn('attribute_id', \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT, null, array(
                'unsigned'  => true,
                'nullable'  => false,
                'default'   => '0',
            ), 'Attribute Id')
            ->addColumn('entity_id', \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, null, array(
                'unsigned'  => true,
                'nullable'  => false,
                'default'   => '0',
            ), 'Entity Id')
            ->addColumn('value', \Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL, '12,4', array(
                'nullable'  => false,
                'default'   => '0.0000',
            ), 'Value')
            ->addIndex(
                $setup->getIdxName(
                    'titans_blog_post_entity_decimal',
                    array('entity_id', 'attribute_id'),
                    \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE
                ),
                array('entity_id', 'attribute_id'), array('type' => \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE))
            ->addIndex($setup->getIdxName('titans_blog_post_entity_decimal', array('entity_type_id')),
                array('entity_type_id'))
            ->addIndex($setup->getIdxName('titans_blog_post_entity_decimal', array('attribute_id')),
                array('attribute_id'))
            ->addIndex($setup->getIdxName('titans_blog_post_entity_decimal', array('entity_id')),
                array('entity_id'))
            ->addIndex($setup->getIdxName('titans_blog_post_entity_decimal', array('entity_id', 'attribute_id', 'value')),
                array('entity_id', 'attribute_id', 'value'))
            ->addForeignKey($setup->getFkName('titans_blog_post_entity_decimal', 'attribute_id', 'eav_attribute', 'attribute_id'),
                'attribute_id', $setup->getTable('eav_attribute'), 'attribute_id',
                \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE)
            ->addForeignKey($setup->getFkName('titans_blog_post_entity_decimal', 'entity_id', 'customer/entity', 'entity_id'),
                'entity_id', $setup->getTable('titans_blog_post_entity'), 'entity_id',
                \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE)
            ->addForeignKey(
                $setup->getFkName('titans_blog_post_entity_decimal', 'entity_type_id', 'eav_entity_type', 'entity_type_id'),
                'entity_type_id', $setup->getTable('eav_entity_type'), 'entity_type_id',
                \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE)
            ->setComment('Blog Post Entity Decimal');
        $setup->getConnection()->createTable($table);

        /*
         * Integer entity table for blog post
         */
        $table = $setup->getConnection()
            ->newTable($setup->getTable('titans_blog_post_entity_int'))
            ->addColumn('value_id', \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, null, array(
                'identity'  => true,
                'nullable'  => false,
                'primary'   => true,
            ), 'Value Id')
            ->addColumn('entity_type_id', \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT, null, array(
                'unsigned'  => true,
                'nullable'  => false,
                'default'   => '0',
            ), 'Entity Type Id')
            ->addColumn('attribute_id', \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT, null, array(
                'unsigned'  => true,
                'nullable'  => false,
                'default'   => '0',
            ), 'Attribute Id')
            ->addColumn('entity_id', \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, null, array(
                'unsigned'  => true,
                'nullable'  => false,
                'default'   => '0',
            ), 'Entity Id')
            ->addColumn('value', \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, null, array(
                'nullable'  => false,
                'default'   => '0',
            ), 'Value')
            ->addIndex(
                $setup->getIdxName(
                    'titans_blog_post_entity_int',
                    array('entity_id', 'attribute_id'),
                    \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE
                ),
                array('entity_id', 'attribute_id'), array('type' => \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE))
            ->addIndex($setup->getIdxName('titans_blog_post_entity_int', array('entity_type_id')),
                array('entity_type_id'))
            ->addIndex($setup->getIdxName('titans_blog_post_entity_int', array('attribute_id')),
                array('attribute_id'))
            ->addIndex($setup->getIdxName('titans_blog_post_entity_int', array('entity_id')),
                array('entity_id'))
            ->addIndex($setup->getIdxName('titans_blog_post_entity_int', array('entity_id', 'attribute_id', 'value')),
                array('entity_id', 'attribute_id', 'value'))
            ->addForeignKey($setup->getFkName('titans_blog_post_entity_int', 'attribute_id', 'eav_attribute', 'attribute_id'),
                'attribute_id', $setup->getTable('eav_attribute'), 'attribute_id',
                \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE)
            ->addForeignKey($setup->getFkName('titans_blog_post_entity_int', 'entity_id', 'customer/entity', 'entity_id'),
                'entity_id', $setup->getTable('titans_blog_post_entity'), 'entity_id',
                \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE)
            ->addForeignKey($setup->getFkName('titans_blog_post_entity_int', 'entity_type_id', 'eav_entity_type', 'entity_type_id'),
                'entity_type_id', $setup->getTable('eav_entity_type'), 'entity_type_id',
                \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE)
            ->setComment('Blog Post Entity Int');
        $setup->getConnection()->createTable($table);

        /*
         * Text entity table for blog post
         */
        $table = $setup->getConnection()
            ->newTable($setup->getTable('titans_blog_post_entity_text'))
            ->addColumn('value_id', \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, null, array(
                'identity'  => true,
                'nullable'  => false,
                'primary'   => true,
            ), 'Value Id')
            ->addColumn('entity_type_id', \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT, null, array(
                'unsigned'  => true,
                'nullable'  => false,
                'default'   => '0',
            ), 'Entity Type Id')
            ->addColumn('attribute_id', \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT, null, array(
                'unsigned'  => true,
                'nullable'  => false,
                'default'   => '0',
            ), 'Attribute Id')
            ->addColumn('entity_id', \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, null, array(
                'unsigned'  => true,
                'nullable'  => false,
                'default'   => '0',
            ), 'Entity Id')
            ->addColumn('value', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, '64k', array(
                'nullable'  => false,
            ), 'Value')
            ->addIndex(
                $setup->getIdxName(
                    'titans_blog_post_entity_text',
                    array('entity_id', 'attribute_id'),
                    \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE
                ),
                array('entity_id', 'attribute_id'), array('type' => \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE))
            ->addIndex($setup->getIdxName('titans_blog_post_entity_text', array('entity_type_id')),
                array('entity_type_id'))
            ->addIndex($setup->getIdxName('titans_blog_post_entity_text', array('attribute_id')),
                array('attribute_id'))
            ->addIndex($setup->getIdxName('titans_blog_post_entity_text', array('entity_id')),
                array('entity_id'))
            ->addForeignKey($setup->getFkName('titans_blog_post_entity_text', 'attribute_id', 'eav_attribute', 'attribute_id'),
                'attribute_id', $setup->getTable('eav_attribute'), 'attribute_id',
                \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE)
            ->addForeignKey($setup->getFkName('titans_blog_post_entity_text', 'entity_id', 'customer/entity', 'entity_id'),
                'entity_id', $setup->getTable('titans_blog_post_entity'), 'entity_id',
                \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE)
            ->addForeignKey(
                $setup->getFkName('titans_blog_post_entity_text', 'entity_type_id', 'eav_entity_type', 'entity_type_id'),
                'entity_type_id', $setup->getTable('eav_entity_type'), 'entity_type_id',
                \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE)
            ->setComment('Blog Post Entity Text');
        $setup->getConnection()->createTable($table);

        /*
         * Varchar entity table for blog post
         */
        $table = $setup->getConnection()
            ->newTable($setup->getTable('titans_blog_post_entity_varchar'))
            ->addColumn('value_id', \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, null, array(
                'identity'  => true,
                'nullable'  => false,
                'primary'   => true,
            ), 'Value Id')
            ->addColumn('entity_type_id', \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT, null, array(
                'unsigned'  => true,
                'nullable'  => false,
                'default'   => '0',
            ), 'Entity Type Id')
            ->addColumn('attribute_id', \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT, null, array(
                'unsigned'  => true,
                'nullable'  => false,
                'default'   => '0',
            ), 'Attribute Id')
            ->addColumn('entity_id', \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, null, array(
                'unsigned'  => true,
                'nullable'  => false,
                'default'   => '0',
            ), 'Entity Id')
            ->addColumn('value', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, 255, array(
            ), 'Value')
            ->addIndex(
                $setup->getIdxName(
                    'titans_blog_post_entity_varchar',
                    array('entity_id', 'attribute_id'),
                    \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE
                ),
                array('entity_id', 'attribute_id'), array('type' => \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE))
            ->addIndex($setup->getIdxName('titans_blog_post_entity_varchar', array('entity_type_id')),
                array('entity_type_id'))
            ->addIndex($setup->getIdxName('titans_blog_post_entity_varchar', array('attribute_id')),
                array('attribute_id'))
            ->addIndex($setup->getIdxName('titans_blog_post_entity_varchar', array('entity_id')),
                array('entity_id'))
            ->addIndex($setup->getIdxName('titans_blog_post_entity_varchar', array('entity_id', 'attribute_id', 'value')),
                array('entity_id', 'attribute_id', 'value'))
            ->addForeignKey($setup->getFkName('titans_blog_post_entity_varchar', 'attribute_id', 'eav_attribute', 'attribute_id'),
                'attribute_id', $setup->getTable('eav_attribute'), 'attribute_id',
                \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE)
            ->addForeignKey($setup->getFkName('titans_blog_post_entity_varchar', 'entity_id', 'customer/entity', 'entity_id'),
                'entity_id', $setup->getTable('titans_blog_post_entity'), 'entity_id',
                \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE)
            ->addForeignKey(
                $setup->getFkName('titans_blog_post_entity_varchar', 'entity_type_id', 'eav_entity_type', 'entity_type_id'),
                'entity_type_id', $setup->getTable('eav_entity_type'), 'entity_type_id',
                \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE)
            ->setComment('Blog Post Entity Varchar');
        $setup->getConnection()->createTable($table);


        $setup->endSetup();
    }
}
