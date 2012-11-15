<?php

/**
 * ExtSitemap 用来生成 XML 格式的网站地图(Sitemap)，生成的网站地图支持大多数主流搜索引擎。
 *
 * 使用方法如下:
 * <pre>
 * $sitemap = Yii::app()->createComponent(array('class'=>'此扩展的类文件位置','dateFormater'=>'Y-m-d H:i:s'));
 *
 * $urlItem1 = $sitemap->createUrlItem();
 * $urlItem1->loc = Yii::app()->createUrl('/');//网站首页
 * $urlItem1->lastmod = time();
 * $urlItem1->priority = '1.0';
 * $rulItem1->changefreq = 'daily';
 *
 * $sitemap->addUrlItem($urlItem1);
 * //添加更多
 * ...
 *
 * //显示
 *
 * $sitemap->render();
 * 注意：
 *  dateFormater 为最后修改时间的格式
 *  UrlItem 对象的 lastmod 属性为 Unix 时间戳,
 * </pre>
 * @author Zhang Di <zhangdi5649@126.com>
 * @version 0.1
 */
class ExtSitemap extends CComponent {

    /**
     * 最后修改时间的格式，默认为 "Y-m-d",即 "2011-12-01" 格式
     * @var string
     */
    public $dateFormater = "Y-m-d";
    
    /**
     * 由所有的 UrlItem 对象组成的数组
     * @var array
     */
    private $_urls = array();
    private $_baseUrl;

    /**
     * 获取版本信息
     * @return string
     */
    public function getVersion() {
        return '0.1';
    }

    /**
     * 创建一个 url 节点对象
     * @return UrlItem url 节点对象
     */
    public function createUrlItem() {
        return new UrlItem();
    }

    /**
     * 添加一个 url 节点
     * @param UrlItem $urlItem url 节点对象
     */
    public function addUrlItem(UrlItem $urlItem) {
        $this->_urls[] = $urlItem;
    }

    /**
     * 获取所有的 url 节点
     * @return array() 所有 url 节点对象组成的数组
     */
    public function getItems() {
        return $this->_urls;
    }

    /**
     * 返回 url 节点的数量
     * @return integer
     */
    public function getItemCount() {
        return count($this->getItems());
    }

    /**
     * 渲染页面
     */
    public function render() {
        ob_clean();
        header("Content-Type: text/xml;charset=utf-8");
        $this->registerXsl();
        $this->beginRender();
        $this->beginRenderUrlSet();

        $this->renderUrlItems();
        $this->endRenderUrlSet();
        $this->endRender();
    }

    /**
     * 开始渲染 urlset 节点
     */
    public function beginRenderUrlSet() {
        echo <<<EOS
<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
        xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd"
        xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">\n
EOS;
    }

    /**
     * 结束渲染 urlset 节点
     */
    public function endRenderUrlSet() {
        echo <<<EOS
</urlset>\n
EOS;
    }

    /**
     * 开始渲染页面
     */
    public function beginRender() {
        echo <<<EOS
<?xml version='1.0' encoding='UTF-8'?><?xml-stylesheet type="text/xsl" href="{$this->getXslUrl()}"?><!-- generator="Yii中文百科" -->\n
<!-- sitemap-generator-url="http://www.yiiwiki.com" sitemap-generator-version="{$this->getVersion()}" -->\n
<!-- generated-on="{$this->getRenderDate()}" -->\n
EOS;
    }

    /**
     * 结束渲染页面
     */
    public function endRender() {
        
    }

    /**
     * 返回渲染的日期
     * @return string
     */
    public function getRenderDate() {
        return date($this->dateFormater);
    }

    /**
     * 渲染所有 url 节点
     */
    public function renderUrlItems() {
        $items = $this->getItems();
        foreach ($items as $item) {
            $lastmod = date($this->dateFormater,$item->lastmod);
            echo <<<EOS
    <url>
        <loc>{$this->getHost()}{$item->loc}</loc>
        <lastmod>{$lastmod}</lastmod>
        <priority>{$item->priority}</priority>
        <changefreq>{$item->changefreq}</changefreq>
    </url>\n
EOS;
        }
    }

    /**
     * 返回 xsl 文件的路径
     * @return <type>
     */
    public function getXslUrl() {
        return $this->_baseUrl.'/sitemap.xsl';
    }

    /**
     * 返回主机地址
     * @return string
     */
    public function getHost() {
        return Yii::app()->request->getHostInfo();
    }

    /**
     * 注册 xsl 文件
     */
    public function registerXsl(){
        $this->_baseUrl = Yii::app()->getAssetManager()->publish(dirname(__FILE__).'/assets');
    }

}

/**
 * sitemap 中 url 节点类
 */
class UrlItem {

    /**
     * 网址
     * @var string
     */
    public $loc;
    /**
     * 最后修改时间,Unix 时间戳
     * @var integer 最后修改时间
     */
    public $lastmod;
    /**
     * 更改的频率
     *
     * 可选值：
     *      always 总是
     *      hourly 每小时
     *      daily 每天
     *      weekly 每周
     *      monthly 每月
     *      yearly 每年
     *      never 从不
     * @var string
     */
    public $changefreq;
    /**
     * 优先级
     * @var string 从 0.0 到 1.0
     */
    public $priority;
}