$(document).ready(function() {
    $('#checkout').on('click', function() {
        swal({
            title: 'Apakah produk yang ingin dibeli sudah benar?',
            text: "",
            type: 'warning',
            buttons: {
                confirm: {
                    text: 'Checkout',
                    className: 'btn btn-danger'
                },
                cancel: {
                    visible: true,
                    className: 'btn btn-secondary'
                }
            }
        }).then((valid) => {
            if (valid) {
                $.ajax({
                    type: "POST",
                    url: "/cart/checkout",
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: "JSON",
                    beforeSend: function() {
                        loadingStart();
                    },
                    success: function(resp) {
                        loadingEnd();
                        location.reload();
                    },
                    error: function() {
                        loadingEnd();
                        swalError('Gagal Checkout!');
                    },
                });
            } else {
                swal.close();
            }
        });
    });
});