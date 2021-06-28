<?php if(!defined('RUN_MODE')) die();?>form .article-files > li.article-files-heading {display: none}
form .article-files {margin-bottom: 10px;}

.colorplate{padding: 0; border: none;}
.color-tile {display: block; float: left; width: 30px; height: 30px; border-radius: 4px; border: 1px solid #ccc; margin: 2px 2px 0 0; cursor: pointer; transition: all 0.4s; text-align: center; line-height: 30px;}
.color-tile:hover, .color-tile.active {border-color: #333; box-shadow: 0 1px 4px rgba(0,0,0,0.5)}
.input-group.color {width: 200px;}
.color .icon-ok, .color .icon-question {display: none}
.color.active > .icon-ok, .color.error > .icon-question, .color.active .input-group-btn > .dropdown-toggle > .icon-ok, .color.error .input-group-btn > .dropdown-toggle > .icon-question {display: inline;}
.color.active.error .icon-ok {display: none}
.color .input-group-addon {min-width: 40px; text-align: center; border-left: none; border-radius: 0;}

.input-group-btn > .dropdown-toggle {border-right: none; border-radius: 0;}
.input-group-addon .checkbox-inline {padding-top: 0;}

.dropdown-menu.colors {padding: 5px; width: 205px}
.dropdown-menu.buttons {padding: 5px; padding-bottom: 0;}
.dropdown-menu.buttons > li {margin-bottom: 5px;}
.thread{position: relative;}
.thread .table{table-layout: fixed;}
.thread .panel-heading > i{display: inline-block;font-size: 30px;margin-right: 10px;}
.thread .panel-actions{margin-top: 10px;}
.thread.reply .panel-actions{margin-top: 0;margin-right: 0;}
.thread .panel-actions .label{font-size: 14px;}

.speaker{width: 200px; border-right:1px solid #ddd; padding: 10px 15px !important;}
.thread-author{display: block; padding: 5px 0; border-bottom: 1px dashed #ddd;margin-bottom: 10px;}
.thread-content{padding: 5px;}
.thread .article-files{border-top:1px dashed #ddd; margin: 0 -8px -2px; padding: 10px 15px; background: none}
.thread .article-files-heading{margin-bottom: 0;}

.table > tbody > tr > td.thread-wrapper{padding-bottom: 37px;}
.thread-foot{position: absolute;bottom: 0;left: 200px;right:0;padding: 8px;border-top: 1px solid #ddd;}
.thread-actions > a,.thread-more-actions > .dropdown > a, .thread-more-actions > a{display: inline-block; margin-left: 10px; }
.thread-actions .caret{border-bottom: 4px solid #999; }

.pager{display: block; margin: -5px 0 5px;}

#replyForm .file-form .form-group{margin-left: -15px; margin-right: -15px; }

.thread.panel{border-color:#bed0e3; box-shadow:0 1px 1px #bed0e3}
.thread .panel-heading{background-color: #EBF2F9;color: #31708F;background-image: -moz-linear-gradient(#f1f8ff, #e1f0ff); background-image: -webkit-linear-gradient(#f1f8ff, #e1f0ff); background-image: linear-gradient(#f1f8ff, #e1f0ff); background-repeat: repeat-x;border-color:#bed0e3;}
.thread.panel.striped{border-color:#d7c9ad; box-shadow:0 1px 1px #d7c9ad}
.thread.striped .panel-heading{background-color:#FCF8E3;color: #8A6D3B;background-image: -moz-linear-gradient(#fdfaeb, #f5f0d3); background-image: -webkit-linear-gradient(#fdfaeb, #f5f0d3); background-image: linear-gradient(#fdfaeb, #f5f0d3); background-repeat: repeat-x;border-color:#d7c9ad;}

#replyForm .control-label{margin-bottom: 0; margin-top: 0; padding-top: 7px; padding-right: 0;}

.alert-replies{margin-top: 15px;}
.alert-replies .reply-date{margin-right: 10px;}
.alert-replies hr:last-child{display: none;}
.reply-content+.article-files{margin-top: 8px;}
.alert-replies .reply-content{display: inline;}
.alert-replies > .second-replies{margin-left: 10px; margin-bottom: 10px; padding: 10px 10px 0; background: #fff;}
.alert-replies .files-list > li.files-list-heading {display:none;}

.bootbox .modal-dialog .modal-footer {text-align: center;}

@media (max-width: 767px) {.speaker,.thread-wrapper {display: block; width: 100%} .table > tbody > tr > td.thread-wrapper {padding-bottom: 47px;} td.speaker {border-bottom: 1px dashed #ddd; position: relative; padding: 8px 15px; border-right: 0} .speaker > ul {display: block; position: absolute; right: 15px; top: 10px;} .speaker .thread-author {border: none; margin-bottom: 0; padding: 0;} .speaker > ul > li {display: inline-block; margin-left: 5px; font-size: 12px; color: #666} .speaker > ul > li:nth-child(2) {display: none} .speaker > ul > li > small {color: #808080; font-weight: bold;} .thread-foot {left: 0}}
@media (max-width: 480px) {.speaker > ul > li:nth-child(1) {display: none}}
@media (max-width: 400px) {.speaker > ul {display: none}}

#header {padding: 0; margin-bottom: 14px;}
#headNav {min-height: 30px; line-height: 30px; padding: 0; margin-bottom: 8px;}
#headNav, #headTitle {position: static; display: block;}
#headNav > .row {margin: 0}
#headTitle > .row, #headNav > .row {display: table; width: 100%; margin: 0}
#headNav > .row > #siteNav,
#headNav > .row > #siteSlogan,
#headNav > .row > #searchbar,
#headTitle > .row > #siteTitle,
#headTitle > .row > #searchbar {display: table-cell; vertical-align: middle;}

#headTitle {padding: 0;}
#siteNav {text-align: right; float: right; display: inline-block !important;}
@media (max-width: 767px){#siteNav {padding-left: 8px; padding-right: 8px;} }

#searchbar {max-width: initial;}
#searchbar > form {max-width: 200px; float: right;}
#navbar .navbar-nav {width: 100%}
#navbarCollapse {padding: 0;}
#navbar .navbar-nav {margin: 0;}
#navbar li.nav-item-searchbar {float: right;}
#navbar li.nav-item-searchbar #searchbar > form {margin: 4px;}













