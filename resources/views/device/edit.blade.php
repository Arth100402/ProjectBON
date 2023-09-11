@extends('utama')
@section('isi')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif
    <style>
        .cariCB {
            width: 100% !important;
        }
    </style>
    <h1>Ubah Data Barang {{ $data['nama'] }}</h1>
    <form action="{{ route('device.update', $data['id']) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="kategori">Kategori Barang</label><br>
            <select class="cariCB form-control p-3 kategori" name="kategori" id="kategori">
                <option value="{{ $data['dcid'] }}" selected>{{ $data['dcnama'] }}</option>
            </select>
            @error('kategori')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="nama">Nama Barang</label>
            <input type="text" style="text-transform:uppercase" class="form-control" name="nama" id="nama"
                placeholder="Masukkan Nama Barang. Contoh: EPSON PRINTER INKJET COLOR WORKFORCE PRO WF-C20590"
                value="{{ $data['nama'] }}">
            @error('nama')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="tipe">Tipe Barang</label>
            <input type="text" style="text-transform:uppercase" class="form-control" name="tipe" id="tipe"
                placeholder="Masukkan Tipe Barang. Contoh: WORKFORCE PRO WF-C20590" value="{{ $data['tipe'] }}">
            @error('tipe')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="merk">Merk Barang</label>
            <input type="text" style="text-transform:uppercase" class="form-control" name="merk" id="merk"
                placeholder="Masukkan Tipe Barang. Contoh: EPSON" value="{{ $data['merk'] }}">
            @error('merk')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="ipaddress">IP Address Barang</label>
            <input type="text" style="text-transform:uppercase" class="form-control" name="ipaddress" id="ipaddress"
                placeholder="Masukkan IP Address Barang. Contoh: 192.168.0.240" value="{{ $data['ipaddress'] }}">
            @error('ipaddress')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="port">Port Barang</label>
            <input type="number" class="form-control" name="port" id="port"
                placeholder="Masukkan Port Barang. Contoh: 9100" value="{{ $data['port'] }}">
            @error('port')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="serialnumber">Serial Number Barang</label>
            <input type="number" class="form-control" name="serialnumber" id="serialnumber"
                placeholder="Masukkan Serial Number Barang. Contoh: ABCD12345" value="{{ $data['serialnumber'] }}">
            @error('serialnumber')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control" name="username" id="username"
                placeholder="Masukkan Username Barang. Contoh: PrinterEpson" value="{{ $data['username'] }}">
            @error('username')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="text" class="form-control" name="password" id="password"
                placeholder="Masukkan Password Barang. Contoh: 12345678" value="{{ $data['password'] }}">
            @error('password')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="kodeBarcode">Gambar Saat Ini</label><br>
            @foreach (explode(',', $data['image']) as $item)
                <img src="{{ asset('images/' . $item) }}" style="max-height: 200px">
            @endforeach
            <br><br>
            <label for="sdad">Ubah Gambar</label>
            <input type="file" name="images[]" id="images" class="form-control" multiple>
            <input type="hidden" name="oldimage" value="{{ $data['image'] }}">
            @error('images[]')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="sdada">Gambar Baru</label>
            <div id="preview-container"></div>
        </div>
        <button type="submit" class="btn btn-primary">Ubah</button>
        <a class="btn btn-danger" href="/device">Batal Ubah</a>
    </form>
@endsection
@section('javascript')
    <script type="text/javascript">
        $('.kategori').select2({
            placeholder: 'Pilih Kategori',
            ajax: {
                url: '{{ route('device.cariKategori') }}',
                dataType: 'json',
                delay: 250,
                processResults: function(data) {
                    console.log("ISI: " + data);
                    return {
                        results: $.map(data, function(item) {
                            return {
                                text: item.nama,
                                id: item.id
                            }
                        })
                    };
                },
                cache: true
            }
        });
    </script>
    <script>
        document.getElementById('images').addEventListener('change', function(e) {
            var files = e.target.files;
            var previewContainer = document.getElementById('preview-container');

            previewContainer.innerHTML = '';

            for (var i = 0; i < files.length; i++) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    var image = document.createElement('img');
                    image.src = e.target.result;
                    image.style.maxHeight = '200px';

                    previewContainer.appendChild(image);
                }

                reader.readAsDataURL(files[i]);
            }
        });
    </script>
@endsection
