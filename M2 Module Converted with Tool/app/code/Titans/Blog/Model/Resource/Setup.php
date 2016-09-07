<?php

class Titans_Blog_Model_Resource_Setup extends Mage_Eav_Model_Entity_Setup
{
    /*
     * Setup attributes for titans_blog_post entity type
     */
    public function getDefaultEntities()
    {
        $entities = array(
            'titans_blog_post' => array(
                'entity_model' => 'titans_blog/post',
                'attribute_model' => '',
                'table' => Mage::getSingleton('titans_blog/post')->getTableName(),
                'attributes' => array(
                    'title' => array(
                        'type' => 'varchar',
                        'backend' => '',
                        'frontend' => '',
                        'label' => 'Title',
                        'input' => 'text',
                        'class' => '',
                        'source' => '',
                        'global' => 0,
                        'visible' => true,
                        'required' => true,
                        'user_defined' => true,
                        'default' => '',
                        'searchable' => false,
                        'filterable' => false,
                        'comparable' => false,
                        'visible_on_front' => true,
                        'unique' => false,
                    ),
                    'author' => array(
                        'type' => 'varchar',
                        'backend' => '',
                        'frontend' => '',
                        'label' => 'Author',
                        'input' => 'text',
                        'class' => '',
                        'source' => '',
                        'global' => 0,
                        'visible' => true,
                        'required' => true,
                        'user_defined' => true,
                        'default' => '',
                        'searchable' => false,
                        'filterable' => false,
                        'comparable' => false,
                        'visible_on_front' => false,
                        'unique' => false,
                    ),
                    'content' => array(
                        'type' => 'text',
                        'backend' => '',
                        'frontend' => '',
                        'label' => 'Content',
                        'input' => 'text',
                        'class' => '',
                        'source' => '',
                        'global' => 0,
                        'visible' => true,
                        'required' => true,
                        'user_defined' => true,
                        'default' => '',
                        'searchable' => false,
                        'filterable' => false,
                        'comparable' => false,
                        'visible_on_front' => false,
                        'unique' => false,
                    ),
                ),
            )
        );
        return $entities;
    }
}