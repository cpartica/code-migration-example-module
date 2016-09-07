<?php

class Titans_Blog_Model_Resource_Post extends Mage_Eav_Model_Entity_Abstract
{
    /**
     * @var string
     */
    private $postTable;

    /**
     * Resource initialization
     */
    public function __construct()
    {
        $resource = Mage::getSingleton('core/resource');
        $this->setType('titans_blog_post');
        $this->setConnection(
            $resource->getConnection('blog_read'),
            $resource->getConnection('blog_write')
        );
        $this->postTable = $this->getTable('titans_blog/post_entity');
    }

    /*
     * Set default attributes
     */
    protected function _getDefaultAttributes()
    {
        return array(
            'entity_type_id',
            'attribute_set_id',
            'created_at',
            'updated_at',
            'increment_id',
            'store_id',
            'website_id'
        );
    }

    /**
     * @return string
     */
    public function getTableName() {
        return $this->postTable;
    }
}