"use strict";

$(document).ready(function() {
    $(".text-number").on("keyup", function() {
        let format = formatRupiah($(this).val(), 'Rp ');
        $(this).val(format);
    });
    
    $("#logout").on("click", function() {
        loadingStart();
        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    
        $.ajax({
            type: "POST",
            url: "/cms/auth/logout",
            dataType: "JSON",
            processData: false,
            contentType: false,
            beforeSend: function() {
                loadingStart();
            },
            success: function(resp) {
                loadingEnd();
                window.location.href = '/cms/auth/login';
            },
            error: function(xhr, textstatus, errorthrown) {
                swalError('Gagal Keluar');
            },
        });
    });
});

function formatRupiah(angka, prefix) 
{
    var number_string = angka.replace(/[^,\d]/g, "").toString(),
        split = number_string.split(","),
        sisa = split[0].length % 3,
        rupiah = split[0].substr(0, sisa),
        ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    if (ribuan) {
        let separator = sisa ? "." : "";
        rupiah += separator + ribuan.join(".");
    }

    rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;

    return prefix == undefined ? rupiah : rupiah ? "Rp " + rupiah : "";
}

function formatTanggal(tanggal, tipe = 'date')
{
    var date = new Date(tanggal);

    var tahun = date.getFullYear();
    var bulan = date.getMonth();
    var tanggal = date.getDate();
    var hari = date.getDay();

    switch(hari) {
        case 0: hari = "Minggu"; break;
        case 1: hari = "Senin"; break;
        case 2: hari = "Selasa"; break;
        case 3: hari = "Rabu"; break;
        case 4: hari = "Kamis"; break;
        case 5: hari = "Jum'at"; break;
        case 6: hari = "Sabtu"; break;
    }

    switch(bulan) {
        case 0: bulan = "Januari"; break;
        case 1: bulan = "Februari"; break;
        case 2: bulan = "Maret"; break;
        case 3: bulan = "April"; break;
        case 4: bulan = "Mei"; break;
        case 5: bulan = "Juni"; break;
        case 6: bulan = "Juli"; break;
        case 7: bulan = "Agustus"; break;
        case 8: bulan = "September"; break;
        case 9: bulan = "Oktober"; break;
        case 10: bulan = "November"; break;
        case 11: bulan = "Desember"; break;
    }

    var output = hari + ", " + tanggal + " " + bulan + " " + tahun;
    if(tipe == 'datetime') {
        var jam = date.getHours();
        var menit = date.getMinutes();
        // var detik = date.getSeconds();
        output = output + " " + jam + ":" + menit;
    }

    return output;
}

function loadingStart() {
    document.getElementById("loader-screen").classList.add("show");
}

function loadingEnd() {
    document.getElementById("loader-screen").classList.remove("show");
}

function swalWarning(message, title = "Warning") {
    swal(title, message, {
        icon: "warning",
        buttons: {
            confirm: {
                className: 'btn btn-warning xl:w-32'
            }
        },
    });
}

function swalError(message, title = "Error") {
    swal(title, message, {
        icon: "error",
        buttons: {
            confirm: {
                className: 'btn btn-danger xl:w-32'
            }
        },
    });
}

function swalSuccess(message, title = "Success") {
    swal(title, message, {
        icon: "success",
        buttons: {
            confirm: {
                className: 'btn btn-success xl:w-32'
            }
        },
    });
}

function swalInfo(message, title = "Info") {
    swal(title, message, {
        icon: "info",
        buttons: {
            confirm: {
                className: 'btn btn-info xl:w-32'
            }
        },
    });
}

loadingStart();

$(document).on('hide.bs.modal', '.modal', function() {
    $('.modal').find('form').trigger("reset");
})

function closeModal() {
    $(".btn-close").click();
}

function reloadDataTable(table) {
    table.DataTable().ajax.reload(null, false);
}

function setNotif(message, heading = "Notification") {
    $.toast({
        heading: heading,
        text: message,
        showHideTransition: 'slide',
        position: 'bottom-right',
        stack: false,
    });
}

function setValueFilter(className) {
    $('.select-' + className).on('change', function() {
        loadingStart();
        loadDataTable();
    });
}

function decode(str) {
    let txt = document.createElement("textarea");
    txt.innerHTML = str;

    return txt.value;    
}
