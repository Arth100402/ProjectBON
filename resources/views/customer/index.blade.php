@extends('utama')
@section('title')
    Data Pelanggan
@endsection
@section('isi')
    <style>
        .accordion .panel {
            border: 1px solid #ccc;
            margin-bottom: 10px;
        }

        .accordion .header {
            background-color: #f5f5f5;
            padding: 10px;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
        }

        .accordion .header .p {
            align-self: flex-start;
        }

        .accordion .header .btn {
            align-self: flex-end;
            display: flex;
            justify-content: center;
            align-items: center;
            width: 30px;
            height: 30px;
        }

        .accordion .content {
            padding: 10px;
            display: none;
        }

        .accordion .panel2 {
            border: 1px solid #ccc;
            margin-bottom: 10px;
        }

        .accordion .header2 {
            background-color: #f5f5f5;
            padding: 10px;
            cursor: pointer;
        }

        .accordion .content2 {
            padding: 10px;
            display: none;
        }

        .accordion .panel3 {
            border: 1px solid #ccc;
            margin-bottom: 10px;
        }

        .accordion .header3 {
            background-color: #f5f5f5;
            padding: 10px;
            cursor: pointer;
        }

        .accordion .content3 {
            padding: 10px;
            display: none;
        }

        .accordion .panel4 {
            border: 1px solid #ccc;
            margin-bottom: 10px;
        }

        .accordion .header4 {
            background-color: #f5f5f5;
            padding: 10px;
            cursor: pointer;
        }

        .accordion .content4 {
            padding: 10px;
            display: none;
        }

        .accordion {
            height: 100vh;
            overflow: scroll;
        }

        .topdiv {
            display: flex;
            justify-content: center;
            margin-bottom: 50px;
        }

        .topdiv .searchbar {
            width: 500px;
            height: 40px;
            background-color: white;
            border-radius: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 5px;
            margin-left: auto;
            margin-right: auto;
        }

        .searchbar input[type="text"] {
            flex: 1;
            border: none;
            outline: none;
            background-color: transparent;
            padding: 5px;
        }

        .searchbar input[type="text"]::placeholder {
            color: #999;
        }

        .topdiv .btn {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 40px;
            height: 40px;
        }

        .panel .header button {
            position: relative;
            z-index: 1;
        }
    </style>
    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif
    <div class="topdiv">
        <a href="{{ route('customer.create') }}" class="btn btn-success"><i class="fa fa-plus-square-o"></i></a>
        <div class="form-group searchbar">
            <input type="text" class="form-controller" id="search" name="search" placeholder="Cari Pelanggan...">
        </div>
    </div>

    <div class="accordion">

    </div>
