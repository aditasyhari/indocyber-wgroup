$(document).ready(function() {
    loadingEnd();

    $("#register-form").validate({
        rules: {
            nama: {
                required: true
            },
            email: {
                required: true,
                email: true,
                maxlength: 50
            },
            nohp: {
                required: true,
                digits: true
            },
            password: {
                required: true,
                minlength: 6,
                pattern: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])[A-Za-z\d$@$!%*?&]{6,}$/
            },
            confirm_password: {
                required: true,
                equalTo: "#password"
            }
        },
        messages: {
            nama: {
                required: "Nama harus diisi"
            },
            email: {
                required: "Email harus diisi",
                email: "Format email tidak valid",
                maxlength: "Maksimal 50 karakter"
            },
            nohp: {
                required: "Nomor HP harus diisi",
                digits: "Nomor HP harus berupa angka"
            },
            password: {
                required: "Password harus diisi",
                minlength: "Minimal 6 karakter",
                pattern: "Password harus mengandung setidaknya satu huruf besar, satu huruf kecil, satu angka, dan satu karakter non-alphanumeric (!, $, #, atau %)"
            },
            confirm_password: {
                required: "Konfirmasi password harus diisi",
                equalTo: "Konfirmasi password tidak cocok"
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
                url: "/cms/auth/register",
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
                    btnSubmit.html('Daftar');
                },
            });
        },
    });
});