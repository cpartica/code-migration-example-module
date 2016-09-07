<?php

class Titans_Blog_Helper_Data extends Mage_Core_Helper_Abstract
{
    const XML_PATH_ENABLED = 'blog/blog/enabled';
    const XML_PATH_FOOTER_ENABLED = 'blog/blog/footerEnabled';
    const XML_CRUMBS_ENABLED = 'blog/blog/blogcrumbs';

    const XML_BOOKMARKS = 'blog/blog/bookmarkslist';
    const XML_PATH_BOOKMARKS_POST = 'blog/blog/bookmarkspost';
    const XML_ROOT = 'blog/blog/route';
    const XML_PATH_DATE_FORMAT = 'blog/blog/dateformat';

    /* menus and links */
    const XML_PATH_LAYOUT = 'blog/blog/layout';
    /* metadata */
    const XML_PATH_TITLE = 'blog/blog/title';
    const XML_PATH_KEYWORDS = 'blog/blog/keywords';
    const XML_PATH_DESCRIPTION = 'blog/blog/description';
    const DEFAULT_ROOT = 'blog';

    /* url constants */
    const POST_URI_PARAM = 'post';

    public function conf($code, $store = null)
    {
        return Mage::getStoreConfig($code, $store);
    }

    public function isCrumbs($store = null)
    {
        return $this->conf(self::XML_CRUMBS_ENABLED, $store);
    }

    public function isEnabled($store = null)
    {
        return $this->conf(self::XML_PATH_ENABLED, $store);
    }

    public function isTitle($store = null)
    {
        return $this->conf(self::XML_PATH_TITLE, $store);
    }

    public function getTitle($store = null)
    {
        return $this->isTitle($store);
    }

    public function getMetaKeywords($store = null)
    {
        return $this->conf(self::XML_PATH_KEYWORDS, $store);
    }

    public function getMetaDescription($store = null)
    {
        return $this->conf(self::XML_PATH_DESCRIPTION, $store);
    }

    public function getDateFormat($store = null)
    {
        return $this->conf(self::XML_PATH_DATE_FORMAT, $store);
    }

    public function getLayout($store = null)
    {
        return $this->conf(self::XML_PATH_LAYOUT, $store);
    }

    public function getEnabled()
    {
        return Mage::getStoreConfig('blog/blog/enabled') && $this->extensionEnabled('Titans_Blog');
    }


    public static function escapeSpecialChars($post)
    {
        $post->setTitle(htmlspecialchars($post->getTitle()));
    }

    public function getRoute($store = null)
    {
        $route = trim($this->conf(self::XML_ROOT));
        if (!$route) {
            $route = self::DEFAULT_ROOT;
        }
        return $route;
    }

    public function getRouteUrl($store = null)
    {
        return Mage::getUrl($this->getRoute($store), array('_store' => $store));
    }
}