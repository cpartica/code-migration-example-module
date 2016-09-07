<?php
namespace Titans\Blog\Model;


class Post
    extends \Magento\Framework\Model\AbstractModel
{
    CONST ENTITY = 'titans_blog_post';

    /*
     * Set resource model
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        parent::__construct(
            $context,
            $registry,
            $resource,
            $resourceCollection,
            $data
        );
    }

    protected function _construct()
    {
        $this->_init(\Titans\Blog\Model\ResourceModel\Post::class);
    }
}