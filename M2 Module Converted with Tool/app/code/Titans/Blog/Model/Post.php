<?php

class Titans_Blog_Model_Post
    extends Mage_Core_Model_Abstract
{
    /*
     * Set resource model
     */
    protected function _construct()
    {
        $this->_init('titans_blog/post');
    }
}