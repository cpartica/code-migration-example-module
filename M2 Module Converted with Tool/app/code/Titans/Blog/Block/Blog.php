<?php

class Titans_Blog_Block_Blog extends Titans_Blog_Block_BlockAbstract
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