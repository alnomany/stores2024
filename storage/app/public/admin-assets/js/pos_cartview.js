
$('#customer1').on("change",function(){
    $('#customer_info').val($('#customer1').val());
});
$('#customer').on("change",function(){
    "use strict";
    $('#customer_info').val($('#customer').val());
});
$('.give_discount').on('keyup',function(){
    
    "use strict";
    var discount = $(this).val();
    $('#discount').val($(this).val());
    $('#discount1').val($(this).val());
    var grand_total = $('#grand_total1').val();
    var sub_total = $('#sub_total').val();
    if(discount == '')
    {
        discount = 0;
    }
    if(parseFloat(sub_total - discount) >= 0)
    {
        $('#discount_amount1').html(currency_formate(discount));
        $('#discount_amount11').html(currency_formate(discount));
        $('#discount_amount').val(discount);
        $('#total_amount1').html(currency_formate(parseFloat(grand_total - discount)));
        $('#total_amount').html(currency_formate(parseFloat(grand_total - discount)));
        $('#grand_total').val(parseFloat(grand_total - discount));
        $('#discounttotal').val(parseFloat(parseFloat(grand_total- discount)));
        $("#modal_total_amount").val(parseFloat(grand_total - discount));
    }
    else
    {
        $('#discount_amount1').html(currency_formate(0));
        $('#discount_amount11').html(currency_formate(0));
        $('#discount_amount').val(0);
        $('#total_amount1').html(currency_formate(parseFloat(grand_total)));
        $('#total_amount').html(currency_formate(parseFloat(grand_total)));
        $('#grand_total').val(parseFloat(grand_total));
        $('#discounttotal').val(parseFloat(parseFloat(grand_total)));
        $("#modal_total_amount").val(parseFloat(grand_total));
        toastr.error(discount_message);
    }
});
function showaddons(name, price) {
    "use strict";
    $('#modal_selected_addons').find('.list-group-flush').html(
        '<div class="text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>'
    );
    var response = '';
    $.each(name.split('|'), function(key, value) {
        response += '<li class="list-group-item"> <b> ' + value + ' </b> <p class="mb-0">' +
            currency_formate(price.split('|')[key]) + '</p> </li>';
    });
    $('#modal_selected_addons').find('.list-group-flush').html(response);
    $('#modal_selected_addons').modal('show');
}
function qtyupdate(id, type, qtyurl,item_id,variant_id,cart_qty) {
    "use strict";
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: qtyurl,
        data: {
            id: id,
            type: type,
            item_id : item_id,
            variant_id : variant_id,
            qty : cart_qty,
        },
        method: 'POST',
        success: function (response) {
            if(response.status == 0)
            {
                toastr.error(response.message);
                // setTimeout(() => {
                //     document.location.reload();
                //   }, 5000);
                
            }
            else
            {
                $("#cartview").html('');
                $("#cartview").html(response);
            }
           
        },
        error: function (e) {
            $('#preload').hide();
            $('.err' + id).html(e.message);
            return false;
        }
    });
}