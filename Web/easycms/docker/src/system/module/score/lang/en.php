<?php if(!defined("RUN_MODE")) die();?>
<?php
/**
 * The action module English file of ZenTaoCMS.
 *
 * @copyright   Copyright 2009-2010 QingDao Nature Easy Soft Network Technology Co,LTD (www.cnezsoft.com)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     action
 * @version     $Id$
 * @link        http://www.chanzhi.net
 */
$lang->score->back        = 'Back';
$lang->score->rankingList = 'Ranking';
$lang->score->rule        = 'Rules';
$lang->score->statement   = 'Point Statement';
$lang->score->stateDesc   = 'Point Statement is generated per user and based on the total points acquired in last month.';

$lang->score->common  = 'Score';
$lang->score->id      = 'ID';
$lang->score->account = 'Account';
$lang->score->method  = 'How';
$lang->score->type    = 'Type';
$lang->score->count   = 'Points';
$lang->score->before  = 'Before';
$lang->score->after   = 'After';
$lang->score->amount  = 'Price';
$lang->score->note    = 'Note';
$lang->score->time    = 'Date';
$lang->score->product = 'Product';
$lang->score->confirm = 'Confirm Order';
$lang->score->details = 'Point Details';

$lang->score->setCounts = 'Rules';

$lang->score->totalRank = 'Overall Ranking';
$lang->score->rank      = 'Ranking';
$lang->score->username  = 'User Name';
$lang->score->monthRank = 'Monthly Ranking';
$lang->score->weekRank  = 'Weekly Ranking';
$lang->score->dayRank   = 'Daily Ranking';

$lang->score->methods['register'] = 'Register';
$lang->score->methods['login']    = 'Login';
$lang->score->methods['maxLogin'] = 'Max Login Points';
$lang->score->methods['download'] = 'Download';

$lang->score->methods['thread']      = 'Post';
$lang->score->methods['reply']       = 'Reply';
$lang->score->methods['valuethread'] = 'Post Thread';
$lang->score->methods['valuereply']  = 'Post Reply';
$lang->score->methods['delThread']   = 'Delete Thread';
$lang->score->methods['delReply']    = 'Delete Reply';
$lang->score->methods['award']       = 'Reward';
$lang->score->methods['punish']      = 'Deduct';

$lang->score->methods['approvesubmission'] = 'Submitted';

$lang->score->methods['buyscore']  = 'Purchase';
$lang->score->methods['statement'] = 'Point Statement';

$lang->score->methods['vip'] = 'VIP';
$lang->score->methods['co']  = 'Partner';

$lang->score->types['in']    = 'increase';
$lang->score->types['out']   = 'decrease';

$lang->score->getByThread = 'Post threads to get points.'; 
$lang->score->getByReply  = 'Reply to get points.'; 

$lang->score->lblTotal         = "You have %s points to use. Your points for ranking is %s. ";
$lang->score->lblNoScore       = "Sorry, your points is insufficient.";
$lang->score->lblNoScoreReason = "Sorry, your points is less than %s. You need <strong class='red'>%s</strong> Points. You have <strong class='red'>%s</strong> Points.";
$lang->score->lblDetail        = "Please refer to <a href='http://www.zentao.net/thread-view-79915.html' target='_blank'>《如何获得积分》</a><br /><br />";
$lang->score->lblBuySocre      = "Purchase Points %s";
$lang->score->lblStateSuccess  = 'Point statement is generated.';

$lang->score->setAmount   = 'Refill Amount';
$lang->score->getScore    = 'Refill Points';
$lang->score->amountUnit  = 'Dollar';
$lang->score->minAmount   = 'Minimum refill';
$lang->score->buyWaring   = " Minimum refill is %s dollar，1 dollar=%s Points";
$lang->score->errorAmount = "Refill amount should be more than %s Dollars.";
$lang->score->alipay      = "Use PayPal right now!";
$lang->score->paySuccess  = 'Thank you for your payment!';
$lang->score->payFail     = 'Sorry, there is something wrong with your payment. Contact us if any questions.';
$lang->score->viewHistory = 'Payment History';

$lang->score->awardRule  = 'Reward Rules';
$lang->score->punishRule = 'Deduction Rules';
