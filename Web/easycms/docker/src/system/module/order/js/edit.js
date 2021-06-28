$(document).ready(function()
{
  $('.product-deleter').click(function()
  {
      if($('.product-deleter').size() > 1)
      {
          $(this).parents('td').find('input[name*=count]').val('0').change();
          $(this).parents('td').hide().find('.product-deleter').remove();
      }
      else
      {
          $('.product-deleter').addClass('disabled');
    
      }
  });

  $('.icon-plus').click(function()
  {
      input = $(this).parents('td').find('[name*=count]');
      count = parseInt(input.val());
      count ++;
      input.val(count).change();
  });

  $('.icon-minus').click(function()
  {
      input = $(this).parents('td').find('[name*=count]');
      count = parseInt(input.val());
      if(count > 0) count --;
      input.val(count).change();
  });

  $('[name*=count]').change(function()
  {
      amount = 0;
      $('[name*=count]').each(function()
      {
          amount += parseInt($(this).val()) * parseFloat($(this).data('price')).toFixed(2);
      });

      $('#amount').val(amount.toFixed(2));
  })
});
