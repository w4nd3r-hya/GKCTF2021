<?php if(!defined("RUN_MODE")) die();?>
<?php if($extView = $this->getExtViewFile(__FILE__)){include $extView; return helper::cd();}?>
<?php css::import($jsRoot . 'jquery/chosen/min.css');?>
<?php js::import($jsRoot . 'jquery/chosen/min.js');?>
<?php $clientLang = $this->app->getClientLang(); ?>

<script language='javascript'> 
var defaultChosenOptions = {no_results_text: '<?php echo $lang->noResultsMatch;?>', width:'100%', allow_single_deselect: true, disable_search_threshold: 1, placeholder_text_single: ' ', placeholder_text_multiple: ' ', search_contains: true};
$(document).ready(function()
{
    $(".chosen").chosen(defaultChosenOptions);
    $('select.chosen-icons').chosenIcons({lang: '<?php echo $clientLang; ?>'});
});
</script>
