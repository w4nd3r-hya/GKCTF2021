{if(!defined("RUN_MODE"))} {!die()} {/if}
{if($extView = $control->getExtViewFile(TPL_ROOT . 'common/chosen.html.php'))}
  {include $extView}
  {@return helper::cd()}
{/if}
{!css::import($jsRoot . 'jquery/chosen/min.css')}
{!js::import($jsRoot . 'jquery/chosen/min.js')}
{$clientLang = $control->app->getClientLang()}
<script> 
$(document).ready(function()
{
    $(".chosen").chosen({no_results_text: '{$lang->noResultsMatch}', placeholder_text:' ', disable_search_threshold: 10, width: '100%', search_contains: true});
    $('select.chosen-icons').chosenIcons({lang: '{$clientLang}'});
});
</script>
