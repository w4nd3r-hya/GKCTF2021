{if(!defined("RUN_MODE"))} {!die()} {/if}
{include TPL_ROOT . 'common/header.modal.html.php'}
{!htmlspecialchars_decode($control->config->site->agreementContent)}
{include TPL_ROOT . 'common/footer.modal.html.php'}
