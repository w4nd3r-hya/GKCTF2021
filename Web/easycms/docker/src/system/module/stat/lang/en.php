<?php if(!defined("RUN_MODE")) die();?>
<?php
$lang->stat->common        = 'Statistics';
$lang->stat->setting       = 'Settings';
$lang->stat->view          = 'View';
$lang->stat->traffic       = 'Traffic Summary';
$lang->stat->report        = 'Report';
$lang->stat->client        = 'Client';
$lang->stat->device        = 'Client Type';
$lang->stat->os            = 'Operating System';
$lang->stat->browser       = 'Browser';
$lang->stat->from          = 'Source Stats';
$lang->stat->keywords      = 'Tag Stats';
$lang->stat->keyword       = 'Tag';
$lang->stat->outSite       = 'Site Stats';
$lang->stat->search        = 'Search';
$lang->stat->domain        = 'Domain';
$lang->stat->click         = 'Click Ranking';
$lang->stat->link          = 'Links';
$lang->stat->today         = 'Today';
$lang->stat->yesterday     = 'Yesterday';
$lang->stat->pv            = 'Page Visit';
$lang->stat->uv            = 'Unique Visit';
$lang->stat->ipCount       = 'IP Count';
$lang->stat->totalPV       = 'Total PVs';
$lang->stat->searchEngine  = 'Sear Engine';
$lang->stat->keywordReport = 'Tag Stats';
$lang->stat->domainList    = 'Domain List';
$lang->stat->domainTrend   = 'Trend';
$lang->stat->domainPage    = 'Page';
$lang->stat->percentage    = 'Percentage';
$lang->stat->ignoreKeyword = 'Ignore Tags';
$lang->stat->keywordNotice = 'Google and Baidu have deactivated their service to trace source links of tags, so the relavant statistics is not available.';

$lang->stat->all   = 'All';
$lang->stat->begin = 'Begin';
$lang->stat->end   = 'End';
$lang->stat->date  = 'Date';

$lang->stat->noData    = 'No data.';
$lang->stat->dateError = 'Date Error';

$lang->stat->itemList = new stdclass();
$lang->stat->itemList->self    = 'Direct Access';
$lang->stat->itemList->out     = 'External Link Access';
$lang->stat->itemList->search  = 'Search';
$lang->stat->itemList->desktop = 'Desktop';
$lang->stat->itemList->mobile  = 'Mobile';

$lang->stat->trafficModes = new stdclass();
$lang->stat->trafficModes->yesterday = 'Yesterday';
$lang->stat->trafficModes->today    = 'Today';
$lang->stat->trafficModes->weekly   = 'Last 7 Days';
$lang->stat->trafficModes->monthly  = 'Last 30 Days';

$lang->stat->fromList = new stdclass();
$lang->stat->fromList->self   = 'Direct Access';
$lang->stat->fromList->out    = 'External Link Access';
$lang->stat->fromList->search = 'Search';

$lang->stat->dataTypes = new stdclass();
$lang->stat->dataTypes->pv = 'Page Visit';
$lang->stat->dataTypes->uv = 'Unique Visit';
$lang->stat->dataTypes->ip = 'IP Count';

$lang->stat->page = new stdclass();
$lang->stat->page->common = 'Page Visits';
$lang->stat->page->url    = 'Page URL';

$lang->stat->maxDays    = 'The maximum days for chart';
$lang->stat->maxDaysTip = 'Number of days should be >0.';
