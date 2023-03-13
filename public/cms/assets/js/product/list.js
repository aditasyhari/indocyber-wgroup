$(document).ready(function() {
    loadDataTable();

    $.validator.addMethod('filesize', function (value, element, param) {
        return this.optional(element) || (element.files[0].size <= param * 1000000)
    }, 'File size must be less than {0} MB');

    $('#table-data tbody').on('click', '.btnDelete', function() {
        id = $(this).data('id');
        deleteData(id);
    });

    $('#table-data tbody').on('click', 'a.btnEdit', function () {
        const row = $('#table-data').DataTable().row( $(this).parents('tr') ).data();
        $('#id-product-edit').val(row.id);
        $('#nama-produk-edit').val(row.nama_produk);
        $('#gambar-produk-edit').attr('placeholder', row.image);
        $('#stok-produk-edit').val(row.stock);
        $('#harga-produk-edit').val(formatRupiah(''+row.harga, 'Rp '));
    });

    $("#update-produk-form").validate({
        rules: {
            id: {
                required: true,
            },
            nama_produk: {
                required: true,
                remote: {
                  url: '/cms/product/check-product-name',
                  type: 'post',
                  data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    id: function() {
                        return $('#id-product-edit').val();
                    },
                    nama_produk: function() {
                        return $('#nama-produk').val();
                    }
                  }
                }
            },
            gambar: {
                extension: 'jpg|jpeg|png',
                filesize: 5 // 5 MB
            },
            stok: {
                required: true,
                digits: true
            },
            harga: {
                required: true,
            }
        },
        messages: {
            nama_produk: {
                required: "Nama produk wajib diisi",
                remote: "Nama produk sudah digunakan"
            },
            gambar: {
                extension: "Ekstensi gambar harus jpg, jpeg, atau png",
                filesize: "Ukuran gambar tidak boleh lebih dari 5 MB"
            },
            stok: {
                required: "Stok wajib diisi",
                digits: "Stok harus berupa angka"
            },
            harga: {
                required: "Harga wajib diisi",
            }

        },
        submitHandler: function(form) {
            let btnSubmit = $("#btn-submit-update");
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
                url: "/cms/product/update",
                data: formData,
                dataType: "JSON",
                processData: false,
                contentType: false,
                success: function(resp) {
                    loadingEnd();
                    reloadDataTable($('#table-data'));
                    closeModal();
                    btnSubmit.prop('disabled', false);
                    btnSubmit.html('Ubah');
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
                    btnSubmit.html('Ubah');
                },
            });
        },
    });

    $("#tambah-produk-form").validate({
        rules: {
            nama_produk: {
                required: true,
                remote: {
                  url: '/cms/product/check-product-name',
                  type: 'post',
                  data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    nama_produk: function() {
                        return $('#nama-produk').val();
                    }
                  }
                }
            },
            gambar: {
                required: true,
                extension: 'jpg|jpeg|png',
                filesize: 5 // 5 MB
            },
            stok: {
                required: true,
                digits: true
            },
            harga: {
                required: true,
            }
        },
        messages: {
            nama_produk: {
                required: "Nama produk wajib diisi",
                remote: "Nama produk sudah digunakan"
            },
            gambar: {
                required: "Gambar wajib diisi",
                extension: "Ekstensi gambar harus jpg, jpeg, atau png",
                filesize: "Ukuran gambar tidak boleh lebih dari 5 MB"
            },
            stok: {
                required: "Stok wajib diisi",
                digits: "Stok harus berupa angka"
            },
            harga: {
                required: "Harga wajib diisi",
            }

        },
        submitHandler: function(form) {
            let btnSubmit = $("#btn-submit-tambah");
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
                url: "/cms/product/add",
                data: formData,
                dataType: "JSON",
                processData: false,
                contentType: false,
                success: function(resp) {
                    loadingEnd();
                    reloadDataTable($('#table-data'));
                    closeModal();
                    btnSubmit.prop('disabled', false);
                    btnSubmit.html('Tambah');
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
                    btnSubmit.html('Tambah');
                },
            });
        },
    });
});

function loadDataTable() 
{
    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#table-data').DataTable({
        destroy: true,
        processing: true,
        serverSide: true,
        ordering: false,
        responsive: true,
        ajax: {
            type: 'POST',
            url: "/cms/product/list",
        },
        columns: [
            { 
                data: 'DT_RowIndex', 
                searchable: false
            },
            { 
                data: 'image',
                searchable: false,
                render: function (data, type, full, meta) {
                    let urlImage = window.location.origin+'/uploads/product/'+data;
                    let output = `
                    <div>
                        <img src="`+urlImage+`" class="img-fluid"/>
                    </div>
                    `;
    
                    return output;
                  }
            },
            { data: 'nama_produk' },
            { data: 'stock' },
            { 
                data: 'harga',
                render: function (data, type, full, meta) {  
                  return formatRupiah(''+data, 'Rp ');
                }
            },
            { 
                data: '',
                searchable: false,
                render: function (data, type, full, meta) {
                    let id = full['id'];
                    let output = `
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            Aksi
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item btnDetail" data-id='`+id+`' href="/cms/product/detail/`+id+`">Lihat</a></li>
                            <li><a class="dropdown-item btnEdit" data-id='`+id+`' data-bs-toggle="modal" data-bs-target="#updateProdukModal" href="#">Ubah</a></li>
                            <li><a class="dropdown-item btnDelete" data-id='`+id+`' href="#">Hapus</a></li>
                        </ul>
                    </div>
                    `;
    
                    return output;
                }
            },
        ],
        drawCallback: function(settings) {
            loadingEnd();
        }
    });
}

function deleteData(id)
{
    swal({
        title: 'Anda yakin hapus data ini?',
        text: "Data tidak dapat dikembalikan.",
        type: 'warning',
        buttons: {
            confirm: {
                text: 'Ya, Hapus!',
                className: 'btn btn-success'
            },
            cancel: {
                visible: true,
                className: 'btn btn-danger'
            }
        }
    }).then((valid) => {
        if (valid) {
            $.ajax({
                type: "POST",
                url: "/cms/product/delete",
                data: {
                    id: id,
                },
                dataType: "JSON",
                beforeSend: function() {
                    loadingStart();
                },
                success: function(resp) {
                    loadingEnd();
                    reloadDataTable($('#table-data'));
                },
                error: function() {
                    loadingEnd();
                    swalError('Gagal Hapus!');
                },
            });
        } else {
            swal.close();
        }
    });
}