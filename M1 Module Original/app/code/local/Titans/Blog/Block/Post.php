<?php

class Titans_Blog_Block_Post extends Titans_Blog_Block_Abstract
{
    public function getPost()
    {
        if (!$this->hasData('post')) {
            if ($this->getPostId()) {
                $post = Mage::getModel('titans_blog/post')->load($this->getPostId());
            } else {
                $post = Mage::getSingleton('titans_blog/post');
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
                     'title' => $this->__('Return to %s', $helper->getTitle()),
                     'link'  => Mage::getUrl($helper->getRoute()),
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
