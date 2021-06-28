{if(!defined("RUN_MODE"))} {!die()} {/if}
{if(commonModel::isAvailable('stat'))}
  <script>
  var logLink = "{!helper::createLink('log', 'record')}";
  var browserLanguage = navigator.language || navigator.userLanguage; 
  var resolution      = screen.availWidth + ' X ' + screen.availHeight;
  $.get(logLink, {browserLanguage:browserLanguage, resolution:resolution});
  </script>
{/if}
