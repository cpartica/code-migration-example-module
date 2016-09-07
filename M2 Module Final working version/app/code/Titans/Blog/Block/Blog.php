<?php
namespace Titans\Blog\Block;


class Blog extends \Titans\Blog\Block\BlockAbstract
{
    protected function _prepareLayout()
    {
       if ($this->isBlogPage() && ($breadcrumbs = $this->getCrumbs())) {
            $this->_prepareMetaData(self::$_helper);
            $breadcrumbs->addCrumb('blog', array('label' => self::$_helper->getTitle()));
       }
        parent::_prepareLayout();
    }
}