$(document).ready(function() {
    loadingEnd();

    $("#login-form").validate({
        rules: {
            email: {
                required: true,
                email: true
            },
            password: {
                required: true,
                minlength: 6
            }
        },
        messages: {
            email: {
                required: "Email harus diisi",
                email: "Format email tidak valid"
            },
            password: {
                required: "Password harus diisi",
                minlength: "Minimal 6 karakter"
            }
        },
        submitHandler: function(form) {
            let btnSubmit = $("#btn-submit");
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
                url: "/cms/auth/login",
                data: formData,
                dataType: "JSON",
                processData: false,
                contentType: false,
                success: function(resp) {
                    loadingEnd();
                    window.location.href = '/cms/product/list';
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
                    btnSubmit.html('Masuk');
                },
            });
        },
    });
});
