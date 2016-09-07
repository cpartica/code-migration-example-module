<?php

abstract class Titans_Blog_Block_BlockAbstract extends Mage_Core_Block_Template
{
    protected static $_helper;

    protected static $_collection;

    protected function _construct()
    {
        if (!self::$_helper) {
            self::$_helper = Mage::helper('titans_blog/data');
        }
        if (!self::$_collection) {
            self::$_collection = $this->_prepareCollection();
        }
    }

    protected function _prepareCollection()
    {
        if (!$this->getData('cached_collection')) {

            $collection = Mage::getModel('titans_blog/post')->getCollection()
                ->addAttributeToSelect('title')
                ->addAttributeToSelect('author')
                ->addAttributeToSelect('content')
                ->setOrder('created_at', 'asc');

            $this->setData('cached_collection', $collection);
        }
        return $this->getData('cached_collection');
    }

    public function isBlogPage()
    {
        return Mage::app()->getRequest()->getModuleName() == Titans_Blog_Helper_Data::DEFAULT_ROOT;
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
                        'label' => $this->__('Home'),
                        'title' => $this->__('Go to Home Page'),
                        'link'  => Mage::getBaseUrl(),
                    )
                );
            }
        }
        return false;
    }

    public function getBlogUrl($route = null, $param = 'post_id')
    {
        $blogRoute = self::$_helper->getRoute();
        $postRoute = Titans_Blog_Helper_Data::POST_URI_PARAM;
        $blogRoute .= "/index/{$postRoute}/{$param}/{$route}";
        return $this->getUrl($blogRoute);
    }

    protected function _helper()
    {
        return Mage::helper('titans_blog/data');
    }
}