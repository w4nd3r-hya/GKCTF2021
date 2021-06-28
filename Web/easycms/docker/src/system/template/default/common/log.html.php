{if(!defined("RUN_MODE"))} {!die()} {/if}
{if(commonModel::isAvailable('stat'))}
<script>
var hash = window.location.hash.substring(1);
var browserLanguage = navigator.language || navigator.userLanguage; 
var resolution      = screen.availWidth + ' X ' + screen.availHeight;
$.get(createLink('log', 'record', "hash=" + hash), {browserLanguage:browserLanguage, resolution:resolution});
</script>
{/if}