@endsection
@section('javascript')
    <script>
        $("#project").addClass("active");
        $("#dataCustomer").addClass("active");
        $.ajax({
            type: 'GET',
            url: "{{ route('customer.jsonShowCustomer') }}",
            success: function(data) {
                data['data'].forEach(element => {
                    var accorChild = $(`
                <div class="panel">
                    <div class="header">  </div>
                    <div class="content"> </div>
                </div>
                    `);
                    var header = accorChild.find('.header');
                    var content = accorChild.find('.content');
                    header.html("<p>" + element.nama + "</p>" +
                        `<a class="btn btn-primary" href="/customer/` + element.id +
                        `/edit"><i class="fa fa-edit"></i></a>`)
                    header.attr('userid', element.id);
                    content.attr('userid', element.id);
                    if (element != null) {
                        $('.accordion').append(accorChild);
                    }
                });
            }
        });
        $('#search').on('keyup', function() {
            var query = $(this).val();
            var accor = $("div").filter(".accordion");
            accor.html("");
            $.ajax({
                type: 'GET',
                url: "{{ route('customer.search') }}",
                data: {
                    search: query
                },
                success: function(data) {
                    accor.html("");
                    data['data'].forEach(element => {
                        var accorChild = $(`
                    <div class="panel">
                        <div class="header"> </div>
                        <div class="content"> </div>
                    </div>
                        `);
                        var header = accorChild.find('.header');
                        var content = accorChild.find('.content');
                        header.html("<p>" + element.nama + "</p>" +
                            `<a class="btn btn-primary" href="/customer/` + element.id +
                            `/edit"><i class="fa fa-edit"></i></a>`)
                        header.attr('userid', element.id);
                        content.attr('userid', element.id);
                        if (element != null) {
                            $('.accordion').append(accorChild);
                        }
                    });
                },
                error: function(err) {
                    console.log(err);
                }
            });
        });
        $(document).on('click', '.linkwa', function() {
            const number = $('.linkwa').val();
            const parts = number.split('');
            if (parts[0] === '0') {
                parts[0] = '62';
            }
            const newnowa = parts.join('');
            const url = `https://web.whatsapp.com/send?phone=`;
            const wa = url.concat('', newnowa);
            window.open(wa, '_blank');
        });
        $(document).on('click', '.header', function() {
            $(this).next('.content').toggle();
            var userid = $(this).attr("userid");
            var content = $("div").filter(".content[userid='" + userid + "']");
            var alamat = "";
            var instansi = "";
            var notelp = "";
            var email = "";

            $.ajax({
                type: 'POST',
                url: "{{ route('customer.jsonShowSpecCustomer') }}",
                data: {
                    '_token': '<?php echo csrf_token(); ?>',
                    'id': userid
                },
                async: false,
                success: function(data) {
                    alamat = data['data'][0].alamat;
                    instansi = data['data'][0].instansi;
                    notelp = data['data'][0].notelp;
                    email = data['data'][0].email;
                }
            });
            content.html(`
                <b>Alamat Customer :</b>
                <p>` + alamat + `</p>
                <b>Instansi Customer :</b>
                <p>` + instansi + `</p>
                <b>Nomor Telepon Customer :</b>
                <p>` + notelp + `
                <button
                value="${notelp}"
                class="linkwa"
                style="background-color: transparent;border-color: #ccc;">
                <img src="{{ asset('assets/img/icon-wa.png') }}" alt="wa" height="45%" width="45%">
                </button>
                </p>
                <b>Email Customer :</b>
                <p>` + email + `</p>
                <b>Project Customer :</b>
            `);
            $.ajax({
                type: 'POST',
                url: "{{ route('customer.jsonShowCustomerProject') }}",
                data: {
                    '_token': '<?php echo csrf_token(); ?>',
                    'id': userid
                },
                async: false,
                success: function(data2) {
                    data2['data'].forEach(element2 => {
                        var accorChild2 = $(`
                <div class="panel2">
                    <div class="header2"> </div>
                    <div class="content2"> </div>
                </div>
                `);
                        if (element2 != null) {
                            var header2 = accorChild2.find('.header2');
                            var content2 = accorChild2.find('.content2');
                            header2.text(element2.namaOpti);
                            header2.attr('userid', userid);
                            header2.attr('projectid', element2.id);
                            content2.attr('userid', userid);
                            content2.attr('projectid', element2.id);
                            content.append(accorChild2);
                        }
                    });
                },
                error: function(err) {
                    console.log(err);
                }
            });
        });
        $(document).on('click', '.header2', function() {
            $(this).next('.content2').toggle();
            var userid = $(this).attr("userid");
            var projectid = $(this).attr("projectid");
            var content2 = $("div").filter(".content2[projectid='" + projectid + "']");
            var namaOpti = "";
            var tglBuat = "";
            var tglRealisasi = "";
            var deadline = "";
            var status = "";
            $.ajax({
                type: 'POST',
                url: "{{ route('customer.jsonShowCustomerProject') }}",
                data: {
                    '_token': '<?php echo csrf_token(); ?>',
                    'id': userid,
                    'projectid': projectid
                },
                async: false,
                success: function(data) {
                    namaOpti = data['data'][0].namaOpti;
                    tglBuat = data['data'][0].tglBuat;
                    tglRealisasi = data['data'][0].tglRealisasi;
                    deadline = data['data'][0].deadline;
                    status = data['data'][0].status;
                    content2.html(`
                    <b>Nama Opti :</b>
                    <p>` + namaOpti + `</p>
                    <b>Tanggal Buat :</b>
                    <p>` + tglBuat + `</p>
                    <b>Tanggal Realisasi :</b>
                    <p>` + tglRealisasi + `</p>
                    <b>Deadline :</b>
                    <p>` + deadline + `</p>
                    <b>Status :</b>
                    <p>` + status + `</p>
                    <b>Kategori Barang pada Project :</b>
                    `);
                }
            });
            $.ajax({
                type: 'POST',
                url: "{{ route('customer.jsonShowDeviceCategoryProject') }}",
                data: {
                    '_token': '<?php echo csrf_token(); ?>',
                    'projectid': projectid
                },
                async: false,
                success: function(data2) {
                    data2['data'].forEach(element => {
                        var accorChild3 = $(`
                        <div class="panel3">
                            <div class="header3"> </div>
                            <div class="content3"> </div>
                        </div>
                        `);
                        if (element != null) {
                            var header3 = accorChild3.find('.header3');
                            var content3 = accorChild3.find('.content3');
                            header3.text(element.nama);
                            header3.attr('catid', element.id);
                            content3.attr('catid', element.id);
                            content2.append(accorChild3);
                        }
                    });
                },
                error: function(err) {
                    console.log(err);
                }
            });
        });
        $(document).on('click', '.header3', function() {
            $(this).next('.content3').toggle();
            var catid = $(this).attr("catid");
            var content3 = $("div").filter(".content3[catid='" + catid + "']");
            content3.html("");
            $.ajax({
                type: 'POST',
                url: "{{ route('customer.jsonShowDeviceCategoryProject') }}",
                data: {
                    '_token': '<?php echo csrf_token(); ?>',
                    'catid': catid
                },
                async: false,
                success: function(data) {
                    data['data'].forEach(element => {
                        var accorChild4 = $(`
                        <div class="panel4">
                            <div class="header4"> </div>
                            <div class="content4"> </div>
                        </div>
                        `);
                        if (element != null) {
                            var header4 = accorChild4.find('.header4');
                            var content4 = accorChild4.find('.content4');
                            header4.text(element.nama);
                            header4.attr('deviceid', element.id);
                            content4.attr('deviceid', element.id);
                            content3.append(accorChild4);
                        }
                    });
                }
            });
        });
        $(document).on('click', '.header4', function() {
            $(this).next('.content4').toggle();
            var deviceid = $(this).attr("deviceid");
            var content4 = $("div").filter(".content4[deviceid='" + deviceid + "']");
            $.ajax({
                type: 'POST',
                url: "{{ route('customer.jsonShowCustomerProjectDevice') }}",
                data: {
                    '_token': '<?php echo csrf_token(); ?>',
                    'deviceid': deviceid
                },
                async: false,
                success: function(data) {
                    var tipe = data['data'][0].tipe;
                    var merk = data['data'][0].merk;
                    var ip = data['data'][0].ipaddress;
                    var port = data['data'][0].port;
                    var sn = data['data'][0].serialnumber;
                    var username = data['data'][0].username;
                    var password = data['data'][0].password;
                    var stat = data['data'][0].status;
                    content4.html(`
                <b>Tipe Barang :</b>
                <p>` + tipe + `</p>
                <b>Merk Barang :</b>
                <p>` + merk + `</p>
                <b>IP Address :</b>
                <p>` + ip + `</p>
                <b>Port :</b>
                <p>` + port + `</p>
                <b>Serial Number :</b>
                <p>` + sn + `</p>
                <b>Username :</b>
                <p>` + username + `</p>
                <b>Password :</b>
                <p>` + password + `</p>
                <b>Status :</b>
                <p>` + stat + `</p>
                `);
                }
            });
        });
    </script>
@endsection
