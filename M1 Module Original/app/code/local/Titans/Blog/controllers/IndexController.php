<?php

class Titans_Blog_IndexController extends Mage_Core_Controller_Front_Action
{

    public function preDispatch()
    {
        parent::preDispatch();
        if (!Mage::helper('titans_blog/data')->isEnabled()) {
            $this->_redirectUrl(Mage::helper('core/url')->getHomeUrl());
        }
    }

    public function indexAction()
    {
        $this->loadLayout();
        $this->getLayout()->getBlock('root')->setTemplate(Mage::helper('titans_blog/data')->getLayout());
        $this->renderLayout();
    }

    public function postAction()
    {
        $post_id = $this->getRequest()->getParam('post_id');
        $post = Mage::getSingleton('titans_blog/post')->load($post_id);
        if (!$post->getEntityId()) {
            $this->_forward('NoRoute');
        }
        $this->loadLayout();
        $this->getLayout()->getBlock('root')->setTemplate(Mage::helper('titans_blog/data')->getLayout());
        $this->renderLayout();
    }

    public function noRouteAction($coreRoute = null)
    {
        $this->getResponse()->setHeader('HTTP/1.1', '404 Not Found');
        $this->getResponse()->setHeader('Status', '404 File not found');

        $pageId = Mage::getStoreConfig('web/default/cms_no_route');
        if (!Mage::helper('cms/page')->renderPage($this, $pageId)) {
            $this->_forward('defaultNoRoute');
        }
    }
}