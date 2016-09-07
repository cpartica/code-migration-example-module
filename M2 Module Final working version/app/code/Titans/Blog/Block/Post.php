<?php
namespace Titans\Blog\Block;


class Post extends \Titans\Blog\Block\BlockAbstract
{

    /**
     * @var \Titans\Blog\Model\PostFactory
     */
    protected $blogPostFactory;

    /**
     * @var \Titans\Blog\Model\Post
     */
    protected $blogPost;

    /**
     * @var \Titans\Blog\Helper\Data
     */
    protected $blogHelper;

    /**
     * @var \Titans\Blog\Model\ResourceModel\Post\CollectionFactory
     */
    protected $blogResourcePostCollectionFactory;

    /**
     * @var \Magento\Framework\App\Request\Http
     */
    protected $request;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * Post constructor.
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Titans\Blog\Helper\Data $blogHelper
     * @param \Titans\Blog\Model\ResourceModel\Post\CollectionFactory $blogResourcePostCollectionFactory
     * @param \Magento\Framework\App\Request\Http $request
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Titans\Blog\Model\PostFactory $blogPostFactory
     * @param \Titans\Blog\Model\Post $blogPost
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Titans\Blog\Helper\Data $blogHelper,
        \Titans\Blog\Model\ResourceModel\Post\CollectionFactory $blogResourcePostCollectionFactory,
        \Magento\Framework\App\Request\Http $request,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Titans\Blog\Model\PostFactory $blogPostFactory,
        \Titans\Blog\Model\Post $blogPost,
        array $data = []
    ) {
        $this->blogHelper = $blogHelper;
        $this->blogResourcePostCollectionFactory = $blogResourcePostCollectionFactory;
        $this->request = $request;
        parent::__construct(
            $context,
            $blogHelper,
            $blogResourcePostCollectionFactory,
            $request,
            $storeManager,
            $data
        );
        $this->blogPostFactory = $blogPostFactory;
        $this->blogPost = $blogPost;
    }


    public function getPost()
    {
        if (!$this->hasData('post')) {
            if ($this->getPostId()) {
                $post = $this->blogPostFactory->create()->load($this->getPostId());
            } else {
                $post = $this->blogPost;
            }
            $post->setAddress($this->getBlogUrl($post->getEntityId()));

            $this->_prepareData($post)->_prepareDates($post);

            $this->setData('post', $post);
        }

        return $this->getData('post');
    }

    public function getFormAction()
    {
        return $this->getUrl('*/*/*');
    }

    public function getFormData()
    {
        return $this->getRequest();
    }

    protected function _prepareLayout()
    {
        $this->_prepareCrumbs()->_prepareHead();
        parent::_prepareLayout();
    }

    protected function _prepareCrumbs()
    {
        $breadcrumbs = $this->getCrumbs();
        if ($breadcrumbs) {
            $helper = $this->_helper();
            $breadcrumbs->addCrumb(
                'blog',
                array(
                     'label' => $helper->getTitle(),
                     'title' => __('Return to %s', $helper->getTitle()),
                     'link'  => $this->_storeManager->getStore()->getBaseUrl(),
                )
            );

            $breadcrumbs->addCrumb(
                'blog_page', array('label' => htmlspecialchars_decode($this->getPost()->getTitle()))
            );
        }

        return $this;
    }

    protected function _prepareHead()
    {
        parent::_prepareMetaData($this->getPost());

        return $this;
    }
}
