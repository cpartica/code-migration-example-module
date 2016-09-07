<?php
namespace Titans\Blog\Controller\Blog;

use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\RequestInterface;

class Index extends \Magento\Framework\App\Action\Action
{

    /**
     * @var ResultFactory
     */
    protected $resultFactory;

    /**
     * @var \Titans\Blog\Helper\Data
     */
    protected $blogHelper;

    /**
     * Constructor
     *
     * @param Context $context
     * @param \Titans\Blog\Helper\Data $blogHelper
     */
    public function __construct(
        Context $context,
        \Titans\Blog\Helper\Data $blogHelper
    ) {
        $this->resultFactory = $context->getResultFactory();
        $this->blogHelper = $blogHelper;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
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