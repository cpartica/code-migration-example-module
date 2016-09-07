<?php
namespace Titans\Blog\Controller\Post;

use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\RequestInterface;

class Index extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \Magento\Framework\Controller\Result\ForwardFactory
     */
    protected $resultForwardFactory;

    /**
     * @var ResultFactory
     */
    protected $resultFactory;

    /**
     * @var \Titans\Blog\Helper\Data
     */
    protected $blogHelper;

    /**
     * @var \Titans\Blog\Model\Post
     */
    protected $blogPost;

    /**
     * Constructor
     *
     * @param Context $context
     * @param \Magento\Framework\Controller\Result\ForwardFactory $resultForwardFactory
     * @param \Titans\Blog\Model\Post $blogPost
     * @param \Titans\Blog\Helper\Data $blogHelper
     */
    public function __construct(
        Context $context,
        \Magento\Framework\Controller\Result\ForwardFactory $resultForwardFactory,
        \Titans\Blog\Model\Post $blogPost,
        \Titans\Blog\Helper\Data $blogHelper
    ) {
        $this->resultForwardFactory = $resultForwardFactory;
        $this->blogPost = $blogPost;
        $this->blogHelper = $blogHelper;
        $this->resultFactory = $context->getResultFactory();
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $post_id = $this->getRequest()->getParam('post_id');
        $post = $this->blogPost->load($post_id);
        if (!$post->getEntityId()) {
            $this->noRouteAction();
        }
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);

        return $resultPage;
    }

    /**
     * Dispatch request
     *
     * @param RequestInterface $request
     * @return \Magento\Framework\App\ResponseInterface
     * @throws \Magento\Framework\Exception\NotFoundException
     */
    public function dispatch(RequestInterface $request)
    {
        if (!$this->blogHelper->isEnabled()) {
            $this->noRouteAction();
        }
       return parent::dispatch($request);
    }

    public function noRouteAction()
    {
        /** @var \Magento\Framework\Controller\Result\Forward $resultForward */
        $resultForward = $this->resultForwardFactory->create();
        $resultForward->setController('index');
        $resultForward->forward('defaultNoRoute');
        return $resultForward;
    }
}