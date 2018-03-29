<?php
if (!defined('__TYPECHO_ROOT_DIR__')) {
    exit;
}
/**
 * 使typecho 支持自定义输出文章，首页，评论，分类json数据，微信小程序定制版。
 * 
 * @package typecho-json-miniprogram
 * @author 姬长信
 * @version 1.0
 * @link https://blog.isoyu.com/archives/typecho-json-miniprogram.html
 */
class JSON_Plugin implements Typecho_Plugin_Interface {
    /**
     * 激活插件方法,如果激活失败,直接抛出异常
     * 
     * @access public
     * @return void
     * @throws Typecho_Plugin_Exception
     */
    public static function activate() {
        Helper::addRoute('jsonp', '/typecho-json-miniprogram/[type]', 'JSON_Action');
        Helper::addAction('json', 'JSON_Action');
    }
    /**
     * 禁用插件方法,如果禁用失败,直接抛出异常
     * 
     * @static
     * @access public
     * @return void
     * @throws Typecho_Plugin_Exception
     */
    public static function deactivate() {
        Helper::removeRoute('jsonp');
        Helper::removeAction('json');
    }
    /**
     * 获取插件配置面板
     * 
     * @access public
     * @param Typecho_Widget_Helper_Form $form 配置面板
     * @return void
     */
    public static function config(Typecho_Widget_Helper_Form $form)
    {
        $defaultPic = new Typecho_Widget_Helper_Form_Element_Text('str_value', NULL, 'https://api.isoyu.com/bing_images.php', _t('文章默认缩略图'),  _t('文章不含图片时默认替代显示的图片'));
        $form->addInput($defaultPic);

        $recentPost = new Typecho_Widget_Helper_Form_Element_Text('recentPost', NULL, '10', _t('首页文章数量'),  _t('默认为10'));
        $form->addInput($recentPost);

        $topSize = new Typecho_Widget_Helper_Form_Element_Text('topSize', NULL, '1845,255', _t('置顶文章'),  _t('cid值，用,隔开。获取教程https://blog.isoyu.com/archives/typecho-cid-coid-mid.html'));
        $form->addInput($topSize);

        $categoryList = new Typecho_Widget_Helper_Form_Element_Text('categoryList', NULL, 'all', _t('输出分类'),  _t('默认输出全部分类(可直接输入设置mid数值。用,隔开)获取教程https://blog.isoyu.com/archives/typecho-cid-coid-mid.html'));
        $form->addInput($categoryList);

        $recentComments = new Typecho_Widget_Helper_Form_Element_Text('recentComments', NULL, 'authorId,ownerId,created,author,parent,coid,type,text,cid', _t('评论输出内容'),  _t('默认去除了mail，agent，ip等隐私输出'));
        $form->addInput($recentComments);
    	$element = new Typecho_Widget_Helper_Form_Element_Radio('huifu', array(0 => '不开启', 1 => '开启'), 1, _t('是否开启自带评论'), '默认开启，推荐关闭！关闭后在微信小程序公众平台的后台里，选择“设置”=>“模板消息”，在模板库申请并将模板id填入小程序config.js文件里具体请请参考我博客');
		$form->addInput($element);
	}
    /**
     * 个人用户的配置面板
     * 
     * @access public
     * @param Typecho_Widget_Helper_Form $form
     * @return void
     */
    public static function personalConfig(Typecho_Widget_Helper_Form $form) {
    }
}
