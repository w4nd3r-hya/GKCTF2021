<?php if(!defined("RUN_MODE")) die();?>
<?php
/**
 * The article category zh-cn file of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV1.2 (http://zpl.pub/page/zplv12.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     article
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
$lang->article->common      = 'Article';
$lang->article->setting     = 'Basic Settings';
$lang->article->createDraft = 'Save the draft';
$lang->article->post        = 'Submit';
$lang->article->check       = 'Review';
$lang->article->reject      = 'Reject';

$lang->article->id         = 'ID';
$lang->article->category   = 'Category';
$lang->article->categories = 'Category';
$lang->article->title      = 'Title';
$lang->article->alias      = 'Alias';
$lang->article->content    = 'Text';
$lang->article->source     = 'Source';
$lang->article->copySite   = 'Site';
$lang->article->copyURL    = 'URL';
$lang->article->keywords   = 'Tags';
$lang->article->summary    = 'Summary';
$lang->article->author     = 'Author';
$lang->article->editor     = 'Edit';
$lang->article->addedDate  = 'Publish On';
$lang->article->editedDate = 'Edit On';
$lang->article->status     = 'Status';
$lang->article->type       = 'Type';
$lang->article->views      = 'View';
$lang->article->comments   = 'Comment';
$lang->article->stick      = 'Sticky';
$lang->article->order      = 'Ranking';
$lang->article->isLink     = 'Link';
$lang->article->link       = 'Link';
$lang->article->css        = 'CSS';
$lang->article->js         = 'JS';
$lang->article->layout     = 'Layout';

$lang->article->forward2Blog     = 'To Blog';
$lang->article->forward2Forum    = 'To Forum';
$lang->article->forward2Baidu    = 'To Baidu';
$lang->article->selectCategories = 'Select Category';
$lang->article->selectBoard      = 'Select Board';
$lang->article->confirmReject    = 'Do you want to reject it?';

$lang->submission= new stdclass();
$lang->submission->common  = 'Submit';
$lang->submission->check   = 'Review';
$lang->submission->list    = 'Submission';
$lang->submission->publish = 'Pass';
$lang->submission->reject  = 'Reject';

$lang->submission->status[0] = '';
$lang->submission->status[1] = '<span class="label label-xsm label-primary">' . 'Pending' .'</span>';
$lang->submission->status[2] = '<span class="label label-xsm label-success">' . 'Pass' . '</span>';
$lang->submission->status[3] = 'Reject';

$lang->submission->typeList = array();
$lang->submission->typeList['article'] = 'Article';
$lang->submission->typeList['blog']    = 'Blog';
$lang->submission->typeList['book']    = 'Book';

$lang->article->onlyBody = 'Display body only (for custom).';

$lang->article->list          = 'List';
$lang->article->admin         = 'Manage';
$lang->article->create        = 'Add Article';
$lang->article->setcss        = 'CSS Settings';
$lang->article->setjs         = 'JS Settings';
$lang->article->edit          = 'Edit';
$lang->article->files         = 'File';
$lang->article->images        = 'Image';

$lang->article->submission     = 'Submit';
$lang->article->submissionTime = 'Submit On';
$lang->article->noSubmission   = 'You have no submissions yet. Submit and earn points!';

$lang->article->orderBy = new stdclass();
$lang->article->orderBy->time = 'Time';
$lang->article->orderBy->hot  = 'Hot';

$lang->article->submissionOptions = new stdclass;
$lang->article->submissionOptions->open  = 'On';
$lang->article->submissionOptions->close = 'Off';

$lang->blog->common = 'Blog';
$lang->blog->admin  = 'Manage';
$lang->blog->list   = 'List';
$lang->blog->create = 'Add Blog';
$lang->blog->edit   = 'Edit';

$lang->page->common = 'Page';
$lang->page->admin  = 'Manage`';
$lang->page->list   = 'List';
$lang->page->create = 'Add Page';
$lang->page->edit   = 'Edit';

$lang->article->sourceList['original']      = 'Original';
$lang->article->sourceList['copied']        = 'Copied';
$lang->article->sourceList['translational'] = 'Translated';
$lang->article->sourceList['article']       = 'Repost';

$lang->article->statusList['normal'] = 'Normal';
$lang->article->statusList['draft']  = 'Draft';

$lang->article->sticks[0] = 'No Sticky';
$lang->article->sticks[1] = 'Categorical';
$lang->article->sticks[2] = 'Global';

$lang->article->stickTime      = 'Top End Time';
$lang->article->stickBold      = 'Title Bold';
$lang->article->successStick   = 'Sticky!';
$lang->article->successUnstick = 'Sticky cancelled!';

$lang->article->confirmDelete = 'Do you want to delete this article?';
$lang->article->categoryEmpty = 'Choose Category';

$lang->article->lblAddedDate = '<strong>Added on </strong> %s &nbsp;&nbsp;';
$lang->article->lblAuthor    = "<strong>Author </strong> %s &nbsp;&nbsp;";
$lang->article->lblSource    = '<strong>Source </strong>';
$lang->article->lblViews     = '<strong>Viewed </strong> %s';
$lang->article->lblEditor    = 'Last edited by %s on %s';
$lang->article->lblComments  = '<strong>Commented by </strong> %s';

$lang->article->none      = 'The End';
$lang->article->previous  = 'Previous';
$lang->article->next      = 'Next';
$lang->article->directory = 'Back';
$lang->article->noCssTag  = 'No &lt;style&gt;&lt;/style&gt; tag';
$lang->article->noJsTag   = 'No &lt;script&gt;&lt;/script&gt;tag';

$lang->article->placeholder = new stdclass();
$lang->article->placeholder->addedDate = 'Select a date to publish.';
$lang->article->placeholder->link      = 'Enter the link here. External link is OK.';

$lang->article->approveMessage = 'Your submission <strong>%s</strong> has passed the review. You have earned <strong>+%s</strong> points. Thank you!';
$lang->article->rejectMessage  = 'Your submission <strong>%s</strong> did not pass the review. You can edit it and submit for review again. Thank you!';

$lang->article->forwardFrom = 'Repost from';

$lang->article->noCategoriesTip = 'You have not added the categories, please add the categories at first';

$lang->article->noCategories = array();
$lang->article->noCategories['article'] = 'You have not added the categories for article. Please add the categories at first.';
$lang->article->noCategories['blog']    = 'You have not added the categories for blog. Please add the categories at first.';
$lang->article->noCategories['video']   = 'You have not added the categories for video. Please add the categories at first.';

$lang->article->blog = new stdclass();
$lang->article->blog->category                   = 'Category';
$lang->article->blog->categoryLevel              = 'Level';
$lang->article->blog->categoryNameList['abbr']   = 'Abbr';
$lang->article->blog->categoryNameList['full']   = 'Full';
$lang->article->blog->categoryLevelList['first'] = 'Root';
$lang->article->blog->categoryLevelList['final'] = 'Final';

$lang->article->blog->categoryOptions['1'] = 'Show';
$lang->article->blog->categoryOptions['0'] = 'Hide';

$lang->article->browseImage = new stdclass();
$lang->article->browseImage->common   = 'Image on browse page';
$lang->article->browseImage->maxWidth = 'max width';

$lang->article->browseImage->positionList['left']  = 'Left';
$lang->article->browseImage->positionList['right'] = 'Right';

$lang->article->browseImage->sizeList['small']  = 'Small';
$lang->article->browseImage->sizeList['middle'] = 'Middle';