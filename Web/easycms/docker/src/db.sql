-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- 主机： 127.0.0.1
-- 生成日期： 2021-06-21 20:50:41
-- 服务器版本： 5.7.27-log
-- PHP 版本： 5.5.38

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";
CREATE DATABASE IF NOT EXISTS itislasttime;
USE itislasttime;


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `itislasttime`
--

-- --------------------------------------------------------

--
-- 表的结构 `eps_action`
--

CREATE TABLE `eps_action` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `objectType` varchar(30) NOT NULL DEFAULT '',
  `objectID` mediumint(8) UNSIGNED NOT NULL DEFAULT '0',
  `actor` varchar(30) NOT NULL DEFAULT '',
  `action` varchar(30) NOT NULL DEFAULT '',
  `date` datetime NOT NULL,
  `comment` text NOT NULL,
  `extra` varchar(255) NOT NULL,
  `lang` char(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `eps_address`
--

CREATE TABLE `eps_address` (
  `id` mediumint(9) NOT NULL,
  `account` char(30) NOT NULL,
  `contact` varchar(50) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone` char(20) NOT NULL,
  `zipcode` char(6) NOT NULL,
  `lang` char(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `eps_address`
--

INSERT INTO `eps_address` (`id`, `account`, `contact`, `address`, `phone`, `zipcode`, `lang`) VALUES
(1, 'demo', '张三丰', '位于湖北省西北部的十堰市丹江口市境内', '15988898558', '266555', 'zh-cn');

-- --------------------------------------------------------

--
-- 表的结构 `eps_article`
--

CREATE TABLE `eps_article` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `title` varchar(150) NOT NULL,
  `titleColor` varchar(10) NOT NULL,
  `alias` varchar(100) NOT NULL,
  `keywords` varchar(150) NOT NULL,
  `summary` text NOT NULL,
  `content` text NOT NULL,
  `source` enum('original','copied','translational','article') NOT NULL,
  `copySite` varchar(60) NOT NULL,
  `copyURL` varchar(255) NOT NULL,
  `author` varchar(60) NOT NULL,
  `addedBy` varchar(60) NOT NULL,
  `editor` varchar(60) NOT NULL,
  `addedDate` datetime NOT NULL,
  `editedDate` datetime NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'normal',
  `type` varchar(30) NOT NULL,
  `submission` enum('0','1','2','3') NOT NULL DEFAULT '0',
  `views` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `sticky` enum('0','1','2','3') NOT NULL DEFAULT '0',
  `stickTime` datetime NOT NULL,
  `stickBold` enum('0','1') NOT NULL DEFAULT '0',
  `order` smallint(5) UNSIGNED NOT NULL,
  `link` varchar(255) NOT NULL,
  `css` text NOT NULL,
  `js` text NOT NULL,
  `onlyBody` enum('0','1') NOT NULL DEFAULT '0',
  `lang` char(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `eps_article`
--

INSERT INTO `eps_article` (`id`, `title`, `titleColor`, `alias`, `keywords`, `summary`, `content`, `source`, `copySite`, `copyURL`, `author`, `addedBy`, `editor`, `addedDate`, `editedDate`, `status`, `type`, `submission`, `views`, `sticky`, `stickTime`, `stickBold`, `order`, `link`, `css`, `js`, `onlyBody`, `lang`) VALUES
(1, '安全升级，蝉知2.5.2发布', '', 'chanzhi2.5.2', '安全cms,企业建站系统,企业门户,开源csm', '大家好，蝉知2.5.2正式版发布了，这次更新增强了系统安全，改进了部分页面的体验，另外修复了很多之前版本的bug，建议老用户及时下载升级。', '<h4>一、修改记录</h4>\n<ol><li>新增防xss跨站攻击处理</li>\n<li>优化后台区块管理操作体验</li>\n<li>修复通过字段可进行sql注入的漏洞</li>\n<li>修复产品数据结构bug</li>\n<li>修复繁体版安装失败bug</li>\n<li>修复论坛帖子隐藏显示bug</li>\n</ol><h4>二、下载地址</h4>\n源码包： <a href=\"http://dl.xirangit.com/eps/2.5/chanzhiEPS.2.5.2.zip\">http://dl.xirangit.com/eps/2.5/chanzhiEPS.2.5.2.zip</a> <h4>三、安装和升级文档</h4>\n安装文档：<a href=\"http://www.chanzhi.org/book/chanzhieps/5.html\">http://www.chanzhi.org/book/chanzhieps/5.html</a><br />\n升级文档：<a href=\"http://www.chanzhi.org/book/chanzhieps/68.html\">http://www.chanzhi.org/book/chanzhieps/68.html</a><br /><h4>四、演示</h4>\n前台演示：<a href=\"http://demo.chanzhi.org\">http://demo.chanzhi.org</a><br /><p>后台演示：<a href=\"http://demo.chanzhi.org/chanzhiadmin.php\">http://demo.chanzhi.org/chanzhiadmin.php</a></p>', 'original', '', '', 'admin', '', 'admin', '2014-08-21 13:55:00', '2014-08-25 15:17:30', 'normal', 'article', '0', 29, '0', '0000-00-00 00:00:00', '0', 0, '', '', '', '0', 'zh-cn'),
(2, '推荐空间', '', 'host', '蝉知空间', '', '<p>我们不推荐大家使用iis + php的空间，存在诸多问题。下面列出的空间都是经过我们测试的，可以选购。</p>\n<h4>首先推荐：<a href=\"http://www.chanzhi.net\">云蝉知</a></h4>\n<p>云蝉知是蝉知团队运营的免费建站服务，不需要备案，不需要维护，简单方便。</p>\n<h4>推荐2：<a href=\"http://www.londit.com/aff/d3djY3NzQGdtYWlsLmNvbQ==\">浪点云主机</a>：</h4>\n<p>浪点云主机服务器在香港，不需要备案，linux + apache + php环境，经过我们测试可以流畅运行蝉知系统，也支持伪静态。价格也比较实惠。想自己安装，自己维护的朋友可以选择。<a href=\"http://www.londit.com/aff/d3djY3NzQGdtYWlsLmNvbQ==\">点击此链接购买：</a></p>\n<p><br /></p>\n<p>附：大家有什么推荐的空间也都可以联系我们进行评测。</p>', 'original', '', '', '', '', '', '2014-08-25 14:17:00', '2014-08-25 14:18:11', 'normal', 'page', '0', 129, '0', '0000-00-00 00:00:00', '0', 0, '', '', '', '0', 'zh-cn'),
(3, 'ZUI文档更新', '', '', '', '', '<p>大家好就，在我们团队浩浩同学的努力下，zui文档的整理工作已经初步完成，zui发布以来大家一直都比较关注，很多朋友催我们更新文档，这次终于可以给大家一个比较完善的手册。请大家到<span style=\"line-height:1.428571429;\">zui文档的官方地址：</span><span style=\"line-height:1.428571429;\"><a href=\"http://devel.cnezsoft.com/page/zui.html\">http://devel.cnezsoft.com/page/zui.html</a></span><span style=\"line-height:1.428571429;\">查看。</span></p>\n<p><span style=\"line-height:1.428571429;\"><img src=\"http://www.chanzhi.org/data/upload/201406/f_d81b3cd8361b97c639574b9184d2050d.jpg\" alt=\"\" /><br /><br /></span></p>\n<p><span style=\"line-height:1.428571429;\"><img src=\"http://www.chanzhi.org/data/upload/201406/f_9b835d5e180020bb9aadffdefddfa4dc.jpg\" alt=\"\" /><br /></span></p>\n<p><br /></p>\n<p><span style=\"background-color:#FAFAFA;color:#19751A;font-size:18px;font-weight:bold;line-height:1.1;\">PS:ZUI构建于众多优秀的开源项目之上</span></p>\n<p><span style=\"background-color:#FAFAFA;color:#19751A;font-size:18px;font-weight:bold;line-height:1.1;\"><br /></span></p>\n<div class=\"col-md-3 col-sm-4\" style=\"font-size:14px;text-align:center;background-color:#FAFAFA;\"><a href=\"http://necolas.github.io/normalize.css/\" class=\"card\"><strong class=\"card-heading\">normalize</strong></a></div>\n<div class=\"col-md-3 col-sm-4\" style=\"font-size:14px;text-align:center;background-color:#FAFAFA;\"><a href=\"http://jquery.com/\" class=\"card\"><strong class=\"card-heading\">jQuery</strong></a></div>\n<div class=\"col-md-3 col-sm-4\" style=\"font-size:14px;text-align:center;background-color:#FAFAFA;\"><a href=\"http://getbootstrap.com/\" class=\"card\"><strong class=\"card-heading\">Bootstrap</strong></a></div>\n<div class=\"col-md-3 col-sm-4\" style=\"font-size:14px;text-align:center;background-color:#FAFAFA;\"><a href=\"http://kindeditor.net/\" class=\"card\"><strong class=\"card-heading\">kindeditor</strong></a></div>\n<div class=\"col-md-3 col-sm-4\" style=\"font-size:14px;text-align:center;background-color:#FAFAFA;\"><a href=\"http://harvesthq.github.io/chosen/\" class=\"card\"><strong class=\"card-heading\">Chosen</strong></a></div>\n<div class=\"col-md-3 col-sm-4\" style=\"font-size:14px;text-align:center;background-color:#FAFAFA;\"><a href=\"http://www.malot.fr/bootstrap-datetimepicker\" class=\"card\"><strong class=\"card-heading\">Datetime picker</strong></a></div>\n<div class=\"col-md-3 col-sm-4\" style=\"font-size:14px;text-align:center;background-color:#FAFAFA;\"><a href=\"http://lesscss.org/\" class=\"card\"><strong class=\"card-heading\">Less</strong></a></div>\n<div class=\"col-md-3 col-sm-4\" style=\"font-size:14px;text-align:center;background-color:#FAFAFA;\"><a href=\"http://fortawesome.github.io/Font-Awesome/\" class=\"card\"><strong class=\"card-heading\">FontAwesome</strong></a></div>\n<div class=\"col-md-3 col-sm-4\" style=\"font-size:14px;text-align:center;background-color:#FAFAFA;\"><a href=\"https://code.google.com/p/google-code-prettify/\" class=\"card\"><strong class=\"card-heading\">google code prettify</strong></a></div>\n<br /><p><br /></p>\n<p><br /></p>\n<p><br /></p>\n<p><br /></p>\n<p><br /></p>\n<p><br /></p>\n<p><br /></p>\n<p><br /></p>\n<p><br /></p>\n<p><br /></p>\n<p><strong>向他们致谢！</strong></p>', 'original', '', '', 'admin', '', 'admin', '2014-06-09 14:30:00', '2014-08-25 15:27:00', 'normal', 'article', '0', 6, '0', '0000-00-00 00:00:00', '0', 0, '', '', '', '0', 'zh-cn'),
(4, '多处改进，蝉知2.5.1正式版发布', '', 'chanzhi2.5.1', '', '大家好蝉知企业门户系统2.5.1正式版发布了，修复了2.5beta的一些bug和漏洞，还有多处使用体验优化。这次升级修复了两个重要的安全漏洞，建议大家及时更新。', '<div class=\"text-danger\">本次升级修复了两个安全漏洞，建议大家及时更新。</div>\n<h4>一、2.5.1修改记录</h4>\n<ol><li>文章详情页面最后编辑放在页尾</li>\n<li>调整了后台区块设置颜色的界面</li>\n<li>二维码图片设置默认的宽度和高度</li>\n<li>处理留言和回复的时候，把留言或者评论的内容显示在回复框里面</li>\n<li>修复开放登录的图片地址</li>\n<li>手册文章的评论没有显示手册的查看链接</li>\n<li>调整php源码区块的样式</li>\n<li>zui里面的弹出框里面的\"好的\"改为\"确定\"</li>\n<li>布局页面的操作统一改为图标按钮</li>\n<li>跳转页面需要加placeholder，提示用户输入链接</li>\n<li>关注我们改为区块实现，样式调整</li>\n<li>检查ie11下面的兼容性问题</li>\n<li>php源码的ok文件提示不要放在文本框架里面</li>\n<li>全局样式菜单直接改成全局样式增加代码高亮</li>\n<li>如果站点类型是博客的话，把网站首页的链接去掉可以支持小图标</li>\n<li>产品的摘要改为简介</li>\n<li>类目管理放到类目的最下面</li>\n<li>类目维护后面增加x按钮，可以删除</li>\n<li>调整论坛帖子转移的逻辑</li>\n<li>调整上传模板页面的的样式</li>\n<li>源代码区块改为html源代码，设置选项，直接语法高亮</li>\n<li>新闻，产品列表的删除放在最后面</li>\n<li>把IE6提示代码放到js里加载，同时简化提示内容</li>\n<li>修复火狐下面导航错位问题</li>\n<li>解决后台文章管理模块，左边栏 类目浏览 如果文章类目过多会被遮盖，且无法向下滚动的问题</li>\n</ol>\n<h4>二、下载地址</h4>\n源码包： <a href=\"http://dl.xirangit.com/eps/2.5/chanzhiEPS.2.5.1.zip\">http://dl.xirangit.com/eps/2.5/chanzhiEPS.2.5.1.zip</a> <h4>三、安装和升级文档</h4>\n安装文档：<a href=\"http://www.chanzhi.org/book/chanzhieps/5.html\">http://www.chanzhi.org/book/chanzhieps/5.html</a><br />\n升级文档：<a href=\"http://www.chanzhi.org/book/chanzhieps/68.html\">http://www.chanzhi.org/book/chanzhieps/68.html</a><br />\n<h4>四、演示</h4>\n前台演示：<a href=\"\">http://demo.chanzhi.org</a><br />\n<p>后台演示：<a href=\"/chanzhiadmin.php\">http://demo.chanzhi.org/chanzhiadmin.php</a></p>\n<h4>五、新功能截图</h4>\n<p><br />\n</p>\n<p>区块颜色自定义预览</p>\n<p><img class=\"card\" src=\"http://www.chanzhi.org/data/upload/201408/f_612657d0b55bc2041168d5dc5e130b7f.jpg\" alt=\"\" /></p>\n<p>区块颜色自定义</p>\n<p><img class=\"card\" src=\"http://www.chanzhi.org/data/upload/201408/f_cbc7faa692abdbd2ddc70a471603d00d.jpg\" alt=\"\" /></p>\n<p>代码高亮</p>\n<p><img class=\"card\" src=\"http://www.chanzhi.org/data/upload/201408/f_3df23e03df90e34cc826e2e6ca2ac857.jpg\" alt=\"\" /></p>\n<p>关于我们页面区块设置</p>\n<p><img class=\"card\" src=\"http://www.chanzhi.org/data/upload/201408/f_7d0a448e87f61db219f7f06372f79683.jpg\" alt=\"\" /></p>\n<p><img class=\"card\" src=\"http://www.chanzhi.org/data/upload/201408/f_df8a18eb7d0b23ee46eea14d70d7eff5.jpg\" alt=\"\" /></p>', 'original', '', '', 'admin', '', 'demo', '2014-08-19 15:15:00', '2014-10-16 14:11:52', 'normal', 'article', '0', 15, '0', '0000-00-00 00:00:00', '0', 0, '', '', '', '0', 'zh-cn'),
(5, '蝉知企业门户2.5beta版本发布', '', '', '蝉知,企业建站', '蝉知企业门户2.5beta版正式发布。新增插件管理，优化模板体系、提供模板安装功能，新增文章、类目、主题的跳转功能，新增评论、留言前台回复功能，还有导航拖拽排序、代码编辑器等诸多优化。', '<h4>一、2.5修改记录</h4>\n<p>1、实现模板和主题风格的概念<br />\n2、将前台的模板文件独立出来<br />\n3、实现模板的导入功能<br />\n4、模板体系可以定义支持的区块和布局列表<br />\n5、增加插件管理机制<br />\n6、后台布局的区块、导航、手册等列表页面的排序改为拖动排序 <br />\n7、增加php源代码区块<br />\n8、源代码区块增加代码编辑器<br />\n9、区块增加更多颜色的配置<br />\n10、自定义区块也支持更多链接<br />\n11、公司简介区块还原更多链接<br />\n12、留言、评论支持回复功能<br />\n13、留言、评论列表显示所有回复<br />\n14、发表评论的时候可以选择是否接收邮件通知<br />\n15、评论被回复的时候，发送邮件通知评论作者<br />\n16、后台留言和评论通过之后也可以删除<br />\n17、设置产品的价格货币单位使用符号<br />\n18、调整没有任何参数的产品的详情页面<br />\n19、产品简介添加编辑器<br />\n20、用户可以直接定义一个全局的样式<br />\n21、调整手机版本下面幻灯的显示样式<br />\n22、登录注册的代码不应当出现在文档开始的地方<br />\n23、编辑手册的时候，记住当时点击的锚点<br />\n24、将文章详情页面底部的空白标签去掉<br />\n25、博客、论坛、手册功能关闭的时候，站点地图不显示这些模块<br />\n26、重新调整论坛的主题转移功能<br />\n27、类目维护页面增加添加按钮，可以新增一个类目框<br />\n28、类目、文章、主题可以是一个链接，当浏览该类目时，跳转到其他的链接地址<br />\n29、后台的主题、帖子、留言的删除改用zui里面的对话框<br />\n30、修改ie6的检查提示方式<br />\n31、二维码只有打开的时候再请求<br />\n32、图片浏览只能后台才可以使用，前台不能使用<br />\n33、日志文件增加.php扩展名<br />\n34、附件目录、system目录每个都创建空白的index.php文件<br />\n35、升级的时候去掉ok文件的检查<br />\n36、手册文章显示最后更新时间<br />\n37、后台的文章、博客、产品列表增加图片链接<br />\n38、调整帖子详情附件上传的表单样式<br />\n39、调整后台的文章、博客、产品等模块点开的附件上传表单修改样式<br />\n40、升级到2.5的时候，将之前的日志文件删除掉<br />\n41、备案信息增加链接<br />\n42、幻灯的链接应当指定是否是新开窗口<br />\n43、调整ie11下载附件的逻辑<br />\n44、后台的用户检索可以模糊检索<br />\n45、公司联系方式增加公司网址<br />\n46、处理QQ登录相关报错</p>\n<h4>二、下载地址</h4>\n源码包：<a href=\"http://dl.xirangit.com/eps/2.5/chanzhiEPS.2.5.beta.zip\">http://dl.xirangit.com/eps/2.5/chanzhiEPS.2.5.beta.zip</a><br /><h4>三、安装和升级文档</h4>\n安装文档：<a href=\"http://www.chanzhi.org/book/chanzhieps/5.html\">http://www.chanzhi.org/book/chanzhieps/5.html</a><br />\n升级文档：<a href=\"http://www.chanzhi.org/book/chanzhieps/68.html\">http://www.chanzhi.org/book/chanzhieps/68.html</a><br /><h4>四、演示</h4>\n前台演示：<a href=\"http://demo.chanzhi.org\">http://demo.chanzhi.org</a><br /><p>后台演示：<a href=\"http://demo.chanzhi.org/chanzhiadmin.php\">http://demo.chanzhi.org/chanzhiadmin.php</a></p>\n<h4>五、功能截图</h4>\n<h5>1.评论留言可重复回复</h5>\n<p class=\"card\"><img src=\"http://www.chanzhi.org/data/upload/201408/f_968ab3b123324b54b320474c18831d80.png\" alt=\"\" /></p>\n<h5>2.可以拖拽排序</h5>\n<p class=\"card\"><img src=\"http://www.chanzhi.org/data/upload/201408/f_421c572e99cb6d806874bfce45bd3f8d.png\" alt=\"\" /></p>\n<p class=\"card\"><img src=\"http://www.chanzhi.org/data/upload/201408/f_e6ae3162b920498fe9daca5701cc87de.png\" alt=\"\" /></p>\n<h5>3.模板设置</h5>\n<p class=\"card\"><img src=\"http://www.chanzhi.org/data/upload/201408/f_db80a5a9766e874e41d726174b0df05c.png\" alt=\"\" /></p>\n<h5>4.代码编辑器</h5>\n<p class=\"card\"><img src=\"http://www.chanzhi.org/data/upload/201408/f_8e536ec6c0c4857b4cef62af88c81cde.png\" alt=\"\" /></p>', 'original', '', '', 'admin', '', '', '2014-08-06 11:10:00', '2014-08-25 15:18:38', 'normal', 'article', '0', 16, '0', '0000-00-00 00:00:00', '0', 0, '', '', '', '0', 'zh-cn'),
(6, '蝉知企业门户2.4正式版发布', '', '', '企业建站系统,企业门户,开源CMS,免费cms', '大家好，蝉知2.4正式发布了。对大量的交互和样式做了优化，解决了之前版本的一些bug，如微信菜单链接错误等。相比之前版本蝉知2.4更加稳定流畅，欢迎大家下载使用。', '<h4>一、2.4修改记录</h4>\n<p>后台博客、产品、文章列表增加按照类目浏览功能<br />\n解决新版本的火狐二级导航错位问题<br />\n优化产品列表和详情页面的样式<br />\n论坛版块描述支持html标签显示<br />\n修复幻灯片删除第一个链接按钮后无法保存的bug<br />\n处理部分面包屑里面的类目地址bug</p>\n<p>解决部分图标无法显示bug<br />\n调整对话框的默认样式<br />\n区块增加更多链接<br />\n优化编辑区块操作体验，编辑后停留在编辑页面<br />\n调整文章的来源字段类型和显示效果<br /><span>前端</span>优化：代码把ie8相关的js脚本打包成一个ie8.js<br />\n前端优化：将treeview.js和treeview.css打包到all.css和all.js中<br />\n将前台每个列表页面默认记录数改成从配置项获取<br />\n附件列表不再显示编辑器上传的图片<br />\n优化评论和留言列表的样式<br />\n去掉论坛主题里面p标记的margin<br />\n调整蝉知系统默认的字体大小<br />\n修改布局的区域名称使之更容易理解<br />\nzui里面去掉p标记的margin<br />\n减少布局中列与列之间的间距<br />\n导航设置默认折叠起来<br />\n版块编辑器增加源代码标签<br />\n版块的描述字段长度调成text类型。<br />\n解决编辑器上传附件使用现有的图片时，缩略图地址错误的bug<br />\n调整前台首页友情链接的样式<br />\n留言和评论增加需要审核之后才会显示的提示。<br />\n幻灯功能优化：<span>优化了后台管理界面</span>，排序不再需要手动点击保存排序按钮，<br />\n解决通过之前评论时，留言也会被通过的bug<br />\n后台删除主题或者回帖的时候添加确认提示<br />\n前台主题的维护选项增加转移功能<br />\n增加logo删除功能</p>\n<p><span style=\"color:inherit;font-size:14px;font-weight:bold;line-height:1.1;\"><br /></span></p>\n<p><span style=\"color:inherit;font-size:14px;font-weight:bold;line-height:1.1;\">二、下载地址</span></p>\n源码包：<a href=\"http://dl.xirangit.com/eps/2.4/chanzhiEPS.2.4.zip\">http://dl.xirangit.com/eps/2.4/chanzhiEPS.2.4.zip</a><br /><h4>三、安装和升级文档</h4>\n安装文档：<a href=\"http://www.chanzhi.org/book/chanzhieps/5.html\">http://www.chanzhi.org/book/chanzhieps/5.html</a><br />\n升级文档：<a href=\"http://www.chanzhi.org/book/chanzhieps/68.html\">http://www.chanzhi.org/book/chanzhieps/68.html</a><br /><h4>四、演示</h4>\n前台演示：<a href=\"http://demo.chanzhi.org\">http://demo.chanzhi.org</a><br /><p>后台演示：<a href=\"http://demo.chanzhi.org/chanzhiadmin.php\">http://demo.chanzhi.org/chanzhiadmin.php</a></p>\n<h4>五、功能截图</h4>\n<p><img src=\"http://www.chanzhi.org/data/upload/201406/f_88e288f0d4db03b1124f0915d1d7f85c.png\" alt=\"\" class=\"card\" /></p>\n<p><img src=\"http://www.chanzhi.org/data/upload/201406/f_fbd7d140a337affb0618f17131548a8a.png\" alt=\"\" class=\"card\" /></p>\n<p><img src=\"http://www.chanzhi.org/data/upload/201406/f_b36c0d33a50a44804463e5f8cab37182.png\" alt=\"\" class=\"card\" /></p>\n<p><img src=\"http://www.chanzhi.org/data/upload/201406/f_27bcc27d111ebb12904cd19ab5e7b206.png\" alt=\"\" class=\"card\" /></p>', 'original', '', '', 'admin', '', '', '2014-06-25 14:10:00', '2014-08-25 15:19:43', 'normal', 'article', '0', 11, '0', '0000-00-00 00:00:00', '0', 0, '', '', '', '0', 'zh-cn'),
(7, '蝉知企业门户2.3正式版发布', '', 'chanzhi2.3', '企业建站系统,企业门户,开源CMS,免费cms', '大家好，蝉知2.3正式版正式发布了。主要改进有：提供iis下面的重写规则、增加产品自定义属性、增强幻灯片功能、增加空间图片调用功能。', '<h4>提示：</h4>\n<p>1、这次升级我们修改了<span>蝉知系统版权</span>，请大家仔细阅读。</p>\n<p>     蝉知系统版权： <a href=\"http://www.chanzhi.org/book/chanzhieps/58_license.html\">http://www.chanzhi.org/book/chanzhieps/58_license.html</a></p>\n<p>2、后台站点设置添加了首页关键字，首页标题算法改为首页关键字+站点名称，升级后需要大家根据需要重新设置一下。</p>\n<h4>一、2.3修改记录</h4>\n<ol><li><span style=\"line-height:1.428571429;\">博客页面应当增加对所有页面区块的支持</span></li>\n<li><span style=\"line-height:1.428571429;\">解决文章详情页面微博推广按钮不删除验证代码就不能显示问题</span></li>\n<li><span style=\"line-height:1.428571429;\">解决宽屏主题登录注册按钮不显示问题</span></li>\n<li><span style=\"line-height:1.428571429;\">解决部署在二级目录时微信的接入地址的bug </span></li>\n<li><span style=\"line-height:1.428571429;\">解决后台的用户列表中重复显示的bug </span></li>\n<li><span style=\"line-height:1.428571429;\">修复新浪会员链接</span></li>\n<li><span style=\"line-height:1.428571429;\">单页可以控制页面的布局</span></li>\n<li><span style=\"line-height:1.428571429;\">优化时间显示，去除00:00的显示</span></li>\n<li><span style=\"line-height:1.428571429;\">文章的来源增加翻译选项</span></li>\n<li><span style=\"line-height:1.428571429;\">二维码的图片缩小了一些</span></li>\n<li><span style=\"line-height:1.428571429;\">后台设置开放登录的图标用亮色的</span></li>\n<li><span style=\"line-height:1.428571429;\">删除zepto.js文件</span></li>\n<li><span style=\"line-height:1.428571429;\">调整蝉知默认的字体的大小</span></li>\n<li><span style=\"line-height:1.428571429;\">留言的图标采用亮色的</span></li>\n<li><span style=\"line-height:1.428571429;\">增加检查更新的功能</span></li>\n<li><span style=\"line-height:1.428571429;\">安装升级界面添加蝉知协议</span></li>\n<li>论坛版块和博客类目的别名不能使用数字</li>\n<li><span style=\"line-height:1.428571429;\">论坛后台的回帖链接应当新开页面</span></li>\n<li><span style=\"line-height:1.428571429;\">个人中心我的主题里面，最新回帖显示真实姓名</span></li>\n<li><span style=\"line-height:1.428571429;\">论坛发贴的时候，判断所属版块是否存在且可读</span></li>\n<li><span style=\"line-height:1.428571429;\">论坛版块列表页面的版主显示真实姓名</span></li>\n<li><span style=\"line-height:1.428571429;\">管理员或者版主身份在前台显示的时候应当给予标识</span></li>\n<li><span style=\"line-height:1.428571429;\">论坛增加帖子转移功能</span></li>\n<li><span style=\"line-height:1.428571429;\">后台单独增加一个首页关键词的设置</span></li>\n<li><span style=\"line-height:1.428571429;\">升级程序需要处理之前的站点描述信息，将html标签去掉</span></li>\n<li><span style=\"line-height:1.428571429;\">产品购买链接新窗口打开</span></li>\n<li><span style=\"line-height:1.428571429;\">提供了iis下面的重写规则</span></li>\n<li><span style=\"line-height:1.428571429;\">头部区域的logo，站点口号，登录注册也用区块显示</span></li>\n<li><span style=\"line-height:1.428571429;\">整理英语下面的翻译</span></li>\n<li><span style=\"line-height:1.428571429;\">首页布局调整，使之能显示最新产品</span></li>\n<li><span style=\"line-height:1.428571429;\">编辑器里面的图片库，文件库可以从我们附件表里面选择</span></li>\n<li><span style=\"line-height:1.428571429;\">对于禁用的会员，希望后台可以增加解除禁用功能</span></li>\n<li><span style=\"line-height:1.428571429;\">公司简介区块更多链接放在标题右侧</span></li>\n<li><span style=\"line-height:1.428571429;\">文章列表显示的条目数可自己设置。</span></li>\n<li><span style=\"line-height:1.428571429;\">站点增加类型设置，可以选择企业门户或者个人门户</span></li>\n<li><span style=\"line-height:1.428571429;\">幻灯文字和图片给予提示</span></li>\n<li><span style=\"line-height:1.428571429;\">幻灯可以有多个按钮</span></li>\n<li><span style=\"line-height:1.428571429;\">每一个幻灯都可以指定文字的颜色和背景色</span></li>\n<li><span style=\"line-height:1.428571429;\">幻灯可以使用纯色来实现</span></li>\n<li><span style=\"line-height:1.428571429;\">实现产品自定义属性功能</span></li>\n<li><span style=\"line-height:1.428571429;\">解决一键安装包qq开放登录的问题</span></li>\n</ol><h4>二、下载地址</h4>\n<p>源码包：<a href=\"http://dl.xirangit.com/eps/2.3/chanzhiEPS.2.3.zip\">http://dl.xirangit.com/eps/2.3/chanzhiEPS.2.3.zip</a></p>\n<h4>三、安装和升级文档</h4>\n<p>安装文档：<a href=\"http://www.chanzhi.org/book/chanzhieps/5.html\">http://www.chanzhi.org/book/chanzhieps/5.html</a></p>\n<p>升级文档：<a href=\"http://www.chanzhi.org/book/chanzhieps/68.html\">http://www.chanzhi.org/book/chanzhieps/68.html</a></p>\n<h4>四、演示</h4>\n<p>前台演示：<a href=\"http://demo.chanzhi.org/\">http://demo.chanzhi.org</a></p>\n<p>后台演示：<a href=\"http://demo.chanzhi.org/chanzhiadmin.php\">http://demo.chanzhi.org/chanzhiadmin.php</a></p>\n<h4>五、功能截图</h4>\n<p><img src=\"http://www.chanzhi.org/data/upload/201405/f_621601c6a91fdeaf4d0ae19ad6407191.gif\" alt=\"\" /></p>\n<p><img src=\"http://www.chanzhi.org/data/upload/201405/f_630c95eeafa23d91cd7cbf61635d263f.gif\" alt=\"\" /></p>', 'original', '', '', 'admin', '', '', '2014-05-16 10:10:00', '2014-08-25 15:20:58', 'normal', 'article', '0', 12, '0', '0000-00-00 00:00:00', '0', 0, '', '', '', '0', 'zh-cn'),
(8, '蝉知企业门户2.2.1版本发布', '', 'chanzhieps2.2.1', '企业建站系统,企业门户,开源CMS,免费cms', '小更新，蝉知2.2.1发布，这次更新主要是解决一些bug，加一些细节调整。', '<h4>一、2.2.1修改记录</h4>\n<p>  1 调整评论页面的文案。</p>\n  2 联系我们页面增加二维码展示。<br />\n  3 密码错误触发锁定次数增加到5次，禁用时间缩短到3分钟。<br />\n  4 博客列表评论按钮添加链接。 <br />\n  5 会员管理页面添加微博和qq会员的显示。<br />\n  6 修改在线QQ的连接。<br /><p>  7 把oauth类的get方法去掉file_get_contents方式，只用CURL方式。</p>\n<p>  8 解决php magic_quotes_gpc 打开时中文内容存储失败的bug。 </p>\n<p><span style=\"color:inherit;font-size:16px;font-weight:bold;line-height:1.1;\"><br /></span></p>\n<p><span style=\"color:inherit;font-size:16px;font-weight:bold;line-height:1.1;\">二、下载地址</span></p>\n<p><span style=\"font-size:14px;line-height:1.428571429;\">源码包：</span><a href=\"http://dl.xirangit.com/eps/2.2/chanzhiEPS.2.2.1.zip\">http://dl.xirangit.com/eps/2.2/chanzhiEPS.2.2.1.zip</a></p>\n<p>安装包：<a href=\"http://dl.xirangit.com/eps/2.2/chanzhiEPS.2.2.1.exe\">http://dl.xirangit.com/eps/2.2/chanzhiEPS.2.2.1.exe</a></p>\n<p><br /></p>\n<p><span style=\"color:inherit;font-size:16px;font-weight:bold;line-height:1.1;\">三、安装和升级文档  </span></p>\n<p>安装文档：<a href=\"http://www.chanzhi.org/book/chanzhieps/5.html\">http://www.chanzhi.org/book/chanzhieps/5.html</a></p>\n<p>升级文档：<a href=\"http://www.chanzhi.org/book/chanzhieps/68.html\">http://www.chanzhi.org/book/chanzhieps/68.html</a></p>\n<p><br /></p>\n<p>前台演示：<a href=\"http://demo.chanzhi.org/\">http://demo.chanzhi.org</a></p>\n<p>后台演示：<a href=\"http://demo.chanzhi.org/chanzhiadmin.php\">http://demo.chanzhi.org/chanzhiadmin.php</a></p>', 'original', '', '', 'admin', '', '', '2014-04-01 10:40:00', '2014-08-25 15:22:03', 'normal', 'article', '0', 12, '0', '0000-00-00 00:00:00', '0', 0, '', '', '', '0', 'zh-cn'),
(9, '蝉知企业门户2.2版本发布，全面集成微信！', '', 'chanzhieps2.2', '微信营销系统,微网站,企业建站,移动建站', '大家好，蝉知企业门户系统2.2正式版正式发布了！这次升级集成了微信公众号的应用，主要功能有：公众号接入、公众号菜单定义、关键字自动回复设置、二维码显示、粉丝消息获取和回复、粉丝管理。另外还添加了新的宽屏主题、重新组成后台反馈相关的功能，使用更加方便。', '<p>大家好，蝉知企业门户系统2.2正式版正式发布了！该版本全面集成了微信公众号平台，包括：公众号接入、公众号菜单定义、关键字自动回复设置、二维码显示、粉丝消息获取和回复、粉丝管理。另外还添加了新的宽屏主题、重新组成后台反馈相关的功能，使用更加方便。</p>\n<h4>一、修改记录</h4>\n<ol><li><span style=\"line-height:1.428571429;\">后台设置logo页面调整</span></li>\n<li><span style=\"line-height:1.428571429;\">论坛帖子用户信息调整</span></li>\n<li><span style=\"line-height:1.428571429;\">调整反馈，将留言、评论、主题、回帖，将其集中在一起。</span></li>\n<li><span style=\"line-height:1.428571429;\">添加微信公众号接入功能</span></li>\n<li><span style=\"line-height:1.428571429;\">添加公众号会员查看功能</span></li>\n<li><span style=\"line-height:1.428571429;\">添加公众号消息管理功能</span></li>\n<li><span style=\"line-height:1.428571429;\">添加公众号菜单、关键字、订阅回复、默认回复的管理功能</span></li>\n<li><span style=\"line-height:1.428571429;\">新增宽屏主题</span></li>\n<li><span style=\"line-height:1.428571429;\">前台添加微信公众号和手机访问二维码显示</span></li>\n<li><span style=\"line-height:1.428571429;\">禁止百度自动转码</span><span style=\"line-height:1.428571429;\">。</span><br /></li>\n</ol><h4 style=\"color:#333333;\">二、新特性截图</h4>\n<p><br /></p>\n<p><strong>2.1 前台显示微信公众号的二维码以及当前网址的二维码。</strong><strong><br /></strong></p>\n<p><strong><img src=\"http://www.chanzhi.org/data/upload/201403/f_0f4feaade60a500a295320cf7f57b7b2.jpg\" alt=\"\" /></strong><strong><br /></strong></p>\n<p><strong><br /></strong></p>\n<p><strong>2.2 后台的微信功能设置</strong><strong><br /></strong></p>\n<p><strong><img src=\"http://www.chanzhi.org/data/upload/201403/f_6fd64ba21b03ee7a1b4b2cdb019ef7bd.jpg\" alt=\"\" /><br /></strong></p>\n<p><strong><br /></strong></p>\n<p><strong>2.3 微信界面截图</strong></p>\n<p><strong><img src=\"http://www.chanzhi.org/data/upload/201403/f_e1aa3a6106f7f37395d42e637254091a.jpg\" alt=\"\" /><br /></strong></p>\n<h4 style=\"color:#333333;\">三、下载地址</h4>\n<p>源码包：<a href=\"http://dl.xirangit.com/eps/2.2/chanzhiEPS.2.2.zip\">http://dl.xirangit.com/eps/2.2/chanzhiEPS.2.2.zip</a></p>\n<p>安装包：<a href=\"http://dl.xirangit.com/eps/2.2/chanzhiEPS.2.2.exe\">http://dl.xirangit.com/eps/2.2/chanzhiEPS.2.2.exe</a></p>\n<p><br /></p>\n<p><span style=\"color:inherit;font-size:16px;font-weight:bold;line-height:1.1;\">四、安装和升级文档  </span></p>\n<p>安装文档：<a href=\"http://www.chanzhi.org/book/chanzhieps/5.html\">http://www.chanzhi.org/book/chanzhieps/5.html</a></p>\n<p>升级文档：<a href=\"http://www.chanzhi.org/book/chanzhieps/68.html\">http://www.chanzhi.org/book/chanzhieps/68.html</a></p>\n<p><br /></p>\n<p>前台演示：<a href=\"http://demo.chanzhi.org/\">http://demo.chanzhi.org</a></p>\n<p>后台演示：<a href=\"http://demo.chanzhi.org/chanzhiadmin.php\">http://demo.chanzhi.org/chanzhiadmin.php</a></p>\n<p><br /></p>\n<p><span style=\"color:inherit;font-size:16px;font-weight:bold;line-height:1.1;\">五、蝉知系统微信集成手册</span></p>\n<p><span style=\"color:inherit;font-size:16px;font-weight:bold;line-height:1.1;\"><br /></span></p>\n<p>蝉知系统微信集成手册：<a href=\"http://www.chanzhi.org/book/weixin.html\">http://www.chanzhi.org/book/weixin.html</a></p>', 'original', '', '', 'admin', '', '', '2014-03-24 16:00:00', '2014-08-25 15:24:48', 'normal', 'article', '0', 12, '0', '0000-00-00 00:00:00', '0', 0, '', '', '', '0', 'zh-cn'),
(10, '蝉知企业门户系统2.1正式版发布', '', 'chanzhieps2.1', '手机建站系统,企业建站系统,微信网站,免费企业建站', '大家好，蝉知企业门户系统2.1正式版今天正式发布了。这次升级主要是手机终端界面的优化和区块功能改进，同时还解决了之前版本产品和博客分页功能等bug。', '<h4 style=\"color:#333333;\">一、2.1修改记录</h4>\n<ol><li>区块增加图标设置功能</li>\n<li>布局设置增加区块宽度设置功能</li>\n<li>触屏设备访问时幻灯片增加拖动支持</li>\n<li><span style=\"line-height:1.428571429;\">论坛帖子最后编辑者改为真实姓名</span></li>\n<li><span style=\"line-height:1.428571429;\">关于我们页面使用区块把联系我们放在右侧</span></li>\n<li><span style=\"line-height:1.428571429;\">批量维护手册章节的时候添加发布时间</span></li>\n<li><span style=\"line-height:1.428571429;\">编辑手册文章的时候增加发布时间的字段</span></li>\n<li><span style=\"line-height:1.428571429;\">重新调整h1-h6标签的字体大小</span></li>\n<li><span style=\"line-height:1.428571429;\">解决置顶帖子用户姓名问题</span></li>\n<li><span style=\"line-height:1.428571429;\">修改版权提示的格式</span></li>\n<li><span style=\"line-height:1.428571429;\">修复分页的bug</span></li>\n<li><span style=\"line-height:1.428571429;\">幻灯排序在ie10下面有问题。</span></li>\n<li><span style=\"line-height:1.428571429;\">修复ie10下面蓝色风格的问题</span></li>\n<li><span style=\"line-height:1.428571429;\">精简文章详情页面的上一篇下一篇的导航文字</span></li>\n<li><span style=\"line-height:1.428571429;\">调整留言页面回复内容的缩进和字体大小</span></li>\n<li><span style=\"line-height:1.428571429;\">优化移动版本头尾的处理</span></li>\n<li><span style=\"line-height:1.428571429;\">管理员身份回帖的时候应当使用全编辑器</span></li>\n<li><span style=\"line-height:1.428571429;\">论坛帖子发贴框的宽度调整。把只读放在后面。</span></li>\n<li><span style=\"line-height:1.428571429;\">调整论坛列表页面各列的宽度</span></li>\n<li><span style=\"line-height:1.428571429;\">以管理员身份发表评论或者留言，默认状态为通过。</span></li>\n<li><span style=\"line-height:1.428571429;\">后台管理员回复一篇评论或留言之后，默认将其状态改为通过</span></li>\n<li><span style=\"line-height:1.428571429;\">修改邮箱默认配置，将腾讯邮箱默认改为465 </span></li>\n<li><span style=\"line-height:1.428571429;\">如果发贴用户已被删除，帖子列表页面的最后回复取用户名</span></li>\n<li><span style=\"line-height:1.428571429;\">论坛出现版主的地方也都显示真实姓名</span></li>\n<li><span style=\"line-height:1.428571429;\">将user模块的getRealName()方法改为getRealNamePairs()</span></li>\n<li><span style=\"line-height:1.428571429;\">调整模拟的alert和confirm框的样式</span></li>\n<li><span style=\"line-height:1.428571429;\">论坛帖子列表的时候显示用户的真实姓名</span></li>\n<li><span style=\"line-height:1.428571429;\">留言者区分是否是登录用户</span></li>\n<li><span style=\"line-height:1.428571429;\">论坛的板块设置提示需要二级板块</span></li>\n<li><span style=\"line-height:1.428571429;\">区块首页底部的命名改为中部。</span></li>\n<li><span style=\"line-height:1.428571429;\">调整文章，产品无类目时的交互方式</span></li>\n<li><span style=\"line-height:1.428571429;\">重置密码功能把resetKey，resetTime合成一个字段</span></li>\n<li><span style=\"line-height:1.428571429;\">论坛控制图片大小</span></li>\n</ol><h4 style=\"color:#333333;\">二、手机访问截图</h4>\n<p><img src=\"http://www.chanzhi.org/data/upload/201403/f_59e4b4d8216516649c97804813b14af2.jpg\" alt=\"\" title=\"\" height=\"540\" width=\"304\" /><img src=\"http://www.chanzhi.org/data/upload/201403/f_702d92775d4dcdd983e5be1d998d566b.jpg\" alt=\"\" title=\"\" height=\"540\" width=\"304\" /></p>\n<p><img src=\"http://www.chanzhi.org/data/upload/201403/f_4ca0b9700f909cabc75ecc00f60ee7a0.jpg\" alt=\"\" title=\"\" height=\"540\" width=\"304\" /><img src=\"http://www.chanzhi.org/data/upload/201403/f_0831fb8306a661c9ab6cb1a87d16b5ba.jpg\" alt=\"\" title=\"\" height=\"540\" width=\"304\" /><img src=\"http://www.chanzhi.org/data/upload/201403/f_dfa6504be3a605561262e18d4d5eb63f.png\" alt=\"\" title=\"\" height=\"540\" width=\"304\" /></p>\n<h4 style=\"color:#333333;\">三、下载地址</h4>\n<p>源码包：<a href=\"http://dl.xirangit.com/eps/2.1/chanzhiEPS.2.1.zip\">http://dl.xirangit.com/eps/2.1/chanzhiEPS.2.1.zip</a><br />\n安装包：<a href=\"http://dl.xirangit.com/eps/2.1/chanzhiEPS.2.1.exe\">http://dl.xirangit.com/eps/2.1/chanzhiEPS.2.1.exe</a></p>\n<h4 style=\"color:#333333;\">四、安装和升级文档  </h4>\n<p>安装文档：<a href=\"http://www.chanzhi.org/book/chanzhieps/5.html\">http://www.chanzhi.org/book/chanzhieps/5.html</a><br />\n升级文档：<a href=\"http://www.chanzhi.org/book/chanzhieps/68.html\">http://www.chanzhi.org/book/chanzhieps/68.html</a><br />\n前台演示：<a href=\"http://demo.chanzhi.org/\">http://demo.chanzhi.org</a></p>\n<p>后台演示：<a href=\"http://demo.chanzhi.org/chanzhiadmin.php\">http://demo.chanzhi.org/chanzhiadmin.php</a></p>', 'original', '', '', 'admin', '', '', '2014-03-03 09:50:00', '2014-08-25 15:26:45', 'normal', 'article', '0', 12, '0', '0000-00-00 00:00:00', '0', 0, '', '', '', '0', 'zh-cn'),
(11, '关于我们', '', 'about', '', '', '这好', 'original', '', '', '', '', '', '2014-10-08 14:38:00', '2014-10-08 17:40:23', 'normal', 'page', '0', 1, '0', '0000-00-00 00:00:00', '0', 0, '', '', '', '0', 'zh-cn'),
(12, '明天还是明天', '', '', '', '', '明天还是明天', 'original', '', '', 'demo', '', '', '2014-10-08 17:44:00', '2014-10-08 17:44:59', 'normal', 'article', '0', 7, '0', '0000-00-00 00:00:00', '0', 0, '', '', '', '0', 'zh-cn');

-- --------------------------------------------------------

--
-- 表的结构 `eps_bearlog`
--

CREATE TABLE `eps_bearlog` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `type` varchar(10) NOT NULL,
  `objectType` varchar(30) NOT NULL,
  `objectID` mediumint(9) NOT NULL,
  `url` varchar(255) NOT NULL,
  `account` varchar(30) NOT NULL,
  `status` char(30) NOT NULL,
  `response` text NOT NULL,
  `time` datetime NOT NULL,
  `auto` enum('yes','no') NOT NULL,
  `lang` char(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `eps_blacklist`
--

CREATE TABLE `eps_blacklist` (
  `type` varchar(30) NOT NULL,
  `identity` varchar(100) NOT NULL,
  `reason` varchar(100) NOT NULL,
  `expiredDate` datetime NOT NULL,
  `addedDate` datetime NOT NULL,
  `times` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `lang` char(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `eps_block`
--

CREATE TABLE `eps_block` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `originID` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `effectID` mediumint(8) UNSIGNED NOT NULL DEFAULT '0',
  `template` varchar(30) NOT NULL DEFAULT 'default',
  `type` varchar(20) NOT NULL,
  `title` varchar(60) NOT NULL,
  `content` text NOT NULL,
  `lang` char(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `eps_block`
--

INSERT INTO `eps_block` (`id`, `originID`, `effectID`, `template`, `type`, `title`, `content`, `lang`) VALUES
(1, 0, 0, 'default', 'latestArticle', '最新文章', '{\"category\":\"0\",\"limit\":\"7\"}', 'zh-cn'),
(2, 0, 0, 'default', 'hotArticle', '热门文章', '{\"category\":\"0\",\"limit\":\"7\"}', 'zh-cn'),
(3, 0, 0, 'default', 'latestProduct', '最新产品', '{\"category\":\"0\",\"limit\":\"3\",\"image\":\"show\"}', 'zh-cn'),
(4, 0, 0, 'default', 'hotProduct', '热门产品', '{\"category\":\"0\",\"limit\":\"3\",\"image\":\"show\"}', 'zh-cn'),
(5, 0, 0, 'default', 'slide', '幻灯片', '{\"group\":\"15\"}', 'zh-cn'),
(6, 0, 0, 'default', 'articleTree', '文章分类', '{\"showChildren\":\"0\"}', 'zh-cn'),
(7, 0, 0, 'default', 'productTree', '产品分类', '{\"showChildren\":\"0\"}', 'zh-cn'),
(8, 0, 0, 'default', 'blogTree', '博客分类', '{\"showChildren\":\"1\"}', 'zh-cn'),
(9, 0, 0, 'default', 'pageList', '单页列表', '{\"limit\":\"7\"}', 'zh-cn'),
(10, 0, 0, 'default', 'contact', '联系我们', '', 'zh-cn'),
(11, 0, 0, 'default', 'about', '公司简介', '', 'zh-cn'),
(12, 0, 0, 'default', 'links', '友情链接', '', 'zh-cn'),
(13, 0, 0, 'default', 'header', '网站头部', '', 'zh-cn'),
(14, 0, 0, 'default', 'followUs', '关注我们', '', 'zh-cn'),
(15, 0, 0, 'default', 'subscribe', '订阅博客', '', 'zh-cn'),
(21, 0, 0, 'mobile', 'latestArticle', '最新文章', '{\"category\":\"0\",\"limit\":\"7\"}', 'zh-cn'),
(22, 0, 0, 'mobile', 'hotArticle', '热门文章', '{\"category\":\"0\",\"limit\":\"7\"}', 'zh-cn'),
(23, 0, 0, 'mobile', 'latestProduct', '最新产品', '{\"category\":\"0\",\"limit\":\"3\",\"image\":\"show\"}', 'zh-cn'),
(24, 0, 0, 'mobile', 'hotProduct', '热门产品', '{\"category\":\"0\",\"limit\":\"3\",\"image\":\"show\"}', 'zh-cn'),
(25, 0, 0, 'mobile', 'slide', '手机版幻灯片', '', 'zh-cn'),
(26, 0, 0, 'mobile', 'articleTree', '文章分类', '{\"showChildren\":\"0\"}', 'zh-cn'),
(27, 0, 0, 'mobile', 'productTree', '产品分类', '{\"showChildren\":\"0\"}', 'zh-cn'),
(28, 0, 0, 'mobile', 'blogTree', '博客分类', '{\"showChildren\":\"1\"}', 'zh-cn'),
(29, 0, 0, 'mobile', 'pageList', '单页列表', '{\"limit\":\"7\"}', 'zh-cn'),
(30, 0, 0, 'mobile', 'contact', '联系我们', '', 'zh-cn'),
(31, 0, 0, 'mobile', 'about', '公司简介', '', 'zh-cn'),
(32, 0, 0, 'mobile', 'links', '友情链接', '', 'zh-cn'),
(33, 0, 0, 'mobile', 'followUs', '关注我们', '', 'zh-cn'),
(34, 0, 0, 'mobile', 'header', '网站头部', '', 'zh-cn'),
(101, 0, 0, 'default', 'latestArticle', 'Latest Article', '{\"category\":\"0\",\"limit\":\"7\"}', 'en'),
(102, 0, 0, 'default', 'hotArticle', 'Hot Article', '{\"category\":\"0\",\"limit\":\"7\"}', 'en'),
(103, 0, 0, 'default', 'latestProduct', 'Latest Product', '{\"category\":\"0\",\"limit\":\"3\",\"image\":\"show\"}', 'en'),
(104, 0, 0, 'default', 'hotProduct', 'Hot Product', '{\"category\":\"0\",\"limit\":\"3\",\"image\":\"show\"}', 'en'),
(105, 0, 0, 'default', 'slide', 'Slide', '{\"group\":\"15\"}', 'en'),
(106, 0, 0, 'default', 'articleTree', 'Article Category', '{\"showChildren\":\"0\"}', 'en'),
(107, 0, 0, 'default', 'productTree', 'Product Category', '{\"showChildren\":\"0\"}', 'en'),
(108, 0, 0, 'default', 'blogTree', 'Blog Category', '{\"showChildren\":\"1\"}', 'en'),
(109, 0, 0, 'default', 'pageList', 'Page List', '{\"limit\":\"7\"}', 'en'),
(110, 0, 0, 'default', 'contact', 'Contact Us', '', 'en'),
(111, 0, 0, 'default', 'about', 'About Us', '', 'en'),
(112, 0, 0, 'default', 'links', 'Link', '', 'en'),
(113, 0, 0, 'default', 'header', 'Header', '', 'en'),
(114, 0, 0, 'default', 'followUs', 'Follow Us', '', 'en'),
(115, 0, 0, 'default', 'subscribe', 'Subscribe', '', 'en'),
(121, 0, 0, 'mobile', 'latestArticle', 'Latest Article', '{\"category\":\"0\",\"limit\":\"7\"}', 'en'),
(122, 0, 0, 'mobile', 'hotArticle', 'Hot Article', '{\"category\":\"0\",\"limit\":\"7\"}', 'en'),
(123, 0, 0, 'mobile', 'latestProduct', 'Latest Product', '{\"category\":\"0\",\"limit\":\"3\",\"image\":\"show\"}', 'en'),
(124, 0, 0, 'mobile', 'hotProduct', 'Hot Product', '{\"category\":\"0\",\"limit\":\"3\",\"image\":\"show\"}', 'en'),
(125, 0, 0, 'mobile', 'slide', 'Mobile Slide', '', 'en'),
(126, 0, 0, 'mobile', 'articleTree', 'Article Category', '{\"showChildren\":\"0\"}', 'en'),
(127, 0, 0, 'mobile', 'productTree', 'Product Category', '{\"showChildren\":\"0\"}', 'en'),
(128, 0, 0, 'mobile', 'blogTree', 'Blog Category', '{\"showChildren\":\"1\"}', 'en'),
(129, 0, 0, 'mobile', 'pageList', 'Page List', '{\"limit\":\"7\"}', 'en'),
(130, 0, 0, 'mobile', 'contact', 'Contact Us', '', 'en'),
(131, 0, 0, 'mobile', 'about', 'About Us', '', 'en'),
(132, 0, 0, 'mobile', 'links', 'Link', '', 'en'),
(133, 0, 0, 'mobile', 'followUs', 'Follow Us', '', 'en'),
(134, 0, 0, 'mobile', 'header', 'Header', '', 'en'),
(201, 0, 0, 'default', 'latestArticle', '最新文章', '{\"category\":\"0\",\"limit\":\"7\"}', 'zh-tw'),
(202, 0, 0, 'default', 'hotArticle', '熱門文章', '{\"category\":\"0\",\"limit\":\"7\"}', 'zh-tw'),
(203, 0, 0, 'default', 'latestProduct', '最新產品', '{\"category\":\"0\",\"limit\":\"3\",\"image\":\"show\"}', 'zh-tw'),
(204, 0, 0, 'default', 'hotProduct', '熱門產品', '{\"category\":\"0\",\"limit\":\"3\",\"image\":\"show\"}', 'zh-tw'),
(205, 0, 0, 'default', 'slide', '幻燈片', '{\"group\":\"15\"}', 'zh-tw'),
(206, 0, 0, 'default', 'articleTree', '文章分類', '{\"showChildren\":\"0\"}', 'zh-tw'),
(207, 0, 0, 'default', 'productTree', '產品分類', '{\"showChildren\":\"0\"}', 'zh-tw'),
(208, 0, 0, 'default', 'blogTree', '博客分類', '{\"showChildren\":\"1\"}', 'zh-tw'),
(209, 0, 0, 'default', 'pageList', '單頁列表', '{\"limit\":\"7\"}', 'zh-tw'),
(210, 0, 0, 'default', 'contact', '聯繫我們', '', 'zh-tw'),
(211, 0, 0, 'default', 'about', '公司簡介', '', 'zh-tw'),
(212, 0, 0, 'default', 'links', '友情鏈接', '', 'zh-tw'),
(213, 0, 0, 'default', 'header', '網站頭部', '', 'zh-tw'),
(214, 0, 0, 'default', 'followUs', '關注我們', '', 'zh-tw'),
(215, 0, 0, 'default', 'subscribe', '訂閱博客', '', 'zh-tw'),
(221, 0, 0, 'mobile', 'latestArticle', '最新文章', '{\"category\":\"0\",\"limit\":\"7\"}', 'zh-tw'),
(222, 0, 0, 'mobile', 'hotArticle', '熱門文章', '{\"category\":\"0\",\"limit\":\"7\"}', 'zh-tw'),
(223, 0, 0, 'mobile', 'latestProduct', '最新產品', '{\"category\":\"0\",\"limit\":\"3\",\"image\":\"show\"}', 'zh-tw'),
(224, 0, 0, 'mobile', 'hotProduct', '熱門產品', '{\"category\":\"0\",\"limit\":\"3\",\"image\":\"show\"}', 'zh-tw'),
(225, 0, 0, 'mobile', 'slide', '手機版幻燈片', '', 'zh-tw'),
(226, 0, 0, 'mobile', 'articleTree', '文章分類', '{\"showChildren\":\"0\"}', 'zh-tw'),
(227, 0, 0, 'mobile', 'productTree', '產品分類', '{\"showChildren\":\"0\"}', 'zh-tw'),
(228, 0, 0, 'mobile', 'blogTree', '博客分類', '{\"showChildren\":\"1\"}', 'zh-tw'),
(229, 0, 0, 'mobile', 'pageList', '單頁列表', '{\"limit\":\"7\"}', 'zh-tw'),
(230, 0, 0, 'mobile', 'contact', '聯繫我們', '', 'zh-tw'),
(231, 0, 0, 'mobile', 'about', '公司簡介', '', 'zh-tw'),
(232, 0, 0, 'mobile', 'links', '友情鏈接', '', 'zh-tw'),
(233, 0, 0, 'mobile', 'followUs', '關注我們', '', 'zh-tw'),
(234, 0, 0, 'mobile', 'header', '網站頭部', '', 'zh-tw');

-- --------------------------------------------------------

--
-- 表的结构 `eps_book`
--

CREATE TABLE `eps_book` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `articleID` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `title` varchar(150) NOT NULL,
  `alias` varchar(100) NOT NULL,
  `keywords` varchar(150) NOT NULL,
  `summary` text NOT NULL,
  `content` text NOT NULL,
  `type` enum('book','chapter','article') NOT NULL,
  `parent` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `path` char(255) NOT NULL DEFAULT '',
  `grade` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `author` varchar(60) NOT NULL,
  `editor` varchar(60) NOT NULL,
  `addedDate` datetime NOT NULL,
  `editedDate` datetime NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'normal',
  `views` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `order` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `link` varchar(255) NOT NULL,
  `lang` char(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `eps_book`
--

INSERT INTO `eps_book` (`id`, `articleID`, `title`, `alias`, `keywords`, `summary`, `content`, `type`, `parent`, `path`, `grade`, `author`, `editor`, `addedDate`, `editedDate`, `status`, `views`, `order`, `link`, `lang`) VALUES
(1, 0, '常见问题', 'faq', '', '在使用蝉知企业门户系统的过程中，遇到的常见问题解答。', '', 'book', 0, ',1,', 1, 'admin', 'demo', '2014-08-25 14:00:07', '2014-08-26 11:42:41', 'normal', 0, 1, '', 'zh-cn'),
(2, 0, '常见问题', '', '', '', '<span style=\"color:#333333;font-family:\'Helvetica Neue\', Helvetica, Tahoma, Arial, sans-serif;line-height:22px;background-color:#FFFFFF;\"><span style=\"font-weight:700;\">1、蝉知密码加密逻辑是什么？</span></span><br /><span style=\"color:#333333;font-family:\'Helvetica Neue\', Helvetica, Tahoma, Arial, sans-serif;line-height:22px;background-color:#FFFFFF;\">md5(md5(password).aacount))</span><br /><br /><span style=\"color:#333333;font-family:\'Helvetica Neue\', Helvetica, Tahoma, Arial, sans-serif;line-height:22px;background-color:#FFFFFF;\"><span style=\"font-weight:700;\">2、重装蝉知系统怎么操作？</span></span><br /><span style=\"color:#333333;font-family:\'Helvetica Neue\', Helvetica, Tahoma, Arial, sans-serif;line-height:22px;background-color:#FFFFFF;\">config/my.php把install设成false。或者把config/my.php删掉，重新安装就可以了。</span><br /><br /><span style=\"color:#333333;font-family:\'Helvetica Neue\', Helvetica, Tahoma, Arial, sans-serif;line-height:22px;background-color:#FFFFFF;\"><span style=\"font-weight:700;\">3、蝉知代码修改过，升级会不会导致冲突，原先的设置会改动掉吗？</span></span><br /><p style=\"color:#333333;font-family:\'Helvetica Neue\', Helvetica, Tahoma, Arial, sans-serif;background-color:#FFFFFF;\"><span>用我们的扩展体系的话代码不会覆盖。</span></p>\n<p style=\"color:#333333;font-family:\'Helvetica Neue\', Helvetica, Tahoma, Arial, sans-serif;background-color:#FFFFFF;\"><span>最起码可以保证修改的代码和主干代码从文件存储上隔离的，不会造成代码被覆盖。</span></p>\n<p style=\"color:#333333;font-family:\'Helvetica Neue\', Helvetica, Tahoma, Arial, sans-serif;background-color:#FFFFFF;\"><span>功能可能会有冲突，适当做一些调整就可以了。</span></p>\n<br /><span style=\"color:#333333;font-family:\'Helvetica Neue\', Helvetica, Tahoma, Arial, sans-serif;line-height:22px;background-color:#FFFFFF;\"><span style=\"font-weight:700;\">4、蝉知安装跳过设置管理员密码步骤的问题。</span></span><br /><span style=\"color:#333333;font-family:\'Helvetica Neue\', Helvetica, Tahoma, Arial, sans-serif;line-height:22px;background-color:#FFFFFF;\">找下安装时的错误日志，估计是php的session设置有问题。</span><br /><span style=\"color:#333333;font-family:\'Helvetica Neue\', Helvetica, Tahoma, Arial, sans-serif;line-height:22px;background-color:#FFFFFF;\">具体可参照：<a href=\"http://www.chanzhi.org/thread/177.html\">http://www.chanzhi.org/thread/177.html</a></span><br /><br /><span style=\"color:#333333;font-family:\'Helvetica Neue\', Helvetica, Tahoma, Arial, sans-serif;line-height:22px;background-color:#FFFFFF;\"><span style=\"font-weight:700;\">5、如何配置服务器使用静态url功能?</span></span><br /><span style=\"color:#333333;font-family:\'Helvetica Neue\', Helvetica, Tahoma, Arial, sans-serif;line-height:22px;background-color:#FFFFFF;\">首先服务器要支持url重写。如果服务器支持把system/config/my.php里面的get改成PATH_INFO（大写）</span><br /><span style=\"color:#333333;font-family:\'Helvetica Neue\', Helvetica, Tahoma, Arial, sans-serif;line-height:22px;background-color:#FFFFFF;\">具体可参照：<a href=\"http://www.chanzhi.org/book/chanzhieps/62.html\">http://www.chanzhi.org/book/chanzhieps/62.html</a></span><br /><br /><span style=\"color:#333333;font-family:\'Helvetica Neue\', Helvetica, Tahoma, Arial, sans-serif;line-height:22px;background-color:#FFFFFF;\"><span style=\"font-weight:700;\">6、已经配置静态url，为什么不能实现收录？</span></span><br /><span style=\"color:#333333;font-family:\'Helvetica Neue\', Helvetica, Tahoma, Arial, sans-serif;line-height:22px;background-color:#FFFFFF;\">百度有沙盒期，长的有一个月。</span><br /><br /><span style=\"color:#333333;font-family:\'Helvetica Neue\', Helvetica, Tahoma, Arial, sans-serif;line-height:22px;background-color:#FFFFFF;\"><span style=\"font-weight:700;\">7、蝉知后台的管理员密码忘了怎么办？</span></span><br /><span style=\"color:#333333;font-family:\'Helvetica Neue\', Helvetica, Tahoma, Arial, sans-serif;line-height:22px;background-color:#FFFFFF;\">从前台注册一个账号，把数据库admin字段改成super。</span><br /><br /><span style=\"color:#333333;font-family:\'Helvetica Neue\', Helvetica, Tahoma, Arial, sans-serif;line-height:22px;background-color:#FFFFFF;\"><span style=\"font-weight:700;\">8、本机上调试好网站和数据库上传服务器，域名和数据库配置在哪里改？</span></span><br /><span style=\"color:#333333;font-family:\'Helvetica Neue\', Helvetica, Tahoma, Arial, sans-serif;line-height:22px;background-color:#FFFFFF;\">在config/my.php修改。另外不建议本地搭建再上传，环境不一致可能会产生一些问题，直接线上安装最保险。</span><br /><br /><span style=\"color:#333333;font-family:\'Helvetica Neue\', Helvetica, Tahoma, Arial, sans-serif;line-height:22px;background-color:#FFFFFF;\"><span style=\"font-weight:700;\">9、如何做代码调试，查找错误？</span></span><br /><span style=\"color:#333333;font-family:\'Helvetica Neue\', Helvetica, Tahoma, Arial, sans-serif;line-height:22px;background-color:#FFFFFF;\">把config/my.php里面的debug可以设为2。</span><br /><span style=\"color:#333333;font-family:\'Helvetica Neue\', Helvetica, Tahoma, Arial, sans-serif;line-height:22px;background-color:#FFFFFF;\">或者在tmp/log/ 当天的日志里查找。</span><br /><br /><span style=\"color:#333333;font-family:\'Helvetica Neue\', Helvetica, Tahoma, Arial, sans-serif;line-height:22px;background-color:#FFFFFF;\"><span style=\"font-weight:700;\">10、云蝉知注册/解析了域名，怎么找不到了？</span></span><br /><span style=\"color:#333333;font-family:\'Helvetica Neue\', Helvetica, Tahoma, Arial, sans-serif;line-height:22px;background-color:#FFFFFF;\">如果一个月域名没解析的话，后台会自动删除域名。</span><br /><span style=\"color:#333333;font-family:\'Helvetica Neue\', Helvetica, Tahoma, Arial, sans-serif;line-height:22px;background-color:#FFFFFF;\">或者是域名解析不成功，推荐使用DNSPOD解析。</span><br /><br /><span style=\"color:#333333;font-family:\'Helvetica Neue\', Helvetica, Tahoma, Arial, sans-serif;line-height:22px;background-color:#FFFFFF;\"><span style=\"font-weight:700;\">11、文章分类不想按照最新排列，文章排序置顶如何设置？</span></span><br /><span style=\"color:#333333;font-family:\'Helvetica Neue\', Helvetica, Tahoma, Arial, sans-serif;line-height:22px;background-color:#FFFFFF;\">文章是按照发布时间排列的，直接编辑发布时间就可以实现。</span><br /><br /><span style=\"color:#333333;font-family:\'Helvetica Neue\', Helvetica, Tahoma, Arial, sans-serif;line-height:22px;background-color:#FFFFFF;\"><span style=\"font-weight:700;\">12、类目描述不超过150个字，这个怎么修改？</span></span><br /><span style=\"color:#333333;font-family:\'Helvetica Neue\', Helvetica, Tahoma, Arial, sans-serif;line-height:22px;background-color:#FFFFFF;\">修改eps_category表里面的desc字段。</span><br /><br /><span style=\"color:#333333;font-family:\'Helvetica Neue\', Helvetica, Tahoma, Arial, sans-serif;line-height:22px;background-color:#FFFFFF;\"><span style=\"font-weight:700;\">13、论坛设置了版块，为什么前台没有显示？</span></span><br /><span style=\"color:#333333;font-family:\'Helvetica Neue\', Helvetica, Tahoma, Arial, sans-serif;line-height:22px;background-color:#FFFFFF;\">论坛版块需要设置两级版块才能正常显示。</span><br /><br /><span style=\"color:#333333;font-family:\'Helvetica Neue\', Helvetica, Tahoma, Arial, sans-serif;line-height:22px;background-color:#FFFFFF;\"><span style=\"font-weight:700;\">14、统计代码要怎么加到网站？</span></span><br /><span style=\"color:#333333;font-family:\'Helvetica Neue\', Helvetica, Tahoma, Arial, sans-serif;line-height:22px;background-color:#FFFFFF;\">可以参照：<a href=\"http://www.chanzhi.org/book/chanzhieps/83.html\">http://www.chanzhi.org/book/chanzhieps/83.html</a></span><br /><span style=\"color:#333333;font-family:\'Helvetica Neue\', Helvetica, Tahoma, Arial, sans-serif;line-height:22px;background-color:#FFFFFF;\">营销QQ，百度统计、地图等都可参考统计代码的添加方法。位置都可以通过css或者js控制。</span><br /><br /><span style=\"color:#333333;font-family:\'Helvetica Neue\', Helvetica, Tahoma, Arial, sans-serif;line-height:22px;background-color:#FFFFFF;\"><span style=\"font-weight:700;\">15、如何通过区块用css控制云蝉知站点样式?</span></span><br /><span style=\"color:#333333;font-family:\'Helvetica Neue\', Helvetica, Tahoma, Arial, sans-serif;line-height:22px;background-color:#FFFFFF;\">可以参照：<a href=\"http://www.chanzhi.org/thread/99.html\">http://www.chanzhi.org/thread/99.html</a></span><br /><br /><span style=\"color:#333333;font-family:\'Helvetica Neue\', Helvetica, Tahoma, Arial, sans-serif;line-height:22px;background-color:#FFFFFF;\"><span style=\"font-weight:700;\">16、如何去掉底部蝉知链接?</span></span><br /><span style=\"color:#333333;font-family:\'Helvetica Neue\', Helvetica, Tahoma, Arial, sans-serif;line-height:22px;background-color:#FFFFFF;\">一个域名需要360元的授权费用。建议大家保留。</span><br /><span style=\"color:#333333;font-family:\'Helvetica Neue\', Helvetica, Tahoma, Arial, sans-serif;line-height:22px;background-color:#FFFFFF;\">具体可阅读蝉知的授权协议：<a href=\"http://www.chanzhi.org/book/chanzhieps/58_license.html\">http://www.chanzhi.org/book/chanzhieps/58_license.html</a></span><br /><br /><span style=\"color:#333333;font-family:\'Helvetica Neue\', Helvetica, Tahoma, Arial, sans-serif;line-height:22px;background-color:#FFFFFF;\"><span style=\"font-weight:700;\">17、如何设置背景照片？</span></span><br /><span style=\"color:#333333;font-family:\'Helvetica Neue\', Helvetica, Tahoma, Arial, sans-serif;line-height:22px;background-color:#FFFFFF;\">自定义源代码区块，用css调试。上传的图片，可以通过查看源代码看到地址。</span><br /><br /><span style=\"color:#333333;font-family:\'Helvetica Neue\', Helvetica, Tahoma, Arial, sans-serif;line-height:22px;background-color:#FFFFFF;\"><span style=\"font-weight:700;\">18、蝉知有没有站内搜索功能？</span></span><br /><span style=\"color:#333333;font-family:\'Helvetica Neue\', Helvetica, Tahoma, Arial, sans-serif;line-height:22px;background-color:#FFFFFF;\">目前暂时没有这个功能，已计划开发。</span><br /><br /><span style=\"color:#333333;font-family:\'Helvetica Neue\', Helvetica, Tahoma, Arial, sans-serif;line-height:22px;background-color:#FFFFFF;\"><span style=\"font-weight:700;\">19、怎么添加更多的后台管理员，并设置相关权限？</span></span><br /><span style=\"color:#333333;font-family:\'Helvetica Neue\', Helvetica, Tahoma, Arial, sans-serif;line-height:22px;background-color:#FFFFFF;\">前台注册会员，后台会员里设置成管理员。管理员权限目前不能自定义，后期将会完善此功能。</span><br /><br /><span style=\"color:#333333;font-family:\'Helvetica Neue\', Helvetica, Tahoma, Arial, sans-serif;line-height:22px;background-color:#FFFFFF;\"><span style=\"font-weight:700;\">20、怎么删除蝉知会员。</span></span><br /><span style=\"color:#333333;font-family:\'Helvetica Neue\', Helvetica, Tahoma, Arial, sans-serif;line-height:22px;background-color:#FFFFFF;\">蝉知暂时没有删除会员功能，在后台会员永久禁用就可以了。</span><br /><br /><span style=\"color:#333333;font-family:\'Helvetica Neue\', Helvetica, Tahoma, Arial, sans-serif;line-height:22px;background-color:#FFFFFF;\"><span style=\"font-weight:700;\">21、网址里面含有中文，微信解析不了？</span></span><br /><span style=\"color:#333333;font-family:\'Helvetica Neue\', Helvetica, Tahoma, Arial, sans-serif;line-height:22px;background-color:#FFFFFF;\">微信接口不支持中文地址，最好不要使用中文别名。集成微信功能必须使用系统80端口安装蝉知。</span><br /><br /><span style=\"color:#333333;font-family:\'Helvetica Neue\', Helvetica, Tahoma, Arial, sans-serif;line-height:22px;background-color:#FFFFFF;\"><span style=\"font-weight:700;\">22、蝉知支持多语言吗？</span></span><br /><p style=\"color:#333333;font-family:\'Helvetica Neue\', Helvetica, Tahoma, Arial, sans-serif;background-color:#FFFFFF;\"><span>蝉知系统本身支持多语言，可在站点设置里设置系统前台使用的语言（简体、繁体、English）。</span></p>\n<p style=\"color:#333333;font-family:\'Helvetica Neue\', Helvetica, Tahoma, Arial, sans-serif;background-color:#FFFFFF;\"><span>蝉知的后台编辑页面也可直接进行语言设置。</span></p>\n<span style=\"color:#333333;font-family:\'Helvetica Neue\', Helvetica, Tahoma, Arial, sans-serif;line-height:22px;background-color:#FFFFFF;\">目前蝉知不支持内容级的多语言。需要搭建多语言网站，建议搭建多个站点。</span><br /><br /><span style=\"color:#333333;font-family:\'Helvetica Neue\', Helvetica, Tahoma, Arial, sans-serif;line-height:22px;background-color:#FFFFFF;\"><span style=\"font-weight:700;\">23、蝉知有数据导入功能吗？</span></span><br /><p style=\"color:#333333;font-family:\'Helvetica Neue\', Helvetica, Tahoma, Arial, sans-serif;background-color:#FFFFFF;\"><span>目前没有这个功能。</span></p>\n<p style=\"color:#333333;font-family:\'Helvetica Neue\', Helvetica, Tahoma, Arial, sans-serif;background-color:#FFFFFF;\"><span>如果数据格式和蝉知的不一样，建议先线下写个转换程序，转换成蝉知数据库，自己找个空间托管。</span></p>\n<p style=\"color:#333333;font-family:\'Helvetica Neue\', Helvetica, Tahoma, Arial, sans-serif;background-color:#FFFFFF;\"><span>或者联系我们导入线上（我们会收取一定的费用）。</span></p>\n<br /><span style=\"color:#333333;font-family:\'Helvetica Neue\', Helvetica, Tahoma, Arial, sans-serif;line-height:22px;background-color:#FFFFFF;\"><span style=\"font-weight:700;\">24、蝉知有没有备份功能？</span></span><br /><span style=\"color:#333333;font-family:\'Helvetica Neue\', Helvetica, Tahoma, Arial, sans-serif;line-height:22px;background-color:#FFFFFF;\">蝉知没有直接备份功能。附件复制就可以，数据库自己备份就行。</span><br /><span style=\"color:#333333;font-family:\'Helvetica Neue\', Helvetica, Tahoma, Arial, sans-serif;line-height:22px;background-color:#FFFFFF;\">可参照：<a href=\"http://www.chanzhi.org/book/chanzhieps/63.html\">http://www.chanzhi.org/book/chanzhieps/63.html</a></span><br /><span style=\"color:#333333;font-family:\'Helvetica Neue\', Helvetica, Tahoma, Arial, sans-serif;line-height:22px;background-color:#FFFFFF;\">云蝉知提供下载备份服务。</span><br /><br /><span style=\"color:#333333;font-family:\'Helvetica Neue\', Helvetica, Tahoma, Arial, sans-serif;line-height:22px;background-color:#FFFFFF;\"><span style=\"font-weight:700;\">25、登录蝉知后台，频繁提示退出登录。</span></span><br /><p style=\"color:#333333;font-family:\'Helvetica Neue\', Helvetica, Tahoma, Arial, sans-serif;background-color:#FFFFFF;\"><span>蝉知后台有防超时功能每6分钟刷新一次。</span></p>\n<p style=\"color:#333333;font-family:\'Helvetica Neue\', Helvetica, Tahoma, Arial, sans-serif;background-color:#FFFFFF;\"><span>对session登录ip地址安全检查，IP变换，已登录帐号会退出登录。</span></p>\n<p style=\"color:#333333;font-family:\'Helvetica Neue\', Helvetica, Tahoma, Arial, sans-serif;background-color:#FFFFFF;\"><span>system/common/model.php的startSession里面可以去掉这个检查。</span></p>\n<br /><span style=\"color:#333333;font-family:\'Helvetica Neue\', Helvetica, Tahoma, Arial, sans-serif;line-height:22px;background-color:#FFFFFF;\"><span style=\"font-weight:700;\">26、列表页面每页显示条目数怎么由现在默认的5条改成10条？</span></span><br /><span style=\"color:#333333;font-family:\'Helvetica Neue\', Helvetica, Tahoma, Arial, sans-serif;line-height:22px;background-color:#FFFFFF;\">这个需要自己改代码，建议先看看我们的开发框架文档再修改。</span><br /><span style=\"color:#333333;font-family:\'Helvetica Neue\', Helvetica, Tahoma, Arial, sans-serif;line-height:22px;background-color:#FFFFFF;\">如果需要修改的是文章列表页面的，在article/config.php里修改。</span><br /><span style=\"color:#333333;font-family:\'Helvetica Neue\', Helvetica, Tahoma, Arial, sans-serif;line-height:22px;background-color:#FFFFFF;\">蝉知开发框架：<a href=\"http://devel.cnezsoft.com/\">http://devel.cnezsoft.com/</a></span><br /><br /><span style=\"color:#333333;font-family:\'Helvetica Neue\', Helvetica, Tahoma, Arial, sans-serif;line-height:22px;background-color:#FFFFFF;\"><span style=\"font-weight:700;\">27、关于添加最新产品区块前台显示空白的问题。</span></span><br /><span style=\"color:#333333;font-family:\'Helvetica Neue\', Helvetica, Tahoma, Arial, sans-serif;line-height:22px;background-color:#FFFFFF;\">在后台添加了最新产品区块，需要到布局设置里添加最新产品的位置和显示宽度，前台才可以显示。</span><br /><span style=\"color:#333333;font-family:\'Helvetica Neue\', Helvetica, Tahoma, Arial, sans-serif;line-height:22px;background-color:#FFFFFF;\">最新产品区块如果想同时显示图片和内容的话，需要在最新产品区块编辑页面勾选显示图片，产品附件上传图片。</span><br /><span style=\"color:#333333;font-family:\'Helvetica Neue\', Helvetica, Tahoma, Arial, sans-serif;line-height:22px;background-color:#FFFFFF;\">如果想像文章那样直接是文字显示，直接在最新产品区块编辑页面不勾选显示图片，这样产品也不需要上传图片。</span><br />', 'article', 1, ',1,2,', 2, 'admin', 'demo', '2014-08-25 14:00:44', '2014-08-26 11:43:13', 'normal', 17, 2, '', 'zh-cn');

-- --------------------------------------------------------

--
-- 表的结构 `eps_cart`
--

CREATE TABLE `eps_cart` (
  `id` mediumint(9) NOT NULL,
  `account` char(30) NOT NULL,
  `product` mediumint(8) UNSIGNED NOT NULL DEFAULT '0',
  `count` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `lang` char(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `eps_category`
--

CREATE TABLE `eps_category` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL DEFAULT '',
  `abbr` varchar(60) NOT NULL,
  `alias` varchar(100) NOT NULL,
  `desc` text NOT NULL,
  `keywords` varchar(150) NOT NULL,
  `parent` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `path` char(255) NOT NULL DEFAULT '',
  `grade` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `order` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `type` char(30) NOT NULL,
  `readonly` enum('0','1') NOT NULL DEFAULT '0',
  `moderators` varchar(255) NOT NULL,
  `threads` smallint(5) NOT NULL,
  `posts` smallint(5) NOT NULL,
  `postedBy` varchar(30) NOT NULL,
  `postedDate` datetime NOT NULL,
  `postID` mediumint(9) NOT NULL,
  `replyID` mediumint(8) UNSIGNED NOT NULL,
  `link` varchar(255) NOT NULL,
  `unsaleable` enum('0','1') NOT NULL DEFAULT '0',
  `discussion` enum('0','1') NOT NULL DEFAULT '0',
  `lang` char(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `eps_category`
--

INSERT INTO `eps_category` (`id`, `name`, `abbr`, `alias`, `desc`, `keywords`, `parent`, `path`, `grade`, `order`, `type`, `readonly`, `moderators`, `threads`, `posts`, `postedBy`, `postedDate`, `postID`, `replyID`, `link`, `unsaleable`, `discussion`, `lang`) VALUES
(1, '蝉知下载', '', 'download', '', '', 0, ',1,', 1, 10, 'article', '0', '', 0, 0, '', '2014-08-25 13:56:40', 0, 0, '', '0', '0', 'zh-cn'),
(2, '蝉知动态', '', 'dynamic', '', '', 0, ',2,', 1, 20, 'article', '0', '', 0, 0, '', '2014-08-25 13:56:40', 0, 0, '', '0', '0', 'zh-cn'),
(3, '商业支持', '', '', '', '', 0, ',3,', 1, 30, 'article', '0', '', 0, 0, '', '2014-08-25 13:56:40', 0, 0, '', '0', '0', 'zh-cn'),
(4, '蝉知', '', '', '', '', 0, ',4,', 1, 10, 'forum', '0', '', 0, 0, '', '2014-08-25 14:19:26', 0, 0, '', '0', '0', 'zh-cn'),
(5, '建议反馈', '', 'feedback', '有关蝉知企业门户系统的建议和反馈。', '蝉知企业门户系统,蝉知企业建站系统,开源cms', 4, ',4,5,', 2, 10, 'forum', '0', '', 1, 1, 'demo', '2014-09-02 18:27:35', 1, 0, '', '0', '0', 'zh-cn'),
(6, '技术支持', '', 'support', '蝉知企业门户系统技术支持版块。', '蝉知企业门户系统,蝉知建站系统,cms,开源cms,免费cms', 4, ',4,6,', 2, 20, 'forum', '0', '', 0, 0, '', '2014-08-25 14:20:01', 0, 0, '', '0', '0', 'zh-cn'),
(7, '蝉知', '', '', '', '', 0, ',7,', 1, 10, 'product', '0', '', 0, 0, '', '2014-08-25 14:29:49', 0, 0, '', '0', '0', 'zh-cn'),
(8, '12123', '', '', '', '', 0, ',8,', 1, 10, 'wechat_1', '0', '', 0, 0, '', '2014-10-08 17:09:23', 0, 0, '', '0', '0', 'zh-cn'),
(11, '知识改进', '', '', '', '', 0, ',11,', 1, 40, 'article', '0', '', 0, 0, '', '2014-10-08 17:42:37', 0, 0, '', '0', '0', 'zh-cn'),
(10, '12312', '', '', '', '', 0, ',10,', 1, 30, 'wechat_1', '0', '', 0, 0, '', '2014-10-08 17:09:23', 0, 0, '', '0', '0', 'zh-cn'),
(12, '一二三', '', '', '', '', 11, ',11,12,', 2, 10, 'article', '0', '', 0, 0, '', '2014-10-08 17:43:03', 0, 0, '', '0', '0', 'zh-cn'),
(13, '四五六', '', '', '', '', 11, ',11,13,', 2, 20, 'article', '0', '', 0, 0, '', '2014-10-08 17:43:03', 0, 0, '', '0', '0', 'zh-cn'),
(14, '七八九', '', '', '', '', 11, ',11,14,', 2, 30, 'article', '0', '', 0, 0, '', '2014-10-08 17:43:03', 0, 0, '', '0', '0', 'zh-cn'),
(15, '默认分组', '', '', '', '', 0, ',15,', 1, 10, 'slide', '0', '', 0, 0, '', '2015-07-16 15:23:56', 0, 0, '', '0', '0', 'zh-cn');

-- --------------------------------------------------------

--
-- 表的结构 `eps_config`
--

CREATE TABLE `eps_config` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `owner` char(30) NOT NULL DEFAULT '',
  `module` varchar(30) NOT NULL,
  `section` char(30) NOT NULL DEFAULT '',
  `key` char(50) DEFAULT NULL,
  `value` text NOT NULL,
  `lang` char(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `eps_config`
--

INSERT INTO `eps_config` (`id`, `owner`, `module`, `section`, `key`, `value`, `lang`) VALUES
(1, 'system', 'common', 'template', 'parser', 'raintpl', 'zh-cn'),
(2, 'system', 'common', 'template', 'parser', 'raintpl', 'zh-tw'),
(3, 'system', 'common', 'template', 'parser', 'raintpl', 'en'),
(351, 'system', 'common', 'site', 'lang', 'zh-cn', 'zh-cn'),
(460, 'system', 'common', 'site', 'type', 'portal', 'zh-cn'),
(461, 'system', 'common', 'site', 'name', '蝉知企业门户', 'zh-cn'),
(465, 'system', 'common', 'site', 'modules', 'user,article,product,page,forum,blog,book,message,search,shop', 'zh-cn'),
(466, 'system', 'common', 'site', 'copyright', '2013', 'zh-cn'),
(467, 'system', 'common', 'site', 'keywords', '企业门户系统 企业建站系统 开源CMS', 'zh-cn'),
(468, 'system', 'common', 'site', 'indexKeywords', '企业门户系统 企业建站系统 开源CMS', 'zh-cn'),
(469, 'system', 'common', 'site', 'slogan', '为天下企业提供专业的营销工具！', 'zh-cn'),
(471, 'system', 'common', 'site', 'desc', '蝉知门户系统（chanzhiEPS）是一款开源免费的企业门户系统，企业建站系统，php开源CMS系统。它专为企业营销设计，功能专业全面，内置了文章发布、会员管理、论坛评论、产品展示、在线销售、客服跟踪等功能。以LGPL协议发布，真开源，真免费。注重SEO，注重营销，支持移动设备。界面简洁大方，使用简单方便，功能专业强大，是企业建站的首选！同时蝉知系统还内置了微信公众平台功能，一个网站，电脑、手机、微信体验俱佳！', 'zh-cn'),
(472, 'system', 'common', 'site', 'icpSN', '', 'zh-cn'),
(473, 'system', 'common', 'site', 'icpLink', 'http://www.miitbeian.gov.cn', 'zh-cn'),
(450, 'system', 'common', 'nav', 'desktop_top', '[{\"type\":\"system\",\"article\":\"0\",\"product\":\"0\",\"page\":\"2\",\"system\":\"home\",\"title\":\"\\u9996\\u9875\",\"url\":\"\\/\",\"key\":\"0\",\"target\":\"\",\"class\":\"nav-system-home\",\"children\":[]},{\"type\":\"article\",\"article\":\"2\",\"product\":\"0\",\"page\":\"2\",\"system\":\"home\",\"title\":\"\\u52a8\\u6001\",\"url\":\"\\/dynamic.html\",\"key\":\"1\",\"target\":\"\",\"class\":\"nav-article-2\",\"children\":[]},{\"type\":\"product\",\"article\":\"0\",\"product\":\"0\",\"page\":\"2\",\"system\":\"home\",\"title\":\"\\u4ea7\\u54c1\\u5217\\u8868\",\"url\":\"\\/product\\/\",\"key\":\"2\",\"target\":\"\",\"class\":\"nav-product-0\",\"children\":[]},{\"type\":\"page\",\"article\":\"0\",\"product\":\"0\",\"page\":\"2\",\"system\":\"home\",\"title\":\"\\u63a8\\u8350\\u7a7a\\u95f4\",\"url\":\"\\/page\\/host.html\",\"key\":\"3\",\"target\":\"\",\"class\":\"nav-page-2\",\"children\":[]},{\"type\":\"system\",\"article\":\"0\",\"product\":\"0\",\"page\":\"2\",\"system\":\"forum\",\"title\":\"\\u8bba\\u575b\",\"url\":\"\\/forum\\/\",\"key\":\"4\",\"target\":\"\",\"class\":\"nav-system-forum\",\"children\":[]},{\"type\":\"system\",\"article\":\"0\",\"product\":\"0\",\"page\":\"2\",\"system\":\"book\",\"title\":\"\\u624b\\u518c\",\"url\":\"\\/book\\/\",\"key\":\"5\",\"target\":\"\",\"class\":\"nav-system-book\",\"children\":[]},{\"type\":\"system\",\"article\":\"0\",\"product\":\"0\",\"page\":\"2\",\"system\":\"message\",\"title\":\"\\u7559\\u8a00\",\"url\":\"\\/message\\/\",\"key\":\"6\",\"target\":\"\",\"class\":\"nav-system-message\",\"children\":[]},{\"type\":\"system\",\"article\":\"0\",\"product\":\"0\",\"page\":\"2\",\"system\":\"company\",\"title\":\"\\u5173\\u4e8e\\u6211\\u4eec\",\"url\":\"\\/company\\/\",\"key\":\"7\",\"target\":\"\",\"class\":\"nav-system-company\",\"children\":[]}]', 'zh-cn'),
(451, 'system', 'common', 'nav', 'mobile_top', '[{\"type\":\"system\",\"article\":\"0\",\"product\":\"0\",\"page\":\"11\",\"system\":\"home\",\"title\":\"\\u9996\\u9875\",\"url\":\"\\/\",\"key\":\"0\",\"target\":\"\",\"class\":\"nav-system-home\",\"children\":[]},{\"type\":\"product\",\"article\":\"0\",\"product\":\"0\",\"page\":\"11\",\"system\":\"home\",\"title\":\"\\u4ea7\\u54c1\\u5217\\u8868\",\"url\":\"\",\"key\":\"1\",\"target\":\"\",\"class\":\"nav-product-0\",\"children\":[]},{\"type\":\"article\",\"article\":\"0\",\"product\":\"0\",\"page\":\"11\",\"system\":\"home\",\"title\":\"\\u52a8\\u6001\",\"url\":\"\",\"key\":\"2\",\"target\":\"\",\"class\":\"nav-article-0\",\"children\":[]},{\"type\":\"system\",\"article\":\"0\",\"product\":\"0\",\"page\":\"11\",\"system\":\"message\",\"title\":\"\\u7559\\u8a00\",\"url\":\"\",\"key\":\"3\",\"target\":\"\",\"class\":\"nav-system-message\",\"children\":[]}]', 'zh-cn'),
(26, 'system', 'common', 'links', 'index', '<a href=\"http://www.cnezsoft.com\" target=\"_blank\">青岛易软天创</a><a href=\"http://www.zentao.net\" target=\"_blank\"> 禅道项目管理软件</a> <a href=\"http://www.ranzhi.org/\" target=\"_blank\">然之协同</a><a href=\"http://www.docker.org.cn\" target=\"_blank\">docker中文社区</a>', 'zh-cn'),
(27, 'system', 'common', 'links', 'all', '', 'zh-cn'),
(28, 'system', 'common', 'links', 'uid', '53facf42f2e81', 'zh-cn'),
(478, 'system', 'common', 'company', 'name', '青岛息壤网络信息有限公司', 'zh-cn'),
(479, 'system', 'common', 'company', 'desc', '<p>青岛息壤由<a href=\"http://www.cnezsoft.com\">青岛易软天创</a>全资成立，公司位于美丽的青岛开发区，团队有着丰富的研发经验。</p>\n<p>我们正在打造一款开源免费的企业建站系统，开源cms系统，以帮助企业建立品牌网站，进行宣传推广、市场营销、产品销售和客户跟踪。</p>\n<p><span>蝉知功能完备：内置了文章、会员、论坛、博客、手册等功能，更多功能全力开发中；</span><span>注重SEO，语义化， 关键词、内链，助您提高搜索排名；</span><span>统计分析，让数据说话，随时掌握网站流量和销售动态。</span><span></span></p>\n<p>我们崇尚简单和信任，以为天下企业提供专业的管理工具为使命！开源开放，共创共赢！</p>', 'zh-cn'),
(480, 'system', 'common', 'company', 'content', '<h4>关于青岛息壤网络信息有限公司</h4>\n<p>青岛息壤网络信息有限公司由<a href=\"http://www.cnezsoft.com\">青岛易软天创</a>网络科技有限公司全资成立，位于美丽的青岛开发区，团队成员拥有丰富的网站设计、系统研发、服务器维护和SEO经验。我们正在打造一款开源免费的企业门户系统，以帮助企业建立品牌网站，进行宣传推广、市场营销、产品销售和客户跟踪。<span style=\"color:#E53333;\">为天下企业提供专业的营销工具！</span> </p>\n<h4>关于蝉知企业门户系统(chanzhiEPS)</h4>\n<p>蝉知门户系统（changezhiEPS）是一款开源免费的企业门户系统，专为企业营销设计！</p>\n<h4><strong>为什么</strong><strong>来</strong><strong>做</strong><strong>蝉知？</strong> </h4>\n<p>禅\n道团队开发的禅道项目管理软件主要是解决企业内部研发的问题。在我们和客户接触的时候，发现企业现在对外营销的问题解决得非常不好。现在的企业网站大都是\n使用cms系统修改而来，各地大大小小的建站公司做的网站，实在不敢恭维。很多号称开源的cms系统也都严格限制商用，所以我们就有了做一个开源的企业门\n户系统的想法，于是就有了息壤这个团队，有了蝉知这个产品。</p>\n<h4><strong>为什么</strong><strong>叫做</strong><strong>蝉知？</strong><strong><br />\n</strong></h4>\n<p><strong> </strong> </p>\n<p>蝉\n在中国传统文化中象征着闻达和财富，非常适合企业宣传营销的特点，所以我们为这套系统起名为蝉知，我们希望通过这款开源免费的系统可以帮助众多的中小企业\n快速方面的建立自己的企业网站，进行宣传营销。更重要的是蝉知是开放的，企业做大之后，可以在蝉知基础上继续扩展开发，不会成为您的瓶颈！</p>\n<h4><strong>蝉知的特点：</strong> </h4>\n<p>和市面上其他的各种各样的cms相比，息壤系统具有如下特点：</p>\n<ol><li><strong>专注企业营销!</strong><br />\n功能完备，文章、会员、论坛，更多功能全力开发中;<br />\n注重SEO，语义化， 关键词、内链，助您提高搜索排名;<br />\n统计分析，让数据说话，随时掌握网站流量和销售动态。<br />\n<br />\n</li>\n<li><strong>真开源真免费!</strong><br />\n国内唯一开源企业门户系统;<br />\n以LGPL协议发布，代码完全开放;<br />\n免费下载，免费使用，不限制商用！<br />\n<br />\n</li>\n<li><strong>技术先进体验好!</strong><br />\n底层框架自主开发，结构先进灵活；<br />\n内置扩展机制，方便企业定制开发；<br />\n汲取先进设计理念，注重用户体验！<br />\n<br />\n</li>\n<li><strong>使用放心有保障!</strong><br />\n我们是专职在做开源软件；<br />\n我们有多年的开源和支持经验；<br />\n做营销，用息壤，靠谱！</li>\n</ol>\n<h4>获得支持：</h4>\n<p>您可以通过如下方式获得技术支持：<br />\nQQ群：284891062 <span style=\"color:#E53333;\">加群请注明暗号：蝉知，进群之后请修改自己的名片，城市-公司-昵称，都可以用缩写。<br />\n</span>论坛：<a href=\"http://www.chanzhi.org/forum\">http://www.chanzhi.org/forum/</a> </p>', 'zh-cn'),
(481, 'system', 'common', 'company', 'setDate', '2015-07-03 13:33:14', 'zh-cn'),
(147, 'system', 'common', 'company', 'contact', '{\"contacts\":\"\\u5f90\\u8d3a\",\"phone\":\"0532-84462898\",\"fax\":\"\",\"email\":\"co@chanzhi.org\",\"qq\":\"2692096539\",\"weixin\":\"chinaeasysoft\",\"weibo\":\"easysoft\",\"wangwang\":\"\",\"site\":\"\",\"address\":\"\\u9752\\u5c9b\\u5f00\\u53d1\\u533a\\u4e95\\u5188\\u5c71\\u8def\\u4e1c\\u65b9\\u94f6\\u5ea7 C\\u5ea7 1106\"}', 'zh-cn'),
(486, 'system', 'common', 'site', 'lastUpload', '1437032740', 'zh-cn'),
(464, 'system', 'common', 'site', 'scheme', 'http', 'zh-cn'),
(412, 'system', 'common', 'template', 'name', 'default', 'zh-cn'),
(413, 'system', 'common', 'template', 'theme', 'default', 'zh-cn'),
(415, 'system', 'common', 'template', 'customTheme', 'default', 'zh-cn'),
(396, 'system', 'common', 'global', 'ignoreUpgrade', '0', 'zh-cn'),
(155, 'system', 'common', 'site', 'allowUpload', '1', 'zh-cn'),
(393, 'system', 'common', 'template', 'custom', '{\"default\":{\"flat\":{\"background-color\":\"transparent\",\"background-image\":\"\",\"background-image-repeat\":\"repeat\",\"background-image-position-x\":\"\",\"background-image-position-y\":\"0\",\"background-image-position\":\" 0\",\"text-color\":\"\",\"font-size\":\"13px\",\"font-family\":\"inherit\",\"font-weight\":\"normal\",\"link-color\":\"\",\"link-decoration\":\"none\",\"link-visited-color\":\"\",\"link-hover-color\":\"\",\"sidebar-pull-left\":\"false\",\"sidebar-width\":\"25%\",\"footer-border-style\":\"none\",\"footer-border-color\":\"\",\"footer-backcolor\":\"\"},\"tartan\":{\"background-color\":\"#D0FFFD\",\"background-image\":\"\",\"background-image-repeat\":\"repeat\",\"background-image-position-x\":\"\",\"background-image-position-y\":\"0\",\"background-image-position\":\" 0\",\"text-color\":\"\",\"font-size\":\"13px\",\"font-family\":\"inherit\",\"font-weight\":\"normal\",\"link-color\":\"\",\"link-decoration\":\"none\",\"link-visited-color\":\"\",\"link-hover-color\":\"\",\"sidebar-pull-left\":\"false\",\"sidebar-width\":\"25%\",\"footer-border-style\":\"none\",\"footer-border-color\":\"\",\"footer-backcolor\":\"\"},\"default\":{\"background-color\":\"transparent\",\"background-image\":\"none\",\"background-image-repeat\":\"repeat\",\"background-image-position-x\":\"0\",\"background-image-position-y\":\"0\",\"background-image-position\":\"0 0\",\"text-color\":\"#333\",\"font-size\":\"13px\",\"font-family\":\"inherit\",\"font-weight\":\"normal\",\"link-color\":\"#0D3D88\",\"link-decoration\":\"none\",\"link-visited-color\":\"#0D3D88\",\"link-hover-color\":\"#347AEB\",\"sidebar-pull-left\":\"false\",\"sidebar-width\":\"25%\",\"navbar-table-layout\":\"true\",\"navbar-backcolor\":\"#f1f1f1\",\"navbar-background-image\":\"none\",\"navbar-background-image-repeat\":\"repeat\",\"navbar-background-image-position-x\":\"0\",\"navbar-background-image-position-y\":\"0\",\"navbar-background-image-position\":\"0 0\",\"navbar-border-style\":\"solid\",\"navbar-border-color\":\"#D5D5D5\",\"navbar-border-width\":\"1px\",\"navbar-border-radius\":\"4px\",\"navbar-panel-backcolor\":\"#FFF\",\"navbar-panel-border-style\":\"solid\",\"navbar-panel-border-color\":\"#DDD\",\"navbar-panel-border-width\":\"1px\",\"navbar-paenl-border-radius\":\"3px\",\"navbar-menu-color\":\"#555\",\"navbar-menu-font-size\":\"14px\",\"navbar-menu-font-family\":\"inherit\",\"navbar-menu-font-weight\":\"bold\",\"navbar-menu-color-hover\":\"#000\",\"navbar-menu-backcolor-hover\":\"#FEFEFE\",\"navbar-menu-color-active\":\"#151515\",\"navbar-menu-backcolor-active\":\"#FFF\",\"navbar-submenu-color\":\"#333\",\"navbar-submenu-color-hover\":\"#151515\",\"navbar-submenu-backcolor-hover\":\"#E5E5E5\",\"navbar-submenu-color-active\":\"#151515\",\"navbar-submenu-backcolor-active\":\"#E5E5E5\",\"block-border-style\":\"solid\",\"block-border-color\":\"#DDD\",\"block-border-width\":\"1px\",\"block-border-radius\":\"3px\",\"block-heading-backcolor\":\"#F5F5F5\",\"block-heading-color\":\"#333\",\"block-heading-font-size\":\"inherit\",\"block-heading-font-weight\":\"inherit\",\"block-body-backcolor\":\"transparent\",\"block-body-color\":\"#333\",\"block-body-link-color\":\"#0D3D88\",\"button-color-default\":\"#F2F2F2\",\"button-color-primary\":\"#3280FC\",\"button-color-info\":\"#39B3D7\",\"button-color-success\":\"#229F24\",\"button-color-warning\":\"#E48600\",\"button-color-danger\":\"#D2322D\",\"button-border-style\":\"solid\",\"button-border-width\":\"1px\",\"button-border-radius\":\"3px\",\"button-font-weight\":\"normal\",\"footer-border-style\":\"solid\",\"footer-border-color\":\"#ddd\",\"footer-backcolor\":\"#f7f7f7\"},\"wide\":{\"color-primary\":\"\",\"text-color\":\"\",\"font-size\":\"13px\",\"font-family\":\"inherit\",\"font-weight\":\"normal\",\"sidebar-pull-left\":\"false\",\"sidebar-width\":\"25%\"},\"colorful\":{\"color-primary\":\"\",\"border-radius\":\"3\",\"background-color\":\"\",\"background-image\":\"\",\"text-color\":\"\",\"font-size\":\"13px\",\"font-family\":\"\\u5b8b\\u4f53\",\"font-weight\":\"normal\",\"sidebar-pull-left\":\"false\",\"sidebar-width\":\"25%\",\"footer-border-style\":\"solid\",\"footer-border-color\":\"\",\"footer-backcolor\":\"#2286D2\"}}}', 'zh-cn'),
(394, 'system', 'common', 'template', 'customVersion', '1417396719', 'zh-cn'),
(410, 'system', 'common', 'shop', 'payment', 'alipay,COD', 'zh-cn'),
(411, 'system', 'common', 'shop', 'confirmLimit', '7', 'zh-cn'),
(488, 'system', 'common', 'site', 'lang', 'zh-cn', 'all'),
(420, 'system', 'common', 'site', 'defaultLang', 'zh-cn', 'all'),
(458, 'system', 'common', 'site', 'status', 'normal', 'zh-cn'),
(459, 'system', 'common', 'site', 'pauseTip', '站点维护中……', 'zh-cn'),
(462, 'system', 'common', 'site', 'domain', '', 'zh-cn'),
(463, 'system', 'common', 'site', 'allowedDomain', '', 'zh-cn'),
(470, 'system', 'common', 'site', 'meta', '', 'zh-cn'),
(438, 'system', 'common', 'site', 'uid', '554d6de00a0b7', 'zh-cn'),
(487, 'system', 'common', 'global', 'version', '7.7', 'all'),
(489, 'admin', 'common', 'site', 'widgetInited', '1', 'zh-cn'),
(493, 'system', 'common', 'site', 'updatedTime', '1624279712', 'all'),
(491, 'system', 'common', 'wechatPublic', 'hasPublic', '0', 'zh-cn');

-- --------------------------------------------------------

--
-- 表的结构 `eps_down`
--

CREATE TABLE `eps_down` (
  `id` int(10) NOT NULL,
  `account` char(30) DEFAULT NULL,
  `file` mediumint(5) DEFAULT NULL,
  `ip` char(40) NOT NULL,
  `time` datetime NOT NULL,
  `referer` varchar(200) NOT NULL,
  `lang` char(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `eps_file`
--

CREATE TABLE `eps_file` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `pathname` char(200) NOT NULL,
  `title` char(90) NOT NULL,
  `extension` char(30) NOT NULL,
  `size` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `width` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `height` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `objectType` char(20) NOT NULL,
  `objectID` char(50) NOT NULL,
  `addedBy` char(30) NOT NULL DEFAULT '',
  `addedDate` datetime NOT NULL,
  `public` enum('1','0') NOT NULL DEFAULT '1',
  `score` mediumint(8) UNSIGNED NOT NULL DEFAULT '0',
  `downloads` mediumint(8) UNSIGNED NOT NULL DEFAULT '0',
  `extra` varchar(255) NOT NULL,
  `order` smallint(5) UNSIGNED NOT NULL,
  `editor` enum('1','0') NOT NULL DEFAULT '0',
  `lang` char(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `eps_group`
--

CREATE TABLE `eps_group` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `name` char(30) NOT NULL,
  `role` char(30) NOT NULL DEFAULT '',
  `desc` char(255) NOT NULL DEFAULT '',
  `lang` char(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `eps_group`
--

INSERT INTO `eps_group` (`id`, `name`, `role`, `desc`, `lang`) VALUES
(1, '管理员', '', '拥有后台所有权限', 'zh-cn'),
(2, '网站编辑', '', '拥有发布以及编辑权限', 'zh-cn'),
(3, '客服', '', '管理论坛留言评论的权限', 'zh-cn');

-- --------------------------------------------------------

--
-- 表的结构 `eps_grouppriv`
--

CREATE TABLE `eps_grouppriv` (
  `group` mediumint(8) UNSIGNED NOT NULL DEFAULT '0',
  `module` char(30) NOT NULL DEFAULT '',
  `method` char(30) NOT NULL DEFAULT '',
  `lang` char(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `eps_grouppriv`
--

INSERT INTO `eps_grouppriv` (`group`, `module`, `method`, `lang`) VALUES
(1, 'admin', 'ignore', 'zh-cn'),
(1, 'admin', 'ignoreupgrade', 'zh-cn'),
(1, 'article', 'admin', 'zh-cn'),
(1, 'article', 'create', 'zh-cn'),
(1, 'article', 'edit', 'zh-cn'),
(1, 'article', 'delete', 'zh-cn'),
(1, 'article', 'forward2Forum', 'zh-cn'),
(1, 'article', 'forward2Blog', 'zh-cn'),
(1, 'article', 'check', 'zh-cn'),
(1, 'article', 'reject', 'zh-cn'),
(1, 'article', 'setcss', 'zh-cn'),
(1, 'article', 'setjs', 'zh-cn'),
(1, 'article', 'stick', 'zh-cn'),
(1, 'product', 'admin', 'zh-cn'),
(1, 'product', 'create', 'zh-cn'),
(1, 'product', 'edit', 'zh-cn'),
(1, 'product', 'changeStatus', 'zh-cn'),
(1, 'product', 'currency', 'zh-cn'),
(1, 'product', 'delete', 'zh-cn'),
(1, 'product', 'setcss', 'zh-cn'),
(1, 'product', 'setjs', 'zh-cn'),
(1, 'product', 'setting', 'zh-cn'),
(1, 'book', 'admin', 'zh-cn'),
(1, 'book', 'catalog', 'zh-cn'),
(1, 'book', 'create', 'zh-cn'),
(1, 'book', 'edit', 'zh-cn'),
(1, 'book', 'sort', 'zh-cn'),
(1, 'book', 'delete', 'zh-cn'),
(1, 'forum', 'admin', 'zh-cn'),
(1, 'forum', 'update', 'zh-cn'),
(1, 'reply', 'admin', 'zh-cn'),
(1, 'reply', 'edit', 'zh-cn'),
(1, 'reply', 'delete', 'zh-cn'),
(1, 'reply', 'deleteFile', 'zh-cn'),
(1, 'thread', 'transfer', 'zh-cn'),
(1, 'thread', 'switchStatus', 'zh-cn'),
(1, 'thread', 'delete', 'zh-cn'),
(1, 'thread', 'deleteFile', 'zh-cn'),
(1, 'site', 'setBasic', 'zh-cn'),
(1, 'site', 'setLang', 'zh-cn'),
(1, 'site', 'setRobots', 'zh-cn'),
(1, 'site', 'setUpload', 'zh-cn'),
(1, 'site', 'setOauth', 'zh-cn'),
(1, 'site', 'setRecPerPage', 'zh-cn'),
(1, 'site', 'setsecurity', 'zh-cn'),
(1, 'site', 'setsensitive', 'zh-cn'),
(1, 'nav', 'admin', 'zh-cn'),
(1, 'tag', 'admin', 'zh-cn'),
(1, 'tag', 'link', 'zh-cn'),
(1, 'links', 'admin', 'zh-cn'),
(1, 'mail', 'admin', 'zh-cn'),
(1, 'mail', 'detect', 'zh-cn'),
(1, 'mail', 'edit', 'zh-cn'),
(1, 'mail', 'save', 'zh-cn'),
(1, 'mail', 'test', 'zh-cn'),
(1, 'mail', 'reset', 'zh-cn'),
(1, 'wechat', 'admin', 'zh-cn'),
(1, 'wechat', 'create', 'zh-cn'),
(1, 'wechat', 'integrate', 'zh-cn'),
(1, 'wechat', 'edit', 'zh-cn'),
(1, 'wechat', 'delete', 'zh-cn'),
(1, 'wechat', 'adminResponse', 'zh-cn'),
(1, 'wechat', 'setResponse', 'zh-cn'),
(1, 'wechat', 'deleteResponse', 'zh-cn'),
(1, 'wechat', 'reply', 'zh-cn'),
(1, 'wechat', 'commitMenu', 'zh-cn'),
(1, 'wechat', 'deleteMenu', 'zh-cn'),
(1, 'wechat', 'message', 'zh-cn'),
(1, 'wechat', 'qrcode', 'zh-cn'),
(1, 'group', 'browse', 'zh-cn'),
(1, 'group', 'create', 'zh-cn'),
(1, 'group', 'edit', 'zh-cn'),
(1, 'group', 'copy', 'zh-cn'),
(1, 'group', 'delete', 'zh-cn'),
(1, 'group', 'managePriv', 'zh-cn'),
(1, 'group', 'manageMember', 'zh-cn'),
(1, 'ui', 'setTemplate', 'zh-cn'),
(1, 'ui', 'setDevice', 'zh-cn'),
(1, 'ui', 'customTheme', 'zh-cn'),
(1, 'ui', 'setLogo', 'zh-cn'),
(1, 'ui', 'setBaseStyle', 'zh-cn'),
(1, 'ui', 'deleteFavicon', 'zh-cn'),
(1, 'ui', 'deleteLogo', 'zh-cn'),
(1, 'ui', 'others', 'zh-cn'),
(1, 'ui', 'setCode', 'zh-cn'),
(1, 'slide', 'admin', 'zh-cn'),
(1, 'slide', 'create', 'zh-cn'),
(1, 'slide', 'edit', 'zh-cn'),
(1, 'slide', 'delete', 'zh-cn'),
(1, 'slide', 'sort', 'zh-cn'),
(1, 'slide', 'browse', 'zh-cn'),
(1, 'slide', 'createGroup', 'zh-cn'),
(1, 'slide', 'editGroup', 'zh-cn'),
(1, 'slide', 'removeGroup', 'zh-cn'),
(1, 'block', 'admin', 'zh-cn'),
(1, 'block', 'pages', 'zh-cn'),
(1, 'block', 'setregion', 'zh-cn'),
(1, 'block', 'create', 'zh-cn'),
(1, 'block', 'edit', 'zh-cn'),
(1, 'block', 'delete', 'zh-cn'),
(1, 'block', 'switchLayout', 'zh-cn'),
(1, 'block', 'cloneLayout', 'zh-cn'),
(1, 'block', 'removeLayout', 'zh-cn'),
(1, 'block', 'renameLayout', 'zh-cn'),
(1, 'company', 'setbasic', 'zh-cn'),
(1, 'company', 'setcontact', 'zh-cn'),
(1, 'user', 'admin', 'zh-cn'),
(1, 'user', 'edit', 'zh-cn'),
(1, 'user', 'forbid', 'zh-cn'),
(1, 'user', 'adminlog', 'zh-cn'),
(1, 'message', 'admin', 'zh-cn'),
(1, 'message', 'reply', 'zh-cn'),
(1, 'message', 'pass', 'zh-cn'),
(1, 'message', 'delete', 'zh-cn'),
(1, 'package', 'browse', 'zh-cn'),
(1, 'package', 'obtain', 'zh-cn'),
(1, 'package', 'install', 'zh-cn'),
(1, 'package', 'uninstall', 'zh-cn'),
(1, 'package', 'activate', 'zh-cn'),
(1, 'package', 'deactivate', 'zh-cn'),
(1, 'package', 'upload', 'zh-cn'),
(1, 'package', 'erase', 'zh-cn'),
(1, 'package', 'upgrade', 'zh-cn'),
(1, 'package', 'structure', 'zh-cn'),
(1, 'tree', 'browse', 'zh-cn'),
(1, 'tree', 'edit', 'zh-cn'),
(1, 'tree', 'children', 'zh-cn'),
(1, 'tree', 'delete', 'zh-cn'),
(1, 'tree', 'redirect', 'zh-cn'),
(1, 'file', 'browse', 'zh-cn'),
(1, 'file', 'setPrimary', 'zh-cn'),
(1, 'file', 'upload', 'zh-cn'),
(1, 'file', 'download', 'zh-cn'),
(1, 'file', 'edit', 'zh-cn'),
(1, 'file', 'sort', 'zh-cn'),
(1, 'file', 'fileManager', 'zh-cn'),
(1, 'file', 'delete', 'zh-cn'),
(1, 'file', 'sourceBrowse', 'zh-cn'),
(1, 'file', 'sourceDelete', 'zh-cn'),
(1, 'file', 'editSource', 'zh-cn'),
(1, 'file', 'selectImage', 'zh-cn'),
(1, 'file', 'browseSource', 'zh-cn'),
(1, 'search', 'buildIndex', 'zh-cn'),
(1, 'order', 'admin', 'zh-cn'),
(1, 'order', 'delivery', 'zh-cn'),
(1, 'order', 'finish', 'zh-cn'),
(1, 'order', 'pay', 'zh-cn'),
(1, 'order', 'setting', 'zh-cn'),
(1, 'order', 'deliveryInfo', 'zh-cn'),
(1, 'stat', 'traffic', 'zh-cn'),
(1, 'stat', 'from', 'zh-cn'),
(1, 'stat', 'search', 'zh-cn'),
(1, 'stat', 'client', 'zh-cn'),
(1, 'stat', 'keywords', 'zh-cn'),
(1, 'stat', 'keywordReport', 'zh-cn'),
(1, 'stat', 'domainList', 'zh-cn'),
(1, 'stat', 'domainTrend', 'zh-cn'),
(1, 'stat', 'domainPage', 'zh-cn'),
(1, 'stat', 'page', 'zh-cn'),
(1, 'stat', 'ignoreKeyword', 'zh-cn'),
(1, 'score', 'setCounts', 'zh-cn'),
(2, 'file', 'fileManager', 'zh-cn'),
(2, 'file', 'sort', 'zh-cn'),
(2, 'file', 'download', 'zh-cn'),
(2, 'file', 'edit', 'zh-cn'),
(2, 'file', 'upload', 'zh-cn'),
(2, 'file', 'setPrimary', 'zh-cn'),
(2, 'file', 'browse', 'zh-cn'),
(2, 'file', 'sourceBrowse', 'zh-cn'),
(2, 'file', 'sourceDelete', 'zh-cn'),
(2, 'file', 'editSource', 'zh-cn'),
(2, 'file', 'selectImage', 'zh-cn'),
(2, 'file', 'browseSource', 'zh-cn'),
(2, 'ui', 'setTemplate', 'zh-cn'),
(2, 'ui', 'setDevice', 'zh-cn'),
(2, 'tag', 'link', 'zh-cn'),
(2, 'site', 'setRecPerPage', 'zh-cn'),
(2, 'links', 'admin', 'zh-cn'),
(2, 'tag', 'admin', 'zh-cn'),
(2, 'nav', 'admin', 'zh-cn'),
(2, 'site', 'setLang', 'zh-cn'),
(2, 'site', 'setBasic', 'zh-cn'),
(2, 'book', 'delete', 'zh-cn'),
(2, 'company', 'setbasic', 'zh-cn'),
(2, 'block', 'delete', 'zh-cn'),
(2, 'block', 'edit', 'zh-cn'),
(2, 'block', 'setregion', 'zh-cn'),
(2, 'block', 'pages', 'zh-cn'),
(2, 'block', 'create', 'zh-cn'),
(2, 'book', 'sort', 'zh-cn'),
(2, 'book', 'edit', 'zh-cn'),
(2, 'ui', 'customTheme', 'zh-cn'),
(2, 'product', 'setcss', 'zh-cn'),
(2, 'product', 'delete', 'zh-cn'),
(2, 'ui', 'setLogo', 'zh-cn'),
(2, 'article', 'admin', 'zh-cn'),
(2, 'article', 'stick', 'zh-cn'),
(2, 'article', 'create', 'zh-cn'),
(2, 'article', 'delete', 'zh-cn'),
(2, 'article', 'edit', 'zh-cn'),
(2, 'article', 'setjs', 'zh-cn'),
(2, 'article', 'setcss', 'zh-cn'),
(2, 'article', 'forward2Forum', 'zh-cn'),
(2, 'article', 'forward2Blog', 'zh-cn'),
(2, 'article', 'check', 'zh-cn'),
(2, 'article', 'reject', 'zh-cn'),
(2, 'book', 'create', 'zh-cn'),
(2, 'book', 'catalog', 'zh-cn'),
(2, 'book', 'admin', 'zh-cn'),
(2, 'product', 'setjs', 'zh-cn'),
(2, 'tree', 'redirect', 'zh-cn'),
(2, 'tree', 'browse', 'zh-cn'),
(2, 'company', 'setcontact', 'zh-cn'),
(2, 'tree', 'delete', 'zh-cn'),
(2, 'tree', 'edit', 'zh-cn'),
(2, 'tree', 'children', 'zh-cn'),
(2, 'block', 'admin', 'zh-cn'),
(2, 'slide', 'sort', 'zh-cn'),
(2, 'product', 'currency', 'zh-cn'),
(2, 'product', 'create', 'zh-cn'),
(2, 'product', 'changeStatus', 'zh-cn'),
(2, 'product', 'edit', 'zh-cn'),
(2, 'product', 'admin', 'zh-cn'),
(2, 'slide', 'delete', 'zh-cn'),
(2, 'ui', 'deleteFavicon', 'zh-cn'),
(2, 'ui', 'setBaseStyle', 'zh-cn'),
(2, 'slide', 'create', 'zh-cn'),
(2, 'slide', 'admin', 'zh-cn'),
(2, 'ui', 'deleteLogo', 'zh-cn'),
(2, 'ui', 'others', 'zh-cn'),
(2, 'slide', 'edit', 'zh-cn'),
(2, 'file', 'delete', 'zh-cn'),
(3, 'message', 'delete', 'zh-cn'),
(3, 'reply', 'delete', 'zh-cn'),
(3, 'message', 'pass', 'zh-cn'),
(3, 'message', 'reply', 'zh-cn'),
(3, 'message', 'admin', 'zh-cn'),
(3, 'thread', 'deleteFile', 'zh-cn'),
(3, 'reply', 'edit', 'zh-cn'),
(3, 'forum', 'admin', 'zh-cn'),
(3, 'reply', 'admin', 'zh-cn'),
(3, 'forum', 'update', 'zh-cn'),
(3, 'article', 'admin', 'zh-cn'),
(3, 'product', 'admin', 'zh-cn'),
(3, 'book', 'catalog', 'zh-cn'),
(3, 'book', 'admin', 'zh-cn'),
(3, 'thread', 'delete', 'zh-cn'),
(3, 'reply', 'deleteFile', 'zh-cn'),
(3, 'thread', 'transfer', 'zh-cn'),
(3, 'thread', 'switchStatus', 'zh-cn');

-- --------------------------------------------------------

--
-- 表的结构 `eps_history`
--

CREATE TABLE `eps_history` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `action` mediumint(8) UNSIGNED NOT NULL DEFAULT '0',
  `field` varchar(30) NOT NULL DEFAULT '',
  `old` text NOT NULL,
  `new` text NOT NULL,
  `diff` mediumtext NOT NULL,
  `lang` char(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `eps_layout`
--

CREATE TABLE `eps_layout` (
  `template` varchar(30) NOT NULL DEFAULT 'default',
  `theme` char(30) NOT NULL DEFAULT 'default',
  `page` varchar(30) NOT NULL,
  `region` varchar(30) NOT NULL,
  `object` varchar(30) NOT NULL,
  `blocks` text NOT NULL,
  `import` enum('no','doing','finished') NOT NULL DEFAULT 'no',
  `lang` char(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `eps_layout`
--

INSERT INTO `eps_layout` (`template`, `theme`, `page`, `region`, `object`, `blocks`, `import`, `lang`) VALUES
('default', 'default', 'all', 'top', '', '[{\"id\":\"13\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-cn'),
('default', 'default', 'index_index', 'top', '', '[{\"id\":\"5\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-cn'),
('default', 'default', 'index_index', 'middle', '', '[{\"id\":\"1\",\"grid\":\"4\",\"titleless\":\"0\",\"borderless\":\"0\"},{\"id\":\"11\",\"grid\":\"4\",\"titleless\":\"0\",\"borderless\":\"0\"},{\"id\":\"10\",\"grid\":\"4\",\"titleless\":\"0\",\"borderless\":\"0\"}]', 'no', 'zh-cn'),
('default', 'default', 'index_index', 'bottom', '', '[{\"id\":\"12\",\"grid\":12,\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-cn'),
('default', 'default', 'company_index', 'side', '', '[{\"id\":\"10\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"14\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-cn'),
('default', 'default', 'article_browse', 'side', '', '[{\"id\":\"6\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"10\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-cn'),
('default', 'default', 'article_view', 'side', '', '[{\"id\":\"6\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"10\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-cn'),
('default', 'default', 'product_browse', 'side', '', '[{\"id\":\"4\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"7\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"10\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-cn'),
('default', 'default', 'product_view', 'side', '', '[{\"id\":\"4\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"7\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"10\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-cn'),
('default', 'default', 'message_index', 'side', '', '[{\"id\":\"10\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-cn'),
('default', 'default', 'blog_index', 'side', '', '[{\"id\":\"15\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"8\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-cn'),
('default', 'default', 'blog_view', 'side', '', '[{\"id\":\"8\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-cn'),
('default', 'default', 'page_index', 'side', '', '[{\"id\":\"9\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"2\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"10\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-cn'),
('default', 'default', 'page_view', 'side', '', '[{\"id\":\"9\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"2\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"10\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-cn'),
('default', 'default', 'all', 'top', '', '[{\"id\":\"113\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'en'),
('default', 'default', 'index_index', 'top', '', '[{\"id\":\"105\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'en'),
('default', 'default', 'index_index', 'middle', '', '[{\"id\":\"1\",\"grid\":\"4\",\"titleless\":\"0\",\"borderless\":\"0\"},{\"id\":\"11\",\"grid\":\"4\",\"titleless\":\"0\",\"borderless\":\"0\"},{\"id\":\"10\",\"grid\":\"4\",\"titleless\":\"0\",\"borderless\":\"0\"}]', 'no', 'en'),
('default', 'default', 'index_index', 'bottom', '', '[{\"id\":\"112\",\"grid\":12,\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'en'),
('default', 'default', 'company_index', 'side', '', '[{\"id\":\"110\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"114\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'en'),
('default', 'default', 'article_browse', 'side', '', '[{\"id\":\"106\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"110\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'en'),
('default', 'default', 'article_view', 'side', '', '[{\"id\":\"106\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"110\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'en'),
('default', 'default', 'product_browse', 'side', '', '[{\"id\":\"104\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"107\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"110\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'en'),
('default', 'default', 'product_view', 'side', '', '[{\"id\":\"104\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"107\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"110\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'en'),
('default', 'default', 'message_index', 'side', '', '[{\"id\":\"110\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'en'),
('default', 'default', 'blog_index', 'side', '', '[{\"id\":\"115\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"108\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'en'),
('default', 'default', 'blog_view', 'side', '', '[{\"id\":\"108\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'en'),
('default', 'default', 'page_index', 'side', '', '[{\"id\":\"109\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"102\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"110\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'en'),
('default', 'default', 'page_view', 'side', '', '[{\"id\":\"109\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"102\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"110\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'en'),
('default', 'default', 'all', 'top', '', '[{\"id\":\"213\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-tw'),
('default', 'default', 'index_index', 'top', '', '[{\"id\":\"205\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-tw'),
('default', 'default', 'index_index', 'middle', '', '[{\"id\":\"1\",\"grid\":\"4\",\"titleless\":\"0\",\"borderless\":\"0\"},{\"id\":\"11\",\"grid\":\"4\",\"titleless\":\"0\",\"borderless\":\"0\"},{\"id\":\"10\",\"grid\":\"4\",\"titleless\":\"0\",\"borderless\":\"0\"}]', 'no', 'zh-tw'),
('default', 'default', 'index_index', 'bottom', '', '[{\"id\":\"212\",\"grid\":12,\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-tw'),
('default', 'default', 'company_index', 'side', '', '[{\"id\":\"210\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"214\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-tw'),
('default', 'default', 'article_browse', 'side', '', '[{\"id\":\"206\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"210\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-tw'),
('default', 'default', 'article_view', 'side', '', '[{\"id\":\"206\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"210\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-tw'),
('default', 'default', 'product_browse', 'side', '', '[{\"id\":\"204\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"207\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"210\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-tw'),
('default', 'default', 'product_view', 'side', '', '[{\"id\":\"204\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"207\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"210\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-tw'),
('default', 'default', 'message_index', 'side', '', '[{\"id\":\"210\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-tw'),
('default', 'default', 'blog_index', 'side', '', '[{\"id\":\"215\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"208\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-tw'),
('default', 'default', 'blog_view', 'side', '', '[{\"id\":\"208\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-tw'),
('default', 'default', 'page_index', 'side', '', '[{\"id\":\"209\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"202\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"210\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-tw'),
('default', 'default', 'page_view', 'side', '', '[{\"id\":\"209\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"202\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"210\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-tw'),
('mobile', 'default', 'all', 'top', '', '[{\"id\":\"34\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-cn'),
('mobile', 'default', 'index_index', 'top', '', '[{\"id\":\"25\",\"grid\":\"0\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":\"0\",\"borderless\":\"0\"}]', 'no', 'zh-cn'),
('mobile', 'default', 'index_index', 'middle', '', '[{\"id\":\"31\",\"grid\":\"0\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":\"0\",\"borderless\":\"0\"},{\"id\":\"23\",\"grid\":\"12\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":\"0\",\"borderless\":\"0\"},{\"id\":\"21\",\"grid\":\"0\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":\"0\",\"borderless\":\"0\"}]', 'no', 'zh-cn'),
('mobile', 'default', 'all', 'top', '', '[{\"id\":\"134\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'en'),
('mobile', 'default', 'index_index', 'top', '', '[{\"id\":\"125\",\"grid\":\"0\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":\"0\",\"borderless\":\"0\"}]', 'no', 'en'),
('mobile', 'default', 'index_index', 'middle', '', '[{\"id\":\"131\",\"grid\":\"0\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":\"0\",\"borderless\":\"0\"},{\"id\":\"123\",\"grid\":\"12\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":\"0\",\"borderless\":\"0\"},{\"id\":\"121\",\"grid\":\"0\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":\"0\",\"borderless\":\"0\"}]', 'no', 'en'),
('mobile', 'default', 'all', 'top', '', '[{\"id\":\"234\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-tw'),
('mobile', 'default', 'index_index', 'top', '', '[{\"id\":\"225\",\"grid\":\"0\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":\"0\",\"borderless\":\"0\"}]', 'no', 'zh-tw'),
('mobile', 'default', 'index_index', 'middle', '', '[{\"id\":\"231\",\"grid\":\"0\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":\"0\",\"borderless\":\"0\"},{\"id\":\"223\",\"grid\":\"12\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":\"0\",\"borderless\":\"0\"},{\"id\":\"221\",\"grid\":\"0\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":\"0\",\"borderless\":\"0\"}]', 'no', 'zh-tw'),
('default', 'tartan', 'all', 'top', '', '[{\"id\":\"113\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'en'),
('default', 'tartan', 'all', 'top', '', '[{\"id\":\"13\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-cn'),
('default', 'tartan', 'all', 'top', '', '[{\"id\":\"213\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-tw'),
('default', 'tartan', 'article_browse', 'side', '', '[{\"id\":\"106\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"110\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'en'),
('default', 'tartan', 'article_browse', 'side', '', '[{\"id\":\"6\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"10\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-cn'),
('default', 'tartan', 'article_browse', 'side', '', '[{\"id\":\"206\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"210\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-tw'),
('default', 'tartan', 'article_view', 'side', '', '[{\"id\":\"106\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"110\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'en'),
('default', 'tartan', 'article_view', 'side', '', '[{\"id\":\"6\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"10\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-cn'),
('default', 'tartan', 'article_view', 'side', '', '[{\"id\":\"206\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"210\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-tw'),
('default', 'tartan', 'blog_index', 'side', '', '[{\"id\":\"115\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"108\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'en'),
('default', 'tartan', 'blog_index', 'side', '', '[{\"id\":\"15\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"8\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-cn'),
('default', 'tartan', 'blog_index', 'side', '', '[{\"id\":\"215\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"208\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-tw'),
('default', 'tartan', 'blog_view', 'side', '', '[{\"id\":\"108\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'en'),
('default', 'tartan', 'blog_view', 'side', '', '[{\"id\":\"8\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-cn'),
('default', 'tartan', 'blog_view', 'side', '', '[{\"id\":\"208\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-tw'),
('default', 'tartan', 'company_index', 'side', '', '[{\"id\":\"110\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"114\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'en'),
('default', 'tartan', 'company_index', 'side', '', '[{\"id\":\"10\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"14\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-cn'),
('default', 'tartan', 'company_index', 'side', '', '[{\"id\":\"210\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"214\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-tw'),
('default', 'tartan', 'index_index', 'bottom', '', '[{\"id\":\"112\",\"grid\":12,\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'en'),
('default', 'tartan', 'index_index', 'bottom', '', '[{\"id\":\"12\",\"grid\":12,\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-cn'),
('default', 'tartan', 'index_index', 'bottom', '', '[{\"id\":\"212\",\"grid\":12,\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-tw'),
('default', 'tartan', 'index_index', 'middle', '', '[{\"id\":\"1\",\"grid\":\"4\",\"titleless\":\"0\",\"borderless\":\"0\"},{\"id\":\"11\",\"grid\":\"4\",\"titleless\":\"0\",\"borderless\":\"0\"},{\"id\":\"10\",\"grid\":\"4\",\"titleless\":\"0\",\"borderless\":\"0\"}]', 'no', 'en'),
('default', 'tartan', 'index_index', 'middle', '', '[{\"id\":\"1\",\"grid\":\"4\",\"titleless\":\"0\",\"borderless\":\"0\"},{\"id\":\"11\",\"grid\":\"4\",\"titleless\":\"0\",\"borderless\":\"0\"},{\"id\":\"10\",\"grid\":\"4\",\"titleless\":\"0\",\"borderless\":\"0\"}]', 'no', 'zh-cn'),
('default', 'tartan', 'index_index', 'middle', '', '[{\"id\":\"1\",\"grid\":\"4\",\"titleless\":\"0\",\"borderless\":\"0\"},{\"id\":\"11\",\"grid\":\"4\",\"titleless\":\"0\",\"borderless\":\"0\"},{\"id\":\"10\",\"grid\":\"4\",\"titleless\":\"0\",\"borderless\":\"0\"}]', 'no', 'zh-tw'),
('default', 'tartan', 'index_index', 'top', '', '[{\"id\":\"105\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'en'),
('default', 'tartan', 'index_index', 'top', '', '[{\"id\":\"5\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-cn'),
('default', 'tartan', 'index_index', 'top', '', '[{\"id\":\"205\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-tw'),
('default', 'tartan', 'message_index', 'side', '', '[{\"id\":\"110\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'en'),
('default', 'tartan', 'message_index', 'side', '', '[{\"id\":\"10\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-cn'),
('default', 'tartan', 'message_index', 'side', '', '[{\"id\":\"210\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-tw'),
('default', 'tartan', 'page_index', 'side', '', '[{\"id\":\"109\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"102\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"110\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'en'),
('default', 'tartan', 'page_index', 'side', '', '[{\"id\":\"9\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"2\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"10\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-cn'),
('default', 'tartan', 'page_index', 'side', '', '[{\"id\":\"209\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"202\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"210\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-tw'),
('default', 'tartan', 'page_view', 'side', '', '[{\"id\":\"109\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"102\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"110\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'en'),
('default', 'tartan', 'page_view', 'side', '', '[{\"id\":\"9\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"2\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"10\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-cn'),
('default', 'tartan', 'page_view', 'side', '', '[{\"id\":\"209\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"202\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"210\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-tw'),
('default', 'tartan', 'product_browse', 'side', '', '[{\"id\":\"104\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"107\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"110\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'en'),
('default', 'tartan', 'product_browse', 'side', '', '[{\"id\":\"4\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"7\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"10\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-cn'),
('default', 'tartan', 'product_browse', 'side', '', '[{\"id\":\"204\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"207\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"210\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-tw'),
('default', 'tartan', 'product_view', 'side', '', '[{\"id\":\"104\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"107\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"110\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'en'),
('default', 'tartan', 'product_view', 'side', '', '[{\"id\":\"4\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"7\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"10\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-cn'),
('default', 'tartan', 'product_view', 'side', '', '[{\"id\":\"204\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"207\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"210\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-tw'),
('default', 'clean', 'all', 'top', '', '[{\"id\":\"113\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'en'),
('default', 'clean', 'all', 'top', '', '[{\"id\":\"13\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-cn'),
('default', 'clean', 'all', 'top', '', '[{\"id\":\"213\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-tw'),
('default', 'clean', 'article_browse', 'side', '', '[{\"id\":\"106\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"110\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'en'),
('default', 'clean', 'article_browse', 'side', '', '[{\"id\":\"6\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"10\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-cn'),
('default', 'clean', 'article_browse', 'side', '', '[{\"id\":\"206\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"210\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-tw'),
('default', 'clean', 'article_view', 'side', '', '[{\"id\":\"106\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"110\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'en'),
('default', 'clean', 'article_view', 'side', '', '[{\"id\":\"6\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"10\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-cn'),
('default', 'clean', 'article_view', 'side', '', '[{\"id\":\"206\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"210\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-tw'),
('default', 'clean', 'blog_index', 'side', '', '[{\"id\":\"115\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"108\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'en'),
('default', 'clean', 'blog_index', 'side', '', '[{\"id\":\"15\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"8\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-cn'),
('default', 'clean', 'blog_index', 'side', '', '[{\"id\":\"215\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"208\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-tw'),
('default', 'clean', 'blog_view', 'side', '', '[{\"id\":\"108\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'en'),
('default', 'clean', 'blog_view', 'side', '', '[{\"id\":\"8\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-cn'),
('default', 'clean', 'blog_view', 'side', '', '[{\"id\":\"208\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-tw'),
('default', 'clean', 'company_index', 'side', '', '[{\"id\":\"110\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"114\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'en'),
('default', 'clean', 'company_index', 'side', '', '[{\"id\":\"10\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"14\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-cn'),
('default', 'clean', 'company_index', 'side', '', '[{\"id\":\"210\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"214\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-tw'),
('default', 'clean', 'index_index', 'bottom', '', '[{\"id\":\"112\",\"grid\":12,\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'en'),
('default', 'clean', 'index_index', 'bottom', '', '[{\"id\":\"12\",\"grid\":12,\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-cn'),
('default', 'clean', 'index_index', 'bottom', '', '[{\"id\":\"212\",\"grid\":12,\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-tw'),
('default', 'clean', 'index_index', 'middle', '', '[{\"id\":\"1\",\"grid\":\"4\",\"titleless\":\"0\",\"borderless\":\"0\"},{\"id\":\"11\",\"grid\":\"4\",\"titleless\":\"0\",\"borderless\":\"0\"},{\"id\":\"10\",\"grid\":\"4\",\"titleless\":\"0\",\"borderless\":\"0\"}]', 'no', 'en'),
('default', 'clean', 'index_index', 'middle', '', '[{\"id\":\"1\",\"grid\":\"4\",\"titleless\":\"0\",\"borderless\":\"0\"},{\"id\":\"11\",\"grid\":\"4\",\"titleless\":\"0\",\"borderless\":\"0\"},{\"id\":\"10\",\"grid\":\"4\",\"titleless\":\"0\",\"borderless\":\"0\"}]', 'no', 'zh-cn'),
('default', 'clean', 'index_index', 'middle', '', '[{\"id\":\"1\",\"grid\":\"4\",\"titleless\":\"0\",\"borderless\":\"0\"},{\"id\":\"11\",\"grid\":\"4\",\"titleless\":\"0\",\"borderless\":\"0\"},{\"id\":\"10\",\"grid\":\"4\",\"titleless\":\"0\",\"borderless\":\"0\"}]', 'no', 'zh-tw'),
('default', 'clean', 'index_index', 'top', '', '[{\"id\":\"105\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'en'),
('default', 'clean', 'index_index', 'top', '', '[{\"id\":\"5\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-cn'),
('default', 'clean', 'index_index', 'top', '', '[{\"id\":\"205\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-tw'),
('default', 'clean', 'message_index', 'side', '', '[{\"id\":\"110\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'en'),
('default', 'clean', 'message_index', 'side', '', '[{\"id\":\"10\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-cn'),
('default', 'clean', 'message_index', 'side', '', '[{\"id\":\"210\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-tw'),
('default', 'clean', 'page_index', 'side', '', '[{\"id\":\"109\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"102\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"110\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'en'),
('default', 'clean', 'page_index', 'side', '', '[{\"id\":\"9\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"2\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"10\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-cn'),
('default', 'clean', 'page_index', 'side', '', '[{\"id\":\"209\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"202\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"210\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-tw'),
('default', 'clean', 'page_view', 'side', '', '[{\"id\":\"109\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"102\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"110\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'en'),
('default', 'clean', 'page_view', 'side', '', '[{\"id\":\"9\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"2\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"10\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-cn'),
('default', 'clean', 'page_view', 'side', '', '[{\"id\":\"209\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"202\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"210\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-tw'),
('default', 'clean', 'product_browse', 'side', '', '[{\"id\":\"104\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"107\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"110\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'en'),
('default', 'clean', 'product_browse', 'side', '', '[{\"id\":\"4\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"7\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"10\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-cn'),
('default', 'clean', 'product_browse', 'side', '', '[{\"id\":\"204\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"207\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"210\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-tw'),
('default', 'clean', 'product_view', 'side', '', '[{\"id\":\"104\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"107\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"110\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'en'),
('default', 'clean', 'product_view', 'side', '', '[{\"id\":\"4\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"7\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"10\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-cn'),
('default', 'clean', 'product_view', 'side', '', '[{\"id\":\"204\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"207\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"210\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-tw'),
('default', 'wide', 'all', 'top', '', '[{\"id\":\"113\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'en'),
('default', 'wide', 'all', 'top', '', '[{\"id\":\"13\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-cn'),
('default', 'wide', 'all', 'top', '', '[{\"id\":\"213\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-tw'),
('default', 'wide', 'article_browse', 'side', '', '[{\"id\":\"106\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"110\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'en'),
('default', 'wide', 'article_browse', 'side', '', '[{\"id\":\"6\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"10\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-cn'),
('default', 'wide', 'article_browse', 'side', '', '[{\"id\":\"206\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"210\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-tw'),
('default', 'wide', 'article_view', 'side', '', '[{\"id\":\"106\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"110\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'en'),
('default', 'wide', 'article_view', 'side', '', '[{\"id\":\"6\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"10\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-cn'),
('default', 'wide', 'article_view', 'side', '', '[{\"id\":\"206\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"210\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-tw'),
('default', 'wide', 'blog_index', 'side', '', '[{\"id\":\"115\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"108\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'en'),
('default', 'wide', 'blog_index', 'side', '', '[{\"id\":\"15\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"8\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-cn'),
('default', 'wide', 'blog_index', 'side', '', '[{\"id\":\"215\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"208\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-tw'),
('default', 'wide', 'blog_view', 'side', '', '[{\"id\":\"108\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'en'),
('default', 'wide', 'blog_view', 'side', '', '[{\"id\":\"8\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-cn'),
('default', 'wide', 'blog_view', 'side', '', '[{\"id\":\"208\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-tw'),
('default', 'wide', 'company_index', 'side', '', '[{\"id\":\"110\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"114\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'en'),
('default', 'wide', 'company_index', 'side', '', '[{\"id\":\"10\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"14\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-cn'),
('default', 'wide', 'company_index', 'side', '', '[{\"id\":\"210\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"214\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-tw'),
('default', 'wide', 'index_index', 'bottom', '', '[{\"id\":\"112\",\"grid\":12,\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'en'),
('default', 'wide', 'index_index', 'bottom', '', '[{\"id\":\"12\",\"grid\":12,\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-cn'),
('default', 'wide', 'index_index', 'bottom', '', '[{\"id\":\"212\",\"grid\":12,\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-tw'),
('default', 'wide', 'index_index', 'middle', '', '[{\"id\":\"1\",\"grid\":\"4\",\"titleless\":\"0\",\"borderless\":\"0\"},{\"id\":\"11\",\"grid\":\"4\",\"titleless\":\"0\",\"borderless\":\"0\"},{\"id\":\"10\",\"grid\":\"4\",\"titleless\":\"0\",\"borderless\":\"0\"}]', 'no', 'en'),
('default', 'wide', 'index_index', 'middle', '', '[{\"id\":\"1\",\"grid\":\"4\",\"titleless\":\"0\",\"borderless\":\"0\"},{\"id\":\"11\",\"grid\":\"4\",\"titleless\":\"0\",\"borderless\":\"0\"},{\"id\":\"10\",\"grid\":\"4\",\"titleless\":\"0\",\"borderless\":\"0\"}]', 'no', 'zh-cn'),
('default', 'wide', 'index_index', 'middle', '', '[{\"id\":\"1\",\"grid\":\"4\",\"titleless\":\"0\",\"borderless\":\"0\"},{\"id\":\"11\",\"grid\":\"4\",\"titleless\":\"0\",\"borderless\":\"0\"},{\"id\":\"10\",\"grid\":\"4\",\"titleless\":\"0\",\"borderless\":\"0\"}]', 'no', 'zh-tw'),
('default', 'wide', 'index_index', 'top', '', '[{\"id\":\"105\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'en'),
('default', 'wide', 'index_index', 'top', '', '[{\"id\":\"5\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-cn'),
('default', 'wide', 'index_index', 'top', '', '[{\"id\":\"205\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-tw'),
('default', 'wide', 'message_index', 'side', '', '[{\"id\":\"110\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'en'),
('default', 'wide', 'message_index', 'side', '', '[{\"id\":\"10\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-cn'),
('default', 'wide', 'message_index', 'side', '', '[{\"id\":\"210\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-tw'),
('default', 'wide', 'page_index', 'side', '', '[{\"id\":\"109\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"102\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"110\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'en'),
('default', 'wide', 'page_index', 'side', '', '[{\"id\":\"9\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"2\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"10\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-cn'),
('default', 'wide', 'page_index', 'side', '', '[{\"id\":\"209\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"202\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"210\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-tw'),
('default', 'wide', 'page_view', 'side', '', '[{\"id\":\"109\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"102\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"110\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'en'),
('default', 'wide', 'page_view', 'side', '', '[{\"id\":\"9\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"2\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"10\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-cn'),
('default', 'wide', 'page_view', 'side', '', '[{\"id\":\"209\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"202\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"210\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-tw'),
('default', 'wide', 'product_browse', 'side', '', '[{\"id\":\"104\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"107\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"110\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'en'),
('default', 'wide', 'product_browse', 'side', '', '[{\"id\":\"4\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"7\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"10\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-cn'),
('default', 'wide', 'product_browse', 'side', '', '[{\"id\":\"204\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"207\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"210\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-tw'),
('default', 'wide', 'product_view', 'side', '', '[{\"id\":\"104\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"107\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"110\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'en'),
('default', 'wide', 'product_view', 'side', '', '[{\"id\":\"4\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"7\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"10\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-cn'),
('default', 'wide', 'product_view', 'side', '', '[{\"id\":\"204\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"207\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"210\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-tw'),
('default', 'blank', 'all', 'top', '', '[{\"id\":\"113\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'en'),
('default', 'blank', 'all', 'top', '', '[{\"id\":\"13\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-cn'),
('default', 'blank', 'all', 'top', '', '[{\"id\":\"213\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-tw'),
('default', 'blank', 'article_browse', 'side', '', '[{\"id\":\"106\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"110\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'en'),
('default', 'blank', 'article_browse', 'side', '', '[{\"id\":\"6\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"10\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-cn'),
('default', 'blank', 'article_browse', 'side', '', '[{\"id\":\"206\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"210\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-tw'),
('default', 'blank', 'article_view', 'side', '', '[{\"id\":\"106\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"110\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'en'),
('default', 'blank', 'article_view', 'side', '', '[{\"id\":\"6\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"10\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-cn'),
('default', 'blank', 'article_view', 'side', '', '[{\"id\":\"206\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"210\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-tw'),
('default', 'blank', 'blog_index', 'side', '', '[{\"id\":\"115\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"108\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'en'),
('default', 'blank', 'blog_index', 'side', '', '[{\"id\":\"15\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"8\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-cn'),
('default', 'blank', 'blog_index', 'side', '', '[{\"id\":\"215\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"208\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-tw'),
('default', 'blank', 'blog_view', 'side', '', '[{\"id\":\"108\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'en');
INSERT INTO `eps_layout` (`template`, `theme`, `page`, `region`, `object`, `blocks`, `import`, `lang`) VALUES
('default', 'blank', 'blog_view', 'side', '', '[{\"id\":\"8\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-cn'),
('default', 'blank', 'blog_view', 'side', '', '[{\"id\":\"208\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-tw'),
('default', 'blank', 'company_index', 'side', '', '[{\"id\":\"110\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"114\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'en'),
('default', 'blank', 'company_index', 'side', '', '[{\"id\":\"10\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"14\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-cn'),
('default', 'blank', 'company_index', 'side', '', '[{\"id\":\"210\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"214\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-tw'),
('default', 'blank', 'index_index', 'bottom', '', '[{\"id\":\"112\",\"grid\":12,\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'en'),
('default', 'blank', 'index_index', 'bottom', '', '[{\"id\":\"12\",\"grid\":12,\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-cn'),
('default', 'blank', 'index_index', 'bottom', '', '[{\"id\":\"212\",\"grid\":12,\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-tw'),
('default', 'blank', 'index_index', 'middle', '', '[{\"id\":\"1\",\"grid\":\"4\",\"titleless\":\"0\",\"borderless\":\"0\"},{\"id\":\"11\",\"grid\":\"4\",\"titleless\":\"0\",\"borderless\":\"0\"},{\"id\":\"10\",\"grid\":\"4\",\"titleless\":\"0\",\"borderless\":\"0\"}]', 'no', 'en'),
('default', 'blank', 'index_index', 'middle', '', '[{\"id\":\"1\",\"grid\":\"4\",\"titleless\":\"0\",\"borderless\":\"0\"},{\"id\":\"11\",\"grid\":\"4\",\"titleless\":\"0\",\"borderless\":\"0\"},{\"id\":\"10\",\"grid\":\"4\",\"titleless\":\"0\",\"borderless\":\"0\"}]', 'no', 'zh-cn'),
('default', 'blank', 'index_index', 'middle', '', '[{\"id\":\"1\",\"grid\":\"4\",\"titleless\":\"0\",\"borderless\":\"0\"},{\"id\":\"11\",\"grid\":\"4\",\"titleless\":\"0\",\"borderless\":\"0\"},{\"id\":\"10\",\"grid\":\"4\",\"titleless\":\"0\",\"borderless\":\"0\"}]', 'no', 'zh-tw'),
('default', 'blank', 'index_index', 'top', '', '[{\"id\":\"105\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'en'),
('default', 'blank', 'index_index', 'top', '', '[{\"id\":\"5\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-cn'),
('default', 'blank', 'index_index', 'top', '', '[{\"id\":\"205\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-tw'),
('default', 'blank', 'message_index', 'side', '', '[{\"id\":\"110\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'en'),
('default', 'blank', 'message_index', 'side', '', '[{\"id\":\"10\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-cn'),
('default', 'blank', 'message_index', 'side', '', '[{\"id\":\"210\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-tw'),
('default', 'blank', 'page_index', 'side', '', '[{\"id\":\"109\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"102\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"110\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'en'),
('default', 'blank', 'page_index', 'side', '', '[{\"id\":\"9\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"2\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"10\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-cn'),
('default', 'blank', 'page_index', 'side', '', '[{\"id\":\"209\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"202\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"210\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-tw'),
('default', 'blank', 'page_view', 'side', '', '[{\"id\":\"109\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"102\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"110\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'en'),
('default', 'blank', 'page_view', 'side', '', '[{\"id\":\"9\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"2\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"10\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-cn'),
('default', 'blank', 'page_view', 'side', '', '[{\"id\":\"209\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"202\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"210\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-tw'),
('default', 'blank', 'product_browse', 'side', '', '[{\"id\":\"104\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"107\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"110\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'en'),
('default', 'blank', 'product_browse', 'side', '', '[{\"id\":\"4\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"7\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"10\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-cn'),
('default', 'blank', 'product_browse', 'side', '', '[{\"id\":\"204\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"207\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"210\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-tw'),
('default', 'blank', 'product_view', 'side', '', '[{\"id\":\"104\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"107\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"110\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'en'),
('default', 'blank', 'product_view', 'side', '', '[{\"id\":\"4\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"7\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"10\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-cn'),
('default', 'blank', 'product_view', 'side', '', '[{\"id\":\"204\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"207\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0},{\"id\":\"210\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-tw'),
('mobile', 'colorful', 'all', 'top', '', '[{\"id\":\"134\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'en'),
('mobile', 'colorful', 'all', 'top', '', '[{\"id\":\"34\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-cn'),
('mobile', 'colorful', 'all', 'top', '', '[{\"id\":\"234\",\"grid\":\"\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":0,\"borderless\":0}]', 'no', 'zh-tw'),
('mobile', 'colorful', 'index_index', 'middle', '', '[{\"id\":\"131\",\"grid\":\"0\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":\"0\",\"borderless\":\"0\"},{\"id\":\"123\",\"grid\":\"12\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":\"0\",\"borderless\":\"0\"},{\"id\":\"121\",\"grid\":\"0\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":\"0\",\"borderless\":\"0\"}]', 'no', 'en'),
('mobile', 'colorful', 'index_index', 'middle', '', '[{\"id\":\"31\",\"grid\":\"0\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":\"0\",\"borderless\":\"0\"},{\"id\":\"23\",\"grid\":\"12\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":\"0\",\"borderless\":\"0\"},{\"id\":\"21\",\"grid\":\"0\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":\"0\",\"borderless\":\"0\"}]', 'no', 'zh-cn'),
('mobile', 'colorful', 'index_index', 'middle', '', '[{\"id\":\"231\",\"grid\":\"0\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":\"0\",\"borderless\":\"0\"},{\"id\":\"223\",\"grid\":\"12\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":\"0\",\"borderless\":\"0\"},{\"id\":\"221\",\"grid\":\"0\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":\"0\",\"borderless\":\"0\"}]', 'no', 'zh-tw'),
('mobile', 'colorful', 'index_index', 'top', '', '[{\"id\":\"125\",\"grid\":\"0\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":\"0\",\"borderless\":\"0\"}]', 'no', 'en'),
('mobile', 'colorful', 'index_index', 'top', '', '[{\"id\":\"25\",\"grid\":\"0\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":\"0\",\"borderless\":\"0\"}]', 'no', 'zh-cn'),
('mobile', 'colorful', 'index_index', 'top', '', '[{\"id\":\"225\",\"grid\":\"0\",\"probability\":\"\",\"isRandom\":\"\",\"titleless\":\"0\",\"borderless\":\"0\"}]', 'no', 'zh-tw');

-- --------------------------------------------------------

--
-- 表的结构 `eps_log`
--

CREATE TABLE `eps_log` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `account` char(30) NOT NULL,
  `browser` char(100) NOT NULL,
  `ip` char(40) NOT NULL,
  `location` char(100) NOT NULL,
  `date` datetime NOT NULL,
  `desc` text NOT NULL,
  `ext` text NOT NULL,
  `type` varchar(30) NOT NULL DEFAULT 'adminlogin',
  `lang` char(30) NOT NULL DEFAULT 'all'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `eps_message`
--

CREATE TABLE `eps_message` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `type` char(20) NOT NULL,
  `objectType` varchar(30) NOT NULL DEFAULT '',
  `objectID` mediumint(8) UNSIGNED NOT NULL DEFAULT '0',
  `account` char(30) NOT NULL,
  `from` char(30) NOT NULL,
  `to` char(30) NOT NULL,
  `phone` char(30) NOT NULL,
  `mobile` char(11) NOT NULL,
  `email` varchar(90) NOT NULL,
  `qq` char(30) NOT NULL,
  `date` datetime NOT NULL,
  `content` text NOT NULL,
  `link` varchar(100) NOT NULL,
  `ip` varchar(40) NOT NULL,
  `status` char(20) NOT NULL,
  `public` enum('0','1') NOT NULL DEFAULT '1',
  `readed` enum('0','1') NOT NULL,
  `receiveEmail` enum('0','1') NOT NULL DEFAULT '0',
  `lang` char(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `eps_oauth`
--

CREATE TABLE `eps_oauth` (
  `account` varchar(30) NOT NULL,
  `provider` varchar(30) NOT NULL,
  `openID` varchar(60) NOT NULL,
  `unionID` varchar(60) NOT NULL,
  `lang` char(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `eps_operationlog`
--

CREATE TABLE `eps_operationlog` (
  `id` mediumint(8) NOT NULL,
  `type` varchar(30) NOT NULL,
  `identity` varchar(100) NOT NULL,
  `operation` varchar(200) NOT NULL,
  `count` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `createdTime` datetime NOT NULL,
  `lang` char(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `eps_order`
--

CREATE TABLE `eps_order` (
  `id` mediumint(9) NOT NULL,
  `humanID` char(13) NOT NULL,
  `account` char(30) NOT NULL,
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `balance` decimal(10,2) UNSIGNED NOT NULL DEFAULT '0.00',
  `payment` char(30) NOT NULL,
  `sn` char(50) NOT NULL,
  `refundSN` char(50) NOT NULL,
  `address` text NOT NULL,
  `note` text NOT NULL,
  `createdDate` datetime NOT NULL,
  `paidDate` datetime NOT NULL,
  `payStatus` enum('not_paid','paid','refunding','refunded') NOT NULL DEFAULT 'not_paid',
  `deliveriedDate` datetime NOT NULL,
  `deliveriedBy` char(30) NOT NULL,
  `deliveryStatus` enum('not_send','send','confirmed') NOT NULL DEFAULT 'not_send',
  `express` char(30) NOT NULL,
  `waybill` char(30) NOT NULL,
  `confirmedDate` datetime NOT NULL,
  `finishedDate` datetime NOT NULL,
  `finishedBy` char(30) NOT NULL,
  `status` enum('normal','canceled','finished','deleted','expired') NOT NULL DEFAULT 'normal',
  `last` datetime NOT NULL,
  `type` varchar(30) NOT NULL DEFAULT 'shop',
  `lang` char(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `eps_order`
--

INSERT INTO `eps_order` (`id`, `humanID`, `account`, `amount`, `balance`, `payment`, `sn`, `refundSN`, `address`, `note`, `createdDate`, `paidDate`, `payStatus`, `deliveriedDate`, `deliveriedBy`, `deliveryStatus`, `express`, `waybill`, `confirmedDate`, `finishedDate`, `finishedBy`, `status`, `last`, `type`, `lang`) VALUES
(1, '', 'demo', '0.01', '0.00', 'COD', '', '', '张三丰 [15988898558] 位于湖北省西北部的十堰市丹江口市境内 266555', '', '2015-02-12 14:24:53', '0000-00-00 00:00:00', 'not_paid', '0000-00-00 00:00:00', '', 'not_send', '0', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 'expired', '2021-06-21 20:48:32', 'shop', 'zh-cn'),
(2, '', 'demo', '0.01', '0.00', 'alipay', '2015021200001000280046649527', '', '张三丰 [15988898558] 位于湖北省西北部的十堰市丹江口市境内 266555', '', '2015-02-12 14:25:25', '2015-02-12 14:26:05', 'paid', '0000-00-00 00:00:00', '', 'not_send', '0', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 'normal', '0000-00-00 00:00:00', 'shop', 'zh-cn');

-- --------------------------------------------------------

--
-- 表的结构 `eps_order_product`
--

CREATE TABLE `eps_order_product` (
  `id` mediumint(9) NOT NULL,
  `orderID` mediumint(9) UNSIGNED NOT NULL DEFAULT '0',
  `productID` mediumint(8) UNSIGNED NOT NULL DEFAULT '0',
  `productName` varchar(150) NOT NULL,
  `price` decimal(8,2) NOT NULL DEFAULT '0.00',
  `count` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `lang` char(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `eps_order_product`
--

INSERT INTO `eps_order_product` (`id`, `orderID`, `productID`, `productName`, `price`, `count`, `lang`) VALUES
(1, 1, 2, '云蝉知', '0.01', 1, 'zh-cn'),
(2, 2, 2, '云蝉知', '0.01', 1, 'zh-cn');

-- --------------------------------------------------------

--
-- 表的结构 `eps_package`
--

CREATE TABLE `eps_package` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `name` varchar(150) NOT NULL,
  `code` varchar(30) NOT NULL,
  `version` varchar(50) NOT NULL,
  `author` varchar(100) NOT NULL,
  `desc` text NOT NULL,
  `license` text NOT NULL,
  `type` varchar(20) NOT NULL DEFAULT 'extension',
  `site` varchar(150) NOT NULL,
  `chanzhiCompatible` varchar(100) NOT NULL,
  `templateCompatible` varchar(100) NOT NULL,
  `installedTime` datetime NOT NULL,
  `depends` varchar(100) NOT NULL,
  `dirs` text NOT NULL,
  `files` text NOT NULL,
  `status` varchar(20) NOT NULL,
  `lang` char(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `eps_product`
--

CREATE TABLE `eps_product` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `name` varchar(150) NOT NULL,
  `titleColor` varchar(10) NOT NULL,
  `alias` varchar(100) NOT NULL,
  `unsaleable` enum('0','1') NOT NULL DEFAULT '0',
  `mall` text NOT NULL,
  `brand` varchar(100) DEFAULT NULL,
  `model` char(30) DEFAULT NULL,
  `color` char(20) NOT NULL,
  `origin` varchar(50) NOT NULL,
  `unit` char(20) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `negotiate` enum('0','1') NOT NULL DEFAULT '0',
  `promotion` decimal(10,2) NOT NULL,
  `amount` mediumint(8) UNSIGNED DEFAULT NULL,
  `keywords` varchar(150) NOT NULL,
  `desc` text NOT NULL,
  `content` text NOT NULL,
  `author` varchar(60) NOT NULL,
  `editor` varchar(60) NOT NULL,
  `addedDate` datetime NOT NULL,
  `editedDate` datetime NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'normal',
  `views` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `sticky` enum('0','1','2','3') NOT NULL DEFAULT '0',
  `order` smallint(5) UNSIGNED NOT NULL,
  `css` text NOT NULL,
  `js` text NOT NULL,
  `lang` char(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `eps_product`
--

INSERT INTO `eps_product` (`id`, `name`, `titleColor`, `alias`, `unsaleable`, `mall`, `brand`, `model`, `color`, `origin`, `unit`, `price`, `negotiate`, `promotion`, `amount`, `keywords`, `desc`, `content`, `author`, `editor`, `addedDate`, `editedDate`, `status`, `views`, `sticky`, `order`, `css`, `js`, `lang`) VALUES
(1, '演示商品二', '', 'chanzhi', '0', '', '蝉知', '', '', '', '', '8888.00', '0', '0.02', 0, '蝉知企业门户系统', '蝉知企业门户系统是一款专向企业营销使用的企业门户系统，企业使用蝉知系统可以非常方便地搭建一个专业的企业营销网站，进行宣传，开展业务，服务客户。', '<h4>关于蝉知企业门户系统(chanzhiEPS)</h4>\n<p>蝉知企业门户系统是由业内资深开发团队开发的一款专向企业营销使用的企业门户系\n统，企业使用蝉知系统可以非常方便地搭建一个专业的企业营销网站，进行宣传，开展业务，服务客户。蝉知系统内置了文章、产品、论坛、评论、会员、博客、帮\n助等功能，同时还可以和微信进行集成绑定。功能丰富实用，后台操作简洁方便。蝉知系统还内置了搜索引擎优化必备的功能，比如关键词，摘要，站点地图，友好\n路径等，使用蝉知系统可以非常方便的搭建对搜索引擎友好的网站。</p>\n<p><strong>为什么</strong><strong>叫做</strong><strong>蝉知？</strong><strong><br />\n</strong> </p>\n<p>蝉是中国传统的吉祥物之一，象征着闻达和财富，非常符合企业作为盈利组织的特点。所以我们为这套系统起名为蝉知，希望通过这款开源免费的系统可以帮助众多的中小企业快速方面的建立自己的企业网站，进行宣传营销。</p>\n<p><strong>为什么</strong><strong>来</strong><strong>做</strong><strong>蝉知？</strong> </p>\n<p>蝉\n知团队还有其他的开源产品，我们在维护自己的产品的时候，也存在这样的需求：我们需要一个网站来对产品进行宣传，能够给用户提供技术支持，方便用户下载等\n等。我们也曾经想用市面上的其他cms系统来搭建，但后来发现要做大量的改动定制，还不如自己写一个。所以我们在四年多的时间里面一点点的完善自己的产品\n网站。与此同时我们在和客户接触的时候，发现企业的网站大都不敢恭维：技术陈旧、载入速度缓慢、不利于seo、后台晦涩难懂。于是我们就产生了做一个企业\n门户系统来解决这个问题的想法，于是就是了蝉知这个产品。</p>\n<h4><strong>为什么以开源的方式来发布？</strong> </h4>\n<p>蝉知源代码完全开放，不限制商用。我们之所以坚持以开源的方式来发布蝉知系统，是因为我们坚信开放才是正道。只有开放的系统才更具有生命力，用户使用起来才更加放心。</p>\n<p><strong>为什么选择蝉知门户系统来搭建企业网站？</strong> </p>\n<p>现\n在做一个企业营销网站可以有很多选择，比如使用国外开源的wordpress, dupal, jommla等。国内的有dedecms, \nphpcms等cms系统。还有很多在线建站的公司。如果费用充足的话，可以选择建站公司来做（建站公司也是使用上述的这些系统来帮你搭建，比较坑）。那\n么蝉知系统和这些系统相比有什么特点呢？<strong><br />\n</strong> </p>\n<p><strong>1. 首先，我们是专门做企业营销网站。</strong> </p>\n<ul><li>现在做网站，都是在cms系统上面改。而蝉知系统是专门面向企业营销网站的，所以功能更具有针对性。我们内置了文章、产品、会员、论坛、评论、帮助、博客等诸多功能，完全可以应对企业营销网站的各种需求。</li>\n<li>蝉知系统特别重视搜索引擎优化，内置了关键词管理、摘要、站点地图等功能。同时只要环境支持url重写，就可以生成搜索引擎非常喜欢的路径结构，比如/news/123.html这样的路径。</li>\n<li>蝉知系统后续会内置基本的统计数据，哪怕网站只有一个用户访问，也要让您清清楚楚的知道网站有人在访问。这样网站不再是死的的网站。</li>\n</ul>\n<p><strong>2. 其次，</strong><strong>蝉知</strong><strong>系统</strong><strong>是</strong><strong>真正</strong><strong>的</strong><strong>开源</strong><strong>免费</strong> </p>\n<ul><li>蝉知系统是目前唯一开源免费的企业门户系统。</li>\n<li>蝉知系统以LGPL协议发布，代码完全开放，是真正的开源。（有很多号称开源的cms系统，其实都是假的。)</li>\n<li>蝉知系统不限制商用，也不会为了推我们后续的一些收费功能或者服务故意的在产品中做很多限制。<br />\n</li>\n</ul>\n<p><strong>3. 蝉知系统技术先进，注重用户体验</strong> </p>\n<ul><li>蝉知系统使用自主开发的框架搭建，架构更加合理。</li>\n<li>内置完善的扩展机制，方便企业后续的二次开发。蝉知系统的首要定位是帮助企业解决营销问题，当营销问题解决之后，企业会考虑在蝉知系统上搭建自己的业务系统，比如报名、订单之类的业务。这时候在蝉知系统基础上进行二次开发是非常容易的事情。</li>\n<li>蝉知团队不断的学习业内先进的设计理念，给大家提供简洁方便的产品。</li>\n</ul>\n<p><strong>4. </strong><strong>使用</strong><strong>支持</strong><strong>有</strong><strong>保障</strong> </p>\n<ul><li>别人做开源，也许只是兴趣。而我们做开源，是专职在做，以正规的公司形式来运作。</li>\n<li>我们有将近十年的开源软件开发和维护经验，对开源软件的后续开发、支持有丰富的经验。</li>\n<li>我们团队和系统足够开放，后续我们会着手打造一个面向企业营销市场的小生态系统，吸引第三方的设计师、网站建设公司参与。</li>\n</ul>\n<p>so，不要再犹豫，新时代做企业营销，首选蝉知门户系统，靠谱！</p>', 'admin', 'demo', '2014-08-25 14:31:29', '2015-03-03 14:34:24', 'normal', 109, '0', 1, '', '', 'zh-cn'),
(2, '演示商品一', '', '', '0', '', '蝉知', '', '', '', '', '8888.00', '0', '0.01', 0, '', '<p>蝉知在线(以下简称云蝉知)是由青岛息壤网络信息有限公司（以下简称青岛息壤）提供的在线建站服务。</p>', '<p>云蝉知在线(以下简称云蝉知)是由青岛息壤网络信息有限公司(以下简称青岛息壤)提供的在线建站服务。若您申请云蝉知帐户并使用相应服务，您必须先同意此协议：</p>\n<h4>一、服务条款的确认和接纳<br />\n</h4>\n(1) 您必须是能够承担相应法律责任的公司或个人。若您不具备此资格，不能使用云蝉知提供的服务。<br />\n<p>(2) 当您使用服务时，您需阅读并且同意<a href=\"http://www.chanzhi.net/book/chanzhieps/58_license.html\">《蝉知企业门户系统授权协议》</a>；</p>\n<p><span>(3) 当您使用服务时，您需知晓并且同意此《云蝉知在线使用协议》； </span></p>\n(4) 此协议在必要时将进行修改，更新后会以明显的方式通知到用户。 <br />\n<p>(5) 若您继续使用系统提供的服务，则表明您接受新的协议。</p>\n<h4>二、服务内容<br />\n</h4>\n<p>(1) 此协议所述服务仅在云蝉知网站内有效。云蝉知网站是指http://www.chanzhi.net及其所属网页；</p>\n(2) 云蝉知有权根据实际情况自主调整服务内容。<br />\n<h4>三、帐户<br />\n</h4>\n(1) 使用云蝉知服务之前，您必须在云蝉知网站上面注册一个合法的帐号，并如实填写所有资料。如因资料不全而无法及时通知到您而造成的一切损失，青岛息壤不承担任何责任。<br />\n(2) 您应当妥善保管自己的账户和密码，避免丢失，更不能让他人使用。若因此造成损失，青岛息壤不负任何法律责任；<br />\n(3) 您在使用云蝉知服务时必须遵守相关法律法规。青岛息壤对帐户使用服务所产生的与其他公司或者个人的纠纷不负法律责任；<br />\n(4) 云蝉知网站有权对恶意帐户中止服务，且无需特别通知；<h4>四、费用<br />\n</h4>\n<p>(1) 在您正式使用云蝉知服务之前，您需要自己申请域名。<br />\n(2) 云蝉知现在为大家提供免费服务，免费用户可以创建三个站点。每个站点可使用100M空间(包括附件、图片和数据库），每个月10GB流量。如果超出存储空间或者流量，云蝉知网站有权对该站点的访问进行限制。<br />\n(3) 云蝉知后续会提供功能更强的收费版本，收费标准届时会在云蝉知网站公布。云蝉知保留对收费模式和具体金额调整的权利，涉及收费服务，将至提前30天的时间通过电子邮件的形式通知帐户。</p>\n<h4>五、服务终止</h4>\n<p>有下列情形之一的，云蝉知网站有权随时暂停、终止、取消或拒绝帐户服务。<br />\n<br />\n(1) 帐户违反了此协议或已在约定范围内的任一条款；<br />\n(2) 根据此协议相关说明而终止服务；<br />\n(3) 利用云蝉知网站的发布功能滥发重复信息；<br />\n(4) 未经请求或授权向云蝉知网站帐户发送大量与业务不相关的信息；<br />\n(5) 冒用其他企业的名义发布商业信息，进行商业活动；<br />\n(6) 攻击云蝉知网站的数据、网络或服务；</p>\n<p>(7) 盗用他人在云蝉知网站上的帐户名和密码。<br />\n<br />\n以下信息是严格禁止并绝对终止帐户服务，同时不退回购买费用的：<br />\n<br />\n(1) 有关宗教、种族或性别的贬损言辞；<br />\n(2) 骚扰、滥用或威胁其他帐户；<br />\n(3) 侵犯任何第三方著作权、专利、商标、商业秘密或其它专有权利、发表权或隐私权的信息；<br />\n(4) 其它任何违反互联网相关法律法规的信息。</p>\n<h4>六、云蝉知用户的权利和义务</h4>\n<p>(1) 云蝉知服务生效后，帐户就可享受相应服务内容；<br />\n(2) 云蝉知用户在使用云蝉知网站提供的相应服务时，必须保证遵守当地及中国有关法律法规的规定；<br />\n不得利用该网站进行任何非法活动；遵守所有与使用该网站有关的协议、规定、程序和惯例；<br />\n(3) 云蝉知用户对输入数据的准确性、可靠性、合法性、适用性等负责；</p>\n<h4>七、云蝉知的权利和义务<br />\n</h4>\n<p>(1) 云蝉知尽最大努力来保证服务的正常访问以及数据的备份。<br />\n(2) 云蝉知为收费用户提供相应的咨询、技术支持等服务。</p>\n<p>(3)\n对于因不可抗力造成的服务中断、链接受阻或其他缺陷(包括但不限于自然灾害、社会事件以及因网站所具有的特殊性质而产生的包括系统崩溃、数据丢失、黑客攻\n击、电信部门技术调整导致的影响、政府管制而造成的暂时性关闭在内的任何影响网络正常运营的因素)，云蝉知网站不承担任何责任，但将尽力减少因此而给会员\n造成的损失和影响；<br />\n(4) 云蝉知网站对用户因使用云蝉知服务而造成的损失不负法律责任。不论什么情况下对用户因使用云蝉知服务而造成的直接、间接、偶尔的、特殊的惩罚性的损害或其他一切损害概不负法律责任；<br />\n(5) 如因云蝉知原因，造成服务的不正常中断，青岛息壤不承担任何责任，青岛息壤也不承担由此致使会员蒙受的其它方面的连带损失；</p>\n<h4>八、隐私与保密<br />\n</h4>\n<p>(1) 您注册时所填写的个人信息仅限于青岛息壤与您之间联系使用，青岛息壤不得将其用于商业目的。<br />\n(2) 您通过云蝉知产生的任何数据都属于您所有。除非您主动要求我们协助您排查问题，否则青岛息壤的所有员工无权查看、编辑、复制、删除您的任数据。</p>\n<h4>九、最终解释权<br />\n</h4>\n<p>青岛息壤网络信息有限公司对云蝉知保有所有活动、限制等的最终解释权。</p>', 'admin', 'demo', '2014-08-25 15:06:50', '2015-03-03 14:34:06', 'normal', 45, '0', 2, '', '', 'zh-cn');

-- --------------------------------------------------------

--
-- 表的结构 `eps_product_custom`
--

CREATE TABLE `eps_product_custom` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `product` mediumint(8) UNSIGNED NOT NULL DEFAULT '0',
  `label` varchar(100) NOT NULL,
  `value` varchar(200) NOT NULL,
  `order` smallint(5) UNSIGNED NOT NULL,
  `lang` char(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `eps_product_custom`
--

INSERT INTO `eps_product_custom` (`id`, `product`, `label`, `value`, `order`, `lang`) VALUES
(105, 2, '免费空间', '100M', 1, 'zh-cn'),
(107, 1, 'php ', '> 5.2', 0, 'zh-cn'),
(108, 1, 'mysql', '> 4.0', 1, 'zh-cn'),
(104, 2, '免费站点', '3个', 0, 'zh-cn'),
(109, 1, '服务器', 'apache/ngix', 2, 'zh-cn'),
(106, 2, '每月免费流量', '10G', 2, 'zh-cn'),
(110, 1, '价格', '免费', 3, 'zh-cn');

-- --------------------------------------------------------

--
-- 表的结构 `eps_relation`
--

CREATE TABLE `eps_relation` (
  `type` char(20) NOT NULL,
  `id` mediumint(9) NOT NULL,
  `category` smallint(5) NOT NULL,
  `lang` char(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `eps_relation`
--

INSERT INTO `eps_relation` (`type`, `id`, `category`, `lang`) VALUES
('article', 1, 1, 'zh-cn'),
('article', 1, 2, 'zh-cn'),
('article', 3, 2, 'zh-cn'),
('article', 4, 1, 'zh-cn'),
('article', 4, 2, 'zh-cn'),
('article', 5, 1, 'zh-cn'),
('article', 5, 2, 'zh-cn'),
('article', 6, 1, 'zh-cn'),
('article', 6, 2, 'zh-cn'),
('article', 7, 1, 'zh-cn'),
('article', 7, 2, 'zh-cn'),
('article', 8, 1, 'zh-cn'),
('article', 8, 2, 'zh-cn'),
('article', 9, 1, 'zh-cn'),
('article', 9, 2, 'zh-cn'),
('article', 10, 1, 'zh-cn'),
('article', 10, 2, 'zh-cn'),
('article', 12, 12, 'zh-cn'),
('product', 1, 7, 'zh-cn'),
('product', 2, 7, 'zh-cn');

-- --------------------------------------------------------

--
-- 表的结构 `eps_reply`
--

CREATE TABLE `eps_reply` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `thread` mediumint(8) UNSIGNED NOT NULL,
  `reply` mediumint(8) UNSIGNED NOT NULL,
  `content` text NOT NULL,
  `author` char(30) NOT NULL,
  `editor` char(30) NOT NULL,
  `addedDate` datetime NOT NULL,
  `editedDate` datetime NOT NULL,
  `hidden` enum('0','1') NOT NULL DEFAULT '0',
  `lang` char(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `eps_score`
--

CREATE TABLE `eps_score` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `account` varchar(30) NOT NULL,
  `method` varchar(30) NOT NULL,
  `type` varchar(10) NOT NULL,
  `count` smallint(5) UNSIGNED NOT NULL,
  `before` mediumint(5) NOT NULL,
  `after` mediumint(5) NOT NULL,
  `objectType` varchar(30) NOT NULL,
  `objectID` mediumint(9) NOT NULL,
  `actor` varchar(30) NOT NULL,
  `note` varchar(255) NOT NULL,
  `time` datetime NOT NULL,
  `lang` char(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `eps_search_dict`
--

CREATE TABLE `eps_search_dict` (
  `key` smallint(5) UNSIGNED NOT NULL,
  `value` char(3) NOT NULL,
  `lang` char(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `eps_search_index`
--

CREATE TABLE `eps_search_index` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `objectType` char(20) NOT NULL,
  `objectID` mediumint(9) NOT NULL,
  `title` text NOT NULL,
  `content` text NOT NULL,
  `params` text NOT NULL,
  `addedDate` datetime NOT NULL,
  `editedDate` datetime NOT NULL,
  `status` char(30) NOT NULL DEFAULT 'normal',
  `lang` char(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `eps_slide`
--

CREATE TABLE `eps_slide` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `group` smallint(5) UNSIGNED NOT NULL,
  `title` varchar(60) NOT NULL,
  `titleColor` char(10) NOT NULL,
  `mainLink` varchar(255) NOT NULL,
  `target` enum('0','1') NOT NULL DEFAULT '0',
  `backgroundType` char(20) NOT NULL,
  `backgroundColor` char(10) NOT NULL,
  `height` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `image` varchar(100) NOT NULL,
  `label` varchar(255) NOT NULL,
  `buttonClass` varchar(255) NOT NULL,
  `buttonUrl` varchar(255) NOT NULL,
  `buttonTarget` varchar(30) NOT NULL,
  `summary` text NOT NULL,
  `createdDate` datetime NOT NULL,
  `order` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `lang` char(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `eps_slide`
--

INSERT INTO `eps_slide` (`id`, `group`, `title`, `titleColor`, `mainLink`, `target`, `backgroundType`, `backgroundColor`, `height`, `image`, `label`, `buttonClass`, `buttonUrl`, `buttonTarget`, `summary`, `createdDate`, `order`, `lang`) VALUES
(1, 15, '蝉知，专注企业营销!', '#FFF', '', '0', 'color', '#FF9400', 270, '', '[\"\\u8749\\u77e54.3\\u4e0b\\u8f7d\"]', '[\"primary\"]', '[\"http:\\/\\/www.chanzhi.org\\/dynamic\\/103_chanzhi4.3.html\"]', '[\"\"]', '<div><ul><li>功能完备：文章、产品、论坛、手册、留言、评论、博客...</li>\r\n<li>全网营销：一个网站，电脑、手机、微信体验俱佳！</li>\r\n<li>集成微信：内置微信公众平台功能，移动互联，我来做主！</li>\r\n<li>完美SEO：全方位针对搜索引擎优化，轻松斩获最佳排名！</li>\r\n</ul>\r\n</div>', '2015-07-16 15:27:24', 1, 'zh-cn'),
(2, 15, '蝉知，定制性最强！', '#FFF', '', '0', 'color', '#2286D2', 270, '', '[\"\\u8749\\u77e54.3\\u4e0b\\u8f7d\"]', '[\"primary\"]', '[\"http:\\/\\/www.chanzhi.org\\/download\\/103_chanzhi4.3.html\"]', '[\"\"]', '<div><ul><li>底层框架自主开发，结构先进灵活；</li>\r\n<li>自主开发UI框架，更适合国人习惯；</li>\r\n<li>内置扩展机制，方便企业定制开发；</li>\r\n</ul>\r\n</div>', '2015-07-16 15:43:14', 2, 'zh-cn'),
(3, 15, '蝉知，真开源真免费!', '#FFF', '', '0', 'color', '#D92958', 270, '', '[\"\\u8749\\u77e54.3\\u4e0b\\u8f7d\"]', '[\"primary\"]', '[\"http:\\/\\/www.chanzhi.org\\/download\\/103_chanzhi4.3.html\"]', '[\"\"]', '<div><ul><li>国内第一款开源企业门户系统;</li>\r\n<li>授权宽松，商业友好，代码开放;</li>\r\n<li>免费下载，免费使用，不限制商用！</li>\r\n</ul>\r\n</div>', '2015-07-16 15:45:40', 3, 'zh-cn');

-- --------------------------------------------------------

--
-- 表的结构 `eps_statlog`
--

CREATE TABLE `eps_statlog` (
  `id` int(9) UNSIGNED NOT NULL,
  `referer` int(8) NOT NULL,
  `domain` varchar(200) NOT NULL,
  `url` text NOT NULL,
  `link` text NOT NULL,
  `searchEngine` varchar(100) NOT NULL,
  `keywords` varchar(100) NOT NULL,
  `visitor` int(8) NOT NULL,
  `osName` varchar(100) NOT NULL,
  `browserName` varchar(100) NOT NULL,
  `browserVersion` varchar(100) NOT NULL,
  `ip` char(40) NOT NULL,
  `country` varchar(100) NOT NULL,
  `province` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `account` char(30) NOT NULL,
  `year` char(4) NOT NULL,
  `month` char(6) NOT NULL,
  `day` char(8) NOT NULL,
  `hour` char(10) NOT NULL DEFAULT '0',
  `new` tinyint(3) UNSIGNED NOT NULL DEFAULT '1',
  `mobile` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `lang` char(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `eps_statreferer`
--

CREATE TABLE `eps_statreferer` (
  `id` int(9) UNSIGNED NOT NULL,
  `url` text NOT NULL,
  `domain` varchar(200) NOT NULL,
  `searchEngine` char(30) NOT NULL,
  `keywords` char(100) NOT NULL,
  `lang` char(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `eps_statregion`
--

CREATE TABLE `eps_statregion` (
  `id` int(9) UNSIGNED NOT NULL,
  `timeType` enum('year','month','day','hour') NOT NULL DEFAULT 'hour',
  `timeValue` char(10) NOT NULL DEFAULT '0',
  `country` varchar(100) NOT NULL,
  `province` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `pv` mediumint(9) UNSIGNED NOT NULL DEFAULT '0',
  `uv` mediumint(9) UNSIGNED NOT NULL DEFAULT '0',
  `ip` mediumint(9) UNSIGNED NOT NULL DEFAULT '0',
  `lang` char(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `eps_statreport`
--

CREATE TABLE `eps_statreport` (
  `id` int(9) UNSIGNED NOT NULL,
  `type` char(30) NOT NULL,
  `item` char(100) NOT NULL DEFAULT '0',
  `extra` text NOT NULL,
  `timeType` enum('year','month','day','hour') NOT NULL DEFAULT 'hour',
  `timeValue` char(10) NOT NULL DEFAULT '0',
  `pv` mediumint(9) UNSIGNED NOT NULL DEFAULT '0',
  `uv` mediumint(9) UNSIGNED NOT NULL DEFAULT '0',
  `ip` mediumint(9) UNSIGNED NOT NULL DEFAULT '0',
  `lang` char(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `eps_statvisitor`
--

CREATE TABLE `eps_statvisitor` (
  `id` int(9) UNSIGNED NOT NULL,
  `osName` varchar(100) NOT NULL,
  `osVersion` varchar(100) NOT NULL,
  `browserName` varchar(100) NOT NULL,
  `browserVersion` varchar(100) NOT NULL,
  `browserLanguage` varchar(100) NOT NULL,
  `device` varchar(100) NOT NULL,
  `resolution` varchar(100) NOT NULL,
  `createdTime` datetime NOT NULL,
  `lang` char(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `eps_tag`
--

CREATE TABLE `eps_tag` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `tag` varchar(50) NOT NULL,
  `link` varchar(100) NOT NULL,
  `rank` smallint(5) UNSIGNED NOT NULL,
  `lang` char(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `eps_tag`
--

INSERT INTO `eps_tag` (`id`, `tag`, `link`, `rank`, `lang`) VALUES
(1, '安全cms', '', 1, 'zh-cn'),
(2, '企业建站系统', '', 5, 'zh-cn'),
(3, '企业门户', '', 4, 'zh-cn'),
(4, '开源csm', '', 1, 'zh-cn'),
(5, '蝉知空间', '', 1, 'zh-cn'),
(6, '蝉知企业门户系统', '', 3, 'zh-cn'),
(7, '蝉知', '', 1, 'zh-cn'),
(8, '企业建站', '', 2, 'zh-cn'),
(9, '开源CMS', '', 5, 'zh-cn'),
(10, '免费cms', '', 4, 'zh-cn'),
(11, '微信营销系统', '', 1, 'zh-cn'),
(12, '微网站', '', 1, 'zh-cn'),
(13, '移动建站', '', 1, 'zh-cn'),
(14, '手机建站系统', '', 1, 'zh-cn'),
(15, '微信网站', '', 1, 'zh-cn'),
(16, '免费企业建站', '', 1, 'zh-cn');

-- --------------------------------------------------------

--
-- 表的结构 `eps_thread`
--

CREATE TABLE `eps_thread` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `board` mediumint(9) NOT NULL,
  `title` varchar(255) NOT NULL,
  `discussion` enum('0','1') NOT NULL DEFAULT '0',
  `color` char(10) NOT NULL,
  `content` text NOT NULL,
  `author` varchar(60) NOT NULL,
  `editor` varchar(60) NOT NULL,
  `addedDate` datetime NOT NULL,
  `editedDate` datetime NOT NULL,
  `readonly` tinyint(1) NOT NULL DEFAULT '0',
  `views` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `stick` enum('0','1','2','3') NOT NULL DEFAULT '0',
  `stickTime` datetime NOT NULL,
  `stickBold` enum('0','1') NOT NULL DEFAULT '0',
  `replies` smallint(6) NOT NULL,
  `repliedBy` varchar(30) NOT NULL,
  `repliedDate` datetime NOT NULL,
  `replyID` mediumint(8) UNSIGNED NOT NULL,
  `hidden` enum('0','1') NOT NULL DEFAULT '0',
  `link` varchar(255) NOT NULL,
  `lang` char(30) NOT NULL,
  `status` char(10) NOT NULL,
  `ip` char(40) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `eps_thread`
--

INSERT INTO `eps_thread` (`id`, `board`, `title`, `discussion`, `color`, `content`, `author`, `editor`, `addedDate`, `editedDate`, `readonly`, `views`, `stick`, `stickTime`, `stickBold`, `replies`, `repliedBy`, `repliedDate`, `replyID`, `hidden`, `link`, `lang`, `status`, `ip`) VALUES
(1, 5, 'asdfasdf', '0', '', 'adsfasdf', 'demo', '', '2014-09-02 18:27:35', '2014-09-02 18:27:35', 0, 15, '0', '0000-00-00 00:00:00', '0', 0, '', '2014-09-02 18:27:35', 0, '0', '', 'zh-cn', '', '');

-- --------------------------------------------------------

--
-- 表的结构 `eps_user`
--

CREATE TABLE `eps_user` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `account` char(30) NOT NULL DEFAULT '',
  `password` char(32) NOT NULL DEFAULT '',
  `realname` char(30) NOT NULL DEFAULT '',
  `realnames` varchar(100) NOT NULL DEFAULT '',
  `nickname` char(60) NOT NULL DEFAULT '',
  `admin` enum('no','common','super') NOT NULL DEFAULT 'no',
  `avatar` char(30) NOT NULL DEFAULT '',
  `birthday` date NOT NULL,
  `gender` enum('f','m','u') NOT NULL DEFAULT 'u',
  `email` char(90) NOT NULL DEFAULT '',
  `skype` char(90) NOT NULL,
  `qq` char(20) NOT NULL DEFAULT '',
  `yahoo` char(90) NOT NULL DEFAULT '',
  `gtalk` char(90) NOT NULL DEFAULT '',
  `wangwang` char(90) NOT NULL DEFAULT '',
  `site` varchar(100) NOT NULL,
  `mobile` char(11) NOT NULL DEFAULT '',
  `phone` char(20) NOT NULL DEFAULT '',
  `company` varchar(255) NOT NULL,
  `address` char(120) NOT NULL DEFAULT '',
  `zipcode` char(10) NOT NULL DEFAULT '',
  `visits` mediumint(8) UNSIGNED NOT NULL DEFAULT '0',
  `ip` char(40) NOT NULL DEFAULT '',
  `last` datetime NOT NULL,
  `score` mediumint(9) NOT NULL,
  `rank` mediumint(9) NOT NULL,
  `maxLogin` tinyint(4) NOT NULL DEFAULT '10',
  `fails` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `referer` varchar(255) NOT NULL,
  `join` datetime NOT NULL,
  `reset` char(64) NOT NULL,
  `locked` datetime NOT NULL,
  `public` varchar(30) NOT NULL DEFAULT '0',
  `emailCertified` enum('0','1') NOT NULL DEFAULT '0',
  `security` text,
  `notification` varchar(20) NOT NULL DEFAULT '',
  `os` char(30) NOT NULL,
  `browser` varchar(100) NOT NULL,
  `lang` char(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `eps_user`
--

INSERT INTO `eps_user` (`id`, `account`, `password`, `realname`, `realnames`, `nickname`, `admin`, `avatar`, `birthday`, `gender`, `email`, `skype`, `qq`, `yahoo`, `gtalk`, `wangwang`, `site`, `mobile`, `phone`, `company`, `address`, `zipcode`, `visits`, `ip`, `last`, `score`, `rank`, `maxLogin`, `fails`, `referer`, `join`, `reset`, `locked`, `public`, `emailCertified`, `security`, `notification`, `os`, `browser`, `lang`) VALUES
(1, 'admin', '77fada96dff3ec453737264e3dc5fe9e', 'admin', '', '', 'super', '', '0000-00-00', 'u', '', '', '', '', '', '', '', '', '', '', '', '', 0, '', '0000-00-00 00:00:00', 0, 0, 10, 0, '', '2021-06-21 20:48:31', '', '0000-00-00 00:00:00', '0', '0', NULL, '', '', '', 'zh-cn'),
(2, 'demo', '629313c380e0defefbd6267651c72a9d', 'demo', '', '', 'super', '', '0000-00-00', 'u', '', '', '', '', '', '', '', '', '', '', '', '', 0, '14.159.71.121', '0000-00-00 00:00:00', 0, 0, 10, 0, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', '0', '0', NULL, '', '', '', 'zh-cn');

-- --------------------------------------------------------

--
-- 表的结构 `eps_usergroup`
--

CREATE TABLE `eps_usergroup` (
  `account` char(30) NOT NULL DEFAULT '',
  `group` mediumint(8) UNSIGNED NOT NULL DEFAULT '0',
  `lang` char(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `eps_widget`
--

CREATE TABLE `eps_widget` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `account` char(30) NOT NULL,
  `type` char(20) NOT NULL,
  `title` varchar(100) NOT NULL,
  `params` text NOT NULL,
  `order` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `grid` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `hidden` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `lang` char(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `eps_widget`
--

INSERT INTO `eps_widget` (`id`, `account`, `type`, `title`, `params`, `order`, `grid`, `hidden`, `lang`) VALUES
(1, 'admin', 'latestOrder', '最新订单', '', 1, 4, 0, 'zh-cn'),
(2, 'admin', 'latestThread', '最新帖子', '', 2, 4, 0, 'zh-cn'),
(3, 'admin', 'message', '反馈', '', 3, 4, 0, 'zh-cn'),
(4, 'admin', 'submission', '最新投稿', '', 4, 4, 0, 'zh-cn'),
(5, 'admin', 'commonMenu', '快捷入口', '', 5, 4, 0, 'zh-cn'),
(6, 'admin', 'chanzhiDynamic', '蝉知动态', '', 6, 4, 0, 'zh-cn');

-- --------------------------------------------------------

--
-- 表的结构 `eps_wx_message`
--

CREATE TABLE `eps_wx_message` (
  `id` mediumint(10) UNSIGNED NOT NULL,
  `public` smallint(3) NOT NULL,
  `wid` char(64) NOT NULL,
  `to` varchar(50) NOT NULL,
  `from` varchar(50) NOT NULL,
  `response` mediumint(8) UNSIGNED NOT NULL,
  `content` text NOT NULL,
  `type` char(30) NOT NULL,
  `replied` tinyint(3) NOT NULL DEFAULT '0',
  `time` datetime NOT NULL,
  `lang` char(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `eps_wx_public`
--

CREATE TABLE `eps_wx_public` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `account` varchar(30) NOT NULL,
  `name` varchar(60) NOT NULL,
  `appID` char(30) NOT NULL,
  `appSecret` char(32) NOT NULL,
  `url` varchar(100) NOT NULL,
  `token` varchar(100) NOT NULL,
  `qrcode` varchar(100) NOT NULL,
  `primary` tinyint(3) NOT NULL DEFAULT '0',
  `type` enum('subscribe','service') NOT NULL,
  `status` enum('wait','normal') NOT NULL,
  `certified` enum('1','0') NOT NULL DEFAULT '0',
  `addedDate` datetime NOT NULL,
  `remindUsers` text NOT NULL,
  `lang` char(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `eps_wx_response`
--

CREATE TABLE `eps_wx_response` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `public` smallint(3) NOT NULL,
  `key` varchar(100) NOT NULL,
  `group` varchar(100) NOT NULL,
  `type` enum('text','news','link') NOT NULL DEFAULT 'text',
  `source` varchar(100) NOT NULL,
  `content` text NOT NULL,
  `lang` char(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转储表的索引
--

--
-- 表的索引 `eps_action`
--
ALTER TABLE `eps_action`
  ADD PRIMARY KEY (`id`),
  ADD KEY `objectType` (`objectType`);

--
-- 表的索引 `eps_address`
--
ALTER TABLE `eps_address`
  ADD PRIMARY KEY (`id`),
  ADD KEY `account` (`account`),
  ADD KEY `lang` (`lang`);

--
-- 表的索引 `eps_article`
--
ALTER TABLE `eps_article`
  ADD PRIMARY KEY (`id`),
  ADD KEY `type` (`type`),
  ADD KEY `lang` (`lang`),
  ADD KEY `order` (`order`),
  ADD KEY `views` (`views`),
  ADD KEY `sticky` (`sticky`),
  ADD KEY `status` (`status`),
  ADD KEY `addedDate` (`addedDate`);

--
-- 表的索引 `eps_bearlog`
--
ALTER TABLE `eps_bearlog`
  ADD PRIMARY KEY (`id`),
  ADD KEY `account` (`account`),
  ADD KEY `lang` (`lang`),
  ADD KEY `objectType` (`objectType`),
  ADD KEY `objectID` (`objectID`),
  ADD KEY `time` (`time`),
  ADD KEY `type` (`type`);

--
-- 表的索引 `eps_blacklist`
--
ALTER TABLE `eps_blacklist`
  ADD UNIQUE KEY `identity` (`type`,`identity`,`lang`),
  ADD KEY `expiredDate` (`expiredDate`),
  ADD KEY `addedDate` (`addedDate`),
  ADD KEY `lang` (`lang`);

--
-- 表的索引 `eps_block`
--
ALTER TABLE `eps_block`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lang` (`lang`),
  ADD KEY `type` (`type`),
  ADD KEY `template` (`template`);

--
-- 表的索引 `eps_book`
--
ALTER TABLE `eps_book`
  ADD PRIMARY KEY (`id`),
  ADD KEY `type` (`type`),
  ADD KEY `lang` (`lang`),
  ADD KEY `order` (`order`),
  ADD KEY `parent` (`parent`),
  ADD KEY `status` (`status`),
  ADD KEY `addedDate` (`addedDate`),
  ADD KEY `path` (`path`);

--
-- 表的索引 `eps_cart`
--
ALTER TABLE `eps_cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `account` (`account`),
  ADD KEY `product` (`product`),
  ADD KEY `lang` (`lang`);

--
-- 表的索引 `eps_category`
--
ALTER TABLE `eps_category`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lang` (`lang`),
  ADD KEY `tree` (`type`),
  ADD KEY `order` (`order`),
  ADD KEY `parent` (`parent`),
  ADD KEY `path` (`path`),
  ADD KEY `grade` (`grade`);

--
-- 表的索引 `eps_config`
--
ALTER TABLE `eps_config`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique` (`owner`,`module`,`section`,`key`,`lang`),
  ADD KEY `lang` (`lang`);

--
-- 表的索引 `eps_down`
--
ALTER TABLE `eps_down`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lang` (`lang`),
  ADD KEY `fileID` (`file`);

--
-- 表的索引 `eps_file`
--
ALTER TABLE `eps_file`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lang` (`lang`),
  ADD KEY `pathname` (`pathname`),
  ADD KEY `object` (`objectType`,`objectID`),
  ADD KEY `extension` (`extension`);

--
-- 表的索引 `eps_group`
--
ALTER TABLE `eps_group`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lang` (`lang`);

--
-- 表的索引 `eps_grouppriv`
--
ALTER TABLE `eps_grouppriv`
  ADD UNIQUE KEY `group` (`group`,`module`,`method`);

--
-- 表的索引 `eps_history`
--
ALTER TABLE `eps_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `action` (`action`);

--
-- 表的索引 `eps_layout`
--
ALTER TABLE `eps_layout`
  ADD UNIQUE KEY `layout` (`template`,`theme`,`page`,`region`,`object`,`lang`);

--
-- 表的索引 `eps_log`
--
ALTER TABLE `eps_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ip` (`ip`),
  ADD KEY `lang` (`lang`),
  ADD KEY `type` (`type`),
  ADD KEY `account` (`account`),
  ADD KEY `date` (`date`);

--
-- 表的索引 `eps_message`
--
ALTER TABLE `eps_message`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lang` (`lang`),
  ADD KEY `status` (`status`),
  ADD KEY `type` (`type`),
  ADD KEY `to` (`to`),
  ADD KEY `account` (`account`),
  ADD KEY `readed` (`readed`),
  ADD KEY `object` (`objectType`,`objectID`);

--
-- 表的索引 `eps_oauth`
--
ALTER TABLE `eps_oauth`
  ADD UNIQUE KEY `account` (`account`,`provider`,`openID`),
  ADD KEY `lang` (`lang`);

--
-- 表的索引 `eps_operationlog`
--
ALTER TABLE `eps_operationlog`
  ADD PRIMARY KEY (`id`),
  ADD KEY `operation` (`type`,`identity`,`operation`,`createdTime`),
  ADD KEY `lang` (`lang`);

--
-- 表的索引 `eps_order`
--
ALTER TABLE `eps_order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `account` (`account`),
  ADD KEY `status` (`status`),
  ADD KEY `createdDate` (`createdDate`),
  ADD KEY `deliveriedDate` (`deliveriedDate`),
  ADD KEY `deliveryStatus` (`deliveryStatus`),
  ADD KEY `payStatus` (`payStatus`),
  ADD KEY `type` (`type`),
  ADD KEY `lang` (`lang`);

--
-- 表的索引 `eps_order_product`
--
ALTER TABLE `eps_order_product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orderID` (`orderID`),
  ADD KEY `productID` (`productID`),
  ADD KEY `lang` (`lang`);

--
-- 表的索引 `eps_package`
--
ALTER TABLE `eps_package`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`),
  ADD KEY `lang` (`lang`),
  ADD KEY `type` (`type`),
  ADD KEY `addedTime` (`installedTime`);

--
-- 表的索引 `eps_product`
--
ALTER TABLE `eps_product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lang` (`lang`),
  ADD KEY `order` (`order`),
  ADD KEY `views` (`views`),
  ADD KEY `sticky` (`sticky`),
  ADD KEY `status` (`status`),
  ADD KEY `model` (`model`);

--
-- 表的索引 `eps_product_custom`
--
ALTER TABLE `eps_product_custom`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `label` (`product`,`label`),
  ADD KEY `lang` (`lang`),
  ADD KEY `product` (`product`);

--
-- 表的索引 `eps_relation`
--
ALTER TABLE `eps_relation`
  ADD UNIQUE KEY `relation` (`type`,`id`,`category`),
  ADD KEY `lang` (`lang`),
  ADD KEY `id` (`id`),
  ADD KEY `category` (`category`);

--
-- 表的索引 `eps_reply`
--
ALTER TABLE `eps_reply`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lang` (`lang`),
  ADD KEY `thread` (`thread`),
  ADD KEY `reply` (`reply`),
  ADD KEY `hidden` (`hidden`),
  ADD KEY `editedDate` (`editedDate`),
  ADD KEY `author` (`author`);

--
-- 表的索引 `eps_score`
--
ALTER TABLE `eps_score`
  ADD PRIMARY KEY (`id`),
  ADD KEY `account` (`account`),
  ADD KEY `method` (`method`),
  ADD KEY `lang` (`lang`),
  ADD KEY `objectType` (`objectType`),
  ADD KEY `objectID` (`objectID`),
  ADD KEY `time` (`time`),
  ADD KEY `type` (`type`);

--
-- 表的索引 `eps_search_dict`
--
ALTER TABLE `eps_search_dict`
  ADD PRIMARY KEY (`key`),
  ADD KEY `lang` (`lang`);

--
-- 表的索引 `eps_search_index`
--
ALTER TABLE `eps_search_index`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `object` (`objectType`,`objectID`),
  ADD KEY `lang` (`lang`),
  ADD KEY `addedDate` (`addedDate`);
ALTER TABLE `eps_search_index` ADD FULLTEXT KEY `content` (`title`,`content`);

--
-- 表的索引 `eps_slide`
--
ALTER TABLE `eps_slide`
  ADD PRIMARY KEY (`id`),
  ADD KEY `group` (`group`);

--
-- 表的索引 `eps_statlog`
--
ALTER TABLE `eps_statlog`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ip` (`ip`),
  ADD KEY `referer` (`referer`),
  ADD KEY `searchEngine` (`searchEngine`),
  ADD KEY `keywords` (`keywords`),
  ADD KEY `time` (`year`,`month`,`day`,`hour`),
  ADD KEY `location` (`country`,`province`,`city`),
  ADD KEY `mobile` (`mobile`),
  ADD KEY `lang` (`lang`),
  ADD KEY `month_lang` (`month`,`lang`),
  ADD KEY `day_lang` (`day`,`lang`),
  ADD KEY `hour_lang` (`hour`,`lang`),
  ADD KEY `osName` (`osName`),
  ADD KEY `browserName` (`browserName`),
  ADD KEY `year` (`year`);

--
-- 表的索引 `eps_statreferer`
--
ALTER TABLE `eps_statreferer`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `url` (`url`(255)),
  ADD KEY `lang` (`lang`);

--
-- 表的索引 `eps_statregion`
--
ALTER TABLE `eps_statregion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `region` (`country`,`province`,`city`),
  ADD KEY `time` (`timeType`,`timeValue`),
  ADD KEY `lang` (`lang`);

--
-- 表的索引 `eps_statreport`
--
ALTER TABLE `eps_statreport`
  ADD PRIMARY KEY (`id`),
  ADD KEY `time` (`timeType`,`timeValue`),
  ADD KEY `type` (`type`,`item`),
  ADD KEY `lang` (`lang`);

--
-- 表的索引 `eps_statvisitor`
--
ALTER TABLE `eps_statvisitor`
  ADD PRIMARY KEY (`id`),
  ADD KEY `osName` (`osName`),
  ADD KEY `browsername` (`browserName`),
  ADD KEY `device` (`device`),
  ADD KEY `lang` (`lang`);

--
-- 表的索引 `eps_tag`
--
ALTER TABLE `eps_tag`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lang` (`lang`),
  ADD KEY `tag` (`tag`),
  ADD KEY `rank` (`rank`),
  ADD KEY `link` (`link`);

--
-- 表的索引 `eps_thread`
--
ALTER TABLE `eps_thread`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lang` (`lang`),
  ADD KEY `category` (`board`),
  ADD KEY `hidden` (`hidden`),
  ADD KEY `status` (`status`),
  ADD KEY `addedDate` (`addedDate`),
  ADD KEY `stick` (`stick`);

--
-- 表的索引 `eps_user`
--
ALTER TABLE `eps_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lang` (`lang`),
  ADD KEY `admin` (`admin`),
  ADD KEY `score` (`score`),
  ADD KEY `rank` (`rank`),
  ADD KEY `account` (`account`,`password`);

--
-- 表的索引 `eps_usergroup`
--
ALTER TABLE `eps_usergroup`
  ADD UNIQUE KEY `account` (`account`,`group`),
  ADD KEY `lang` (`lang`);

--
-- 表的索引 `eps_widget`
--
ALTER TABLE `eps_widget`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `accountAppOrder` (`account`,`order`),
  ADD KEY `lang` (`lang`),
  ADD KEY `hidden` (`hidden`);

--
-- 表的索引 `eps_wx_message`
--
ALTER TABLE `eps_wx_message`
  ADD PRIMARY KEY (`id`),
  ADD KEY `type` (`type`),
  ADD KEY `public` (`public`),
  ADD KEY `from` (`from`),
  ADD KEY `to` (`to`),
  ADD KEY `replied` (`replied`),
  ADD KEY `lang` (`lang`);

--
-- 表的索引 `eps_wx_public`
--
ALTER TABLE `eps_wx_public`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lang` (`lang`);

--
-- 表的索引 `eps_wx_response`
--
ALTER TABLE `eps_wx_response`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `key` (`public`,`key`,`lang`),
  ADD KEY `lang` (`lang`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `eps_action`
--
ALTER TABLE `eps_action`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `eps_address`
--
ALTER TABLE `eps_address`
  MODIFY `id` mediumint(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用表AUTO_INCREMENT `eps_article`
--
ALTER TABLE `eps_article`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- 使用表AUTO_INCREMENT `eps_bearlog`
--
ALTER TABLE `eps_bearlog`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `eps_block`
--
ALTER TABLE `eps_block`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=235;

--
-- 使用表AUTO_INCREMENT `eps_book`
--
ALTER TABLE `eps_book`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 使用表AUTO_INCREMENT `eps_cart`
--
ALTER TABLE `eps_cart`
  MODIFY `id` mediumint(9) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `eps_category`
--
ALTER TABLE `eps_category`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- 使用表AUTO_INCREMENT `eps_config`
--
ALTER TABLE `eps_config`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=494;

--
-- 使用表AUTO_INCREMENT `eps_down`
--
ALTER TABLE `eps_down`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `eps_file`
--
ALTER TABLE `eps_file`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `eps_group`
--
ALTER TABLE `eps_group`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- 使用表AUTO_INCREMENT `eps_history`
--
ALTER TABLE `eps_history`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `eps_log`
--
ALTER TABLE `eps_log`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `eps_message`
--
ALTER TABLE `eps_message`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `eps_operationlog`
--
ALTER TABLE `eps_operationlog`
  MODIFY `id` mediumint(8) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `eps_order`
--
ALTER TABLE `eps_order`
  MODIFY `id` mediumint(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 使用表AUTO_INCREMENT `eps_order_product`
--
ALTER TABLE `eps_order_product`
  MODIFY `id` mediumint(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 使用表AUTO_INCREMENT `eps_package`
--
ALTER TABLE `eps_package`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `eps_product`
--
ALTER TABLE `eps_product`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 使用表AUTO_INCREMENT `eps_product_custom`
--
ALTER TABLE `eps_product_custom`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- 使用表AUTO_INCREMENT `eps_reply`
--
ALTER TABLE `eps_reply`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `eps_score`
--
ALTER TABLE `eps_score`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `eps_search_index`
--
ALTER TABLE `eps_search_index`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `eps_slide`
--
ALTER TABLE `eps_slide`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- 使用表AUTO_INCREMENT `eps_statlog`
--
ALTER TABLE `eps_statlog`
  MODIFY `id` int(9) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `eps_statreferer`
--
ALTER TABLE `eps_statreferer`
  MODIFY `id` int(9) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `eps_statregion`
--
ALTER TABLE `eps_statregion`
  MODIFY `id` int(9) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `eps_statreport`
--
ALTER TABLE `eps_statreport`
  MODIFY `id` int(9) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `eps_statvisitor`
--
ALTER TABLE `eps_statvisitor`
  MODIFY `id` int(9) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `eps_tag`
--
ALTER TABLE `eps_tag`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- 使用表AUTO_INCREMENT `eps_thread`
--
ALTER TABLE `eps_thread`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用表AUTO_INCREMENT `eps_user`
--
ALTER TABLE `eps_user`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 使用表AUTO_INCREMENT `eps_widget`
--
ALTER TABLE `eps_widget`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- 使用表AUTO_INCREMENT `eps_wx_message`
--
ALTER TABLE `eps_wx_message`
  MODIFY `id` mediumint(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `eps_wx_public`
--
ALTER TABLE `eps_wx_public`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `eps_wx_response`
--
ALTER TABLE `eps_wx_response`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
