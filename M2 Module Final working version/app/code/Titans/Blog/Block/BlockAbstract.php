<?php
namespace Titans\Blog\Block;


class BlockAbstract extends \Magento\Framework\View\Element\Template
{
    protected static $_helper;

    protected static $_collection;

    /**
     * @var \Titans\Blog\Helper\Data
     */
    protected $blogHelper;

    /**
     * @var \Titans\Blog\Model\ResourceModel\Post\CollectionFactory
     */
    protected $blogResourcePostCollectionFactory;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * @var \Magento\Framework\App\Request\Http
     */
    protected $request;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Titans\Blog\Helper\Data $blogHelper,
        \Titans\Blog\Model\ResourceModel\Post\CollectionFactory $blogResourcePostCollectionFactory,
        \Magento\Framework\App\Request\Http $request,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        array $data = []
    ) {
        $this->_storeManager = $storeManager;
        $this->blogHelper = $blogHelper;
        $this->blogResourcePostCollectionFactory = $blogResourcePostCollectionFactory;
        $this->request = $request;
        $this->_storeManager = $storeManager;
        parent::__construct(
            $context,
            $data
        );
    }


    protected function _construct()
    {
        if (!self::$_helper) {
            self::$_helper = $this->blogHelper;
        }
        if (!self::$_collection) {
            self::$_collection = $this->_prepareCollection();
        }
    }

    protected function _prepareCollection()
    {
        if (!$this->getData('cached_collection')) {

            $collection = $this->blogResourcePostCollectionFactory->create()->addAttributeToSelect('title')
                ->addAttributeToSelect('author')
                ->addAttributeToSelect('content')
                ->setOrder('created_at', 'asc');

            $this->setData('cached_collection', $collection);
        }
        return $this->getData('cached_collection');
    }

    public function isBlogPage()
    {
        return $this->request->getModuleName() == \Titans\Blog\Helper\Data::DEFAULT_ROOT;
    }

    public function getPosts()
    {
        $collection = $this->_prepareCollection();
        $this->_processCollection($collection);
        return $collection;
    }

    protected function _processCollection($collection)
    {
        foreach ($collection as $item) {
            $this->_prepareData($item)->_prepareDates($item);
            $item->setAddress($this->getBlogUrl($item->getEntityId()));
        }
        return $collection->load();
    }

    protected function _prepareData($item)
    {
        $item->setTitle(htmlspecialchars($item->getTitle()));
        $item->setShortContent(trim($item->getContent()));

        return $this;
    }

    protected function _prepareDates($item)
    {
        $dateFormat = self::$_helper->getDateFormat();
        $item->setCreatedAt($this->formatTime($item->getCreatedAt(), $dateFormat, true));
        $item->setUpdatedAt($this->formatTime($item->getUpdatedAt(), $dateFormat, true));

        return $this;
    }

    protected function _prepareMetaData($meta)
    {
        if (is_object($meta)) {
            $head = $this->getLayout()->getBlock('head');
            if ($head) {
                $head->setTitle($meta->getTitle());
                $head->setKeywords($meta->getMetaKeywords());
                $head->setDescription($meta->getMetaDescription());
            }
        }
    }

    public function getCrumbs()
    {
        if (self::$_helper->isCrumbs()) {
            $crumbs = $this->getLayout()->getBlock('breadcrumbs');
            if ($crumbs) {
                return $crumbs->addCrumb(
                    'home',
                    array(
                        'label' => __('Home'),
                        'title' => __('Go to Home Page'),
                        'link'  => $this->_storeManager->getStore()->getBaseUrl(),
                    )
                );
            }
        }
        return false;
    }

    public function getBlogUrl($route = null, $param = 'post_id')
    {
        $blogRoute = self::$_helper->getRoute();
        $postRoute = \Titans\Blog\Helper\Data::POST_URI_PARAM;
        $blogRoute .= "/{$postRoute}/index/{$param}/{$route}";
        return $this->getUrl($blogRoute);
    }

    protected function _helper()
    {
        return $this->blogHelper;
    }
}