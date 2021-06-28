{if(!defined("RUN_MODE"))} {!die()} {/if}
{noparse}
<script>
function loadCartInfo(twinkle)
{
    $('#siteNav').load(createLink('misc', 'printTopBar'),
        function()
        {
            if(twinkle) 
            {
                bootbox.dialog(
                {  
                    message: v.addToCartSuccess,  
                    buttons:
                    {  
                        back:
                        {  
                            label:     v.lang.continueShopping,
                            className: 'btn-primary',  
                            callback:  function(){location.reload();}  
                        },
                        cart:
                        {  
                            label:     v.gotoCart,  
                            className: 'btn-primary',  
                            callback:  function(){location.href = createLink('cart', 'browse');}  
                        }  
                    }  
                });
            }
        }
    );
}
</script>
{/noparse}
