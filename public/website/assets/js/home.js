$(document).ready(function() {
    $(".bag").on('click', function() {
        console.log($(this).data());
        $("#cart-product").html($(this).data('product'));
        $("#cart-image").attr("src", $(this).data('image'));
        // $("#cart-qty").attr("max", $(this).data('stock'));
        $("#cart-stock").html($(this).data('stock'));
        $("#cart-price").html(formatRupiah(''+$(this).data('price'), 'Rp '));
        $("#cart-id-product").val($(this).data('id'));
    });

    $("#cart-form").validate({
        rules: {
            qty: {
                required: true,
                min: 1
            }
        },
        messages: {
            qty: {
                required: "Quantity harus diisi",
                min: "Minimal 1"
            }
        },
        submitHandler: function(form) {
            let btnSubmit = $("#btn-submit-cart");
            btnSubmit.prop('disabled', true);
            btnSubmit.html('Processing...');
    
            var formData = new FormData(form);
    
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: "/cart/add",
                data: formData,
                dataType: "JSON",
                processData: false,
                contentType: false,
                success: function(resp) {
                    loadingEnd();
                    swalSuccess(resp.message);
                    closeModal();
                    $("#tip-total-cart").html(resp.totalCart);
                    btnSubmit.prop('disabled', false);
                    btnSubmit.html('Masukkan Keranjang');
                },
                error: function(xhr, textstatus, errorthrown) {
                    let code = xhr.responseJSON.code;
                    if(code == 400) {
                        let errors = xhr.responseJSON.message;
                        var message = '';
                        $.each(errors, function(index, value) {
                            message += value[0] + '\n';
                        });
                    } else {
                        message = xhr.responseJSON.message;
                    }
                    
                    swalInfo(message);
                    btnSubmit.prop('disabled', false);
                    btnSubmit.html('Masukkan Keranjang');
                },
            });
        },
    });
});