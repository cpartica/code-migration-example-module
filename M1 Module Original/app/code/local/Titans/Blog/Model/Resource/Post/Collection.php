<?php

class Titans_Blog_Model_Resource_Post_Collection
    extends Mage_Eav_Model_Entity_Collection_Abstract
{
    /*
     * Set resource model
     */
    protected function _construct()
    {
        $this->_init('titans_blog/post');
    }
}