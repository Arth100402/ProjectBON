@extends('utama')
@section('isi')
    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <style>
    </style>
    <h1>Ubah Data Pelanggan {{ $data['nama'] }}</h1>
    <form action="{{ route('customer.update', $data['id']) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="nama">Nama Pelanggan</label><br>
            <input type="text" name="nama" id="nama" class="form-control" placeholder="Masukkan Nama Pelanggan. Contoh: John O'connor Jr."
            value="{{ $data['nama'] }}">
            @error('nama')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="alamat">Alamat Pelanggan</label><br>
            <input type="text" name="alamat" id="alamat" class="form-control" placeholder="Masukkan Alamat Pelanggan. Contoh:  Jl. Sidosermo Airdas No.Kav A9, Sidosermo, Kec. Wonocolo, Surabaya, Jawa Timur 60239"
            value="{{ $data['alamat'] }}">
            @error('alamat')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="instansi">Instansi Pelanggan</label><br>
            <input type="text" name="instansi" id="instansi" class="form-control" placeholder="Masukkan Instansi Pelanggan. Contoh: Performa Optima Komputindo"
            value="{{ $data['instansi'] }}">
            @error('instansi')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="notelp">Nomor Telepon Pelanggan</label><br>
            <input type="number" name="notelp" id="notelp" class="form-control" placeholder="Masukkan Nomor Telepon Pelanggan. Contoh: 081234567890"
            value="{{ $data['notelp'] }}">
            @error('notelp')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="email">Email Pelanggan</label><br>
            <input type="text" name="email" id="email" class="form-control" placeholder="Masukkan Email Pelanggan. Contoh: John@gmail.com"
            value="{{ $data['email'] }}">
            @error('email')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Ubah</button>
        <a class="btn btn-danger" href="/customer">Batal Ubah</a>
    </form>
@endsection
@section('javascript')
@endsection
