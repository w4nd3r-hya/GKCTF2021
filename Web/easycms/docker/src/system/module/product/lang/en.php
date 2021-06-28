<?php if(!defined("RUN_MODE")) die();?>
<?php
/**
 * The product category zh-cn file of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV1.2 (http://zpl.pub/page/zplv12.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     product
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
$lang->product->common = 'Product';
$lang->product->home   = 'Product';

$lang->product->id         = 'ID';
$lang->product->category   = 'Category';
$lang->product->categories = 'Category';
$lang->product->name       = 'Title';
$lang->product->alias      = 'Alias';
$lang->product->mall       = 'Link';
$lang->product->buyNow     = 'Buy Now';
$lang->product->brand      = 'Brand';
$lang->product->model      = 'Model';
$lang->product->color      = 'Color';
$lang->product->origin     = 'Origin';
$lang->product->unit       = 'Unit';
$lang->product->price      = 'Price';
$lang->product->promotion  = 'On Sale';
$lang->product->amount     = 'Quantity';
$lang->product->keywords   = 'Tags';
$lang->product->desc       = 'Introduction';
$lang->product->content    = 'Details';
$lang->product->author     = 'Author';
$lang->product->editor     = 'Edit';
$lang->product->addedDate  = 'Added On';
$lang->product->editedDate = 'Edited On';
$lang->product->status     = 'Status';
$lang->product->views      = 'View';
$lang->product->viewsCount = 'View Quantity';
$lang->product->stick      = 'Sticky';
$lang->product->order      = 'ID';
$lang->product->unsaleable = 'Not for sale';
$lang->product->attribute  = 'More';
$lang->product->custom     = 'Tags';
$lang->product->sales      = 'Price';
$lang->product->css        = 'CSS';
$lang->product->js         = 'JS';

$lang->product->currency  = 'Currency';
$lang->product->stock     = 'Inventory';
$lang->product->negotiate = 'Negotiate';

$lang->product->list         = 'Product';
$lang->product->view         = 'View';
$lang->product->hot          = 'Hot';
$lang->product->admin        = 'Manage';
$lang->product->create       = 'Add';
$lang->product->edit         = 'Edit';
$lang->product->changeStatus = 'Status';
$lang->product->setcss       = 'CSS Settings';
$lang->product->setjs        = 'JS Settings';
$lang->product->files        = 'File';
$lang->product->images       = 'Image';
$lang->product->addToCart    = 'Add to Cart';
$lang->product->count         = 'Count';
$lang->product->comments      = 'Comment';
$lang->product->detail        = 'Details';
$lang->product->setting       = 'Settings';
$lang->product->soldout       = 'Out of Stock!';
$lang->product->layout        = 'Layout';
$lang->product->contact       = 'Contact';
$lang->product->forward2Baidu = 'Submit to Baidu';

$lang->product->orderBy = new stdclass();
$lang->product->orderBy->time = 'Time';
$lang->product->orderBy->hot  = 'Hot';

$lang->product->congratulations  = "Congrats!";
$lang->product->addToCartSuccess = "Added to your shopping cart!";
$lang->product->gotoCart         = "Check Out";
$lang->product->goback           = "Back";

$lang->product->confirmDelete = 'Do you want to delete it?';

$lang->product->prev      = 'Previous';
$lang->product->next      = 'Next';
$lang->product->none      = 'The End';
$lang->product->directory = 'Back';
$lang->product->noCssTag  = 'No &lt;style&gt;&lt;/style&gt; Tag';
$lang->product->noJsTag   = 'No &lt;script&gt;&lt;/script&gt; Tag';

$lang->product->statusList['normal']  = 'for Sale';
$lang->product->statusList['offline'] = 'Off Shelf';

$lang->product->placeholder = new stdclass();
$lang->product->placeholder->label    = "Tag Name, such as color,";
$lang->product->placeholder->value    = "Tag Value, such as red.";
$lang->product->placeholder->currency = "Please enter currency symbol, such as ￥";

$lang->product->listMode = new stdclass();
$lang->product->listMode->card  = "<i class='icon icon-th-large'></i>";
$lang->product->listMode->list  = "<i class='icon icon-list-ul'></i>";

$lang->product->currencyList['rmb']  = 'RMB';
$lang->product->currencyList['usd']  = 'USD';
$lang->product->currencyList['hkd']  = 'HKD';
$lang->product->currencyList['twd']  = 'TWD';
$lang->product->currencyList['euro'] = 'EURO';
$lang->product->currencyList['dem']  = 'DEM';
$lang->product->currencyList['chf']  = 'CHF';
$lang->product->currencyList['frf']  = 'FRF';
$lang->product->currencyList['gbp']  = 'GBP';
$lang->product->currencyList['nlg']  = 'NLG';
$lang->product->currencyList['cad']  = 'CAD';
$lang->product->currencyList['sur']  = 'SUR';
$lang->product->currencyList['inr']  = 'INR';
$lang->product->currencyList['aud']  = 'AUD';
$lang->product->currencyList['nzd']  = 'NZD';
$lang->product->currencyList['thb']  = 'THB';
$lang->product->currencyList['sgd']  = 'SGD';

/* Currency symbols setting. */
$lang->product->currencySymbols['rmb']  = '￥';
$lang->product->currencySymbols['usd']  = '$';
$lang->product->currencySymbols['hkd']  = 'HK$';
$lang->product->currencySymbols['twd']  = 'NT$';
$lang->product->currencySymbols['euro'] = 'ECU';
$lang->product->currencySymbols['dem']  = 'DM';
$lang->product->currencySymbols['chf']  = 'SF';
$lang->product->currencySymbols['frf']  = 'FF';
$lang->product->currencySymbols['gbp']  = '￡';
$lang->product->currencySymbols['nlg']  = 'F';
$lang->product->currencySymbols['cad']  = 'CAN$';
$lang->product->currencySymbols['sur']  = 'Rbs';
$lang->product->currencySymbols['inr']  = 'Rs';
$lang->product->currencySymbols['aud']  = 'A$';
$lang->product->currencySymbols['nzd']  = 'NZ$';
$lang->product->currencySymbols['thb']  = 'B';
$lang->product->currencySymbols['sgd']  = 'S$';

$lang->product->browseOptions = array();
$lang->product->browseOptions['card'] = 'Card Mode';
$lang->product->browseOptions['list'] = 'List Mode';

$lang->product->stockOptions = array();
$lang->product->stockOptions[0] = 'Off';
$lang->product->stockOptions[1] = 'On';

$lang->product->h5api = array();
$lang->product->h5api['close'] = 'Off';
$lang->product->h5api['open']  = 'On';

$lang->product->viewsOptions = array();
$lang->product->viewsOptions[1] = 'Show';
$lang->product->viewsOptions[0] = 'Hide';

$lang->product->priceOptions = array();
$lang->product->priceOptions[1] = 'Show';
$lang->product->priceOptions[0] = 'Hide';

$lang->product->namePositionOptions = array();
$lang->product->namePositionOptions['left']   = 'Left';
$lang->product->namePositionOptions['center'] = 'Center';

$lang->product->noCategoriesTip = 'You have not added any categories. Please add a category at first.';
