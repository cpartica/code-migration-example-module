<?php
namespace Titans\Blog\Model\ResourceModel;


class Post extends \Magento\Eav\Model\Entity\AbstractEntity
{
    /**
     * @var string
     */
    private $postTable;

    /**
     * @var \Magento\Framework\App\ResourceConnection
     */
    protected $resourceConnection;

    /**
     * Post constructor.
     * @param \Magento\Eav\Model\Entity\Context $context
     * @param \Magento\Framework\App\ResourceConnection $resourceConnection
     * @param array $data
     */
    public function __construct(
        \Magento\Eav\Model\Entity\Context $context,
        \Magento\Framework\App\ResourceConnection $resourceConnection,
        $data = []
    )
    {
        $this->resourceConnection = $resourceConnection;
        parent::__construct(
            $context,
            $data
        );
        $this->postTable = $this->getTable('titans_blog_post_entity');
    }

    /**
     * Resource initialization
     *
     * @return void
     */
    public function _construct()
    {
        parent::_construct();
        $this->setType('titans_blog_post');
        $this->setConnection($this->resourceConnection->getConnection());

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