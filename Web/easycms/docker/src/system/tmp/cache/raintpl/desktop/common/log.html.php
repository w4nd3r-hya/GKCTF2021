<?php if(!class_exists('raintpl')){exit;}?><?php if(!defined("RUN_MODE")){ ?>

<?php echo die(); ?>

<?php } ?>

<?php if(commonModel::isAvailable('stat')){ ?>

<script>
var hash = window.location.hash.substring(1);
var browserLanguage = navigator.language || navigator.userLanguage; 
var resolution      = screen.availWidth + ' X ' + screen.availHeight;
$.get(createLink('log', 'record', "hash=" + hash), {browserLanguage:browserLanguage, resolution:resolution});
</script>
<?php } ?>

