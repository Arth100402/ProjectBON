@extends('utama')
@section('title')
    Tambah Pelanggan Baru
@endsection
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
    <form method="POST" action="{{ route('customer.store') }}">
        @csrf
        <div class="form-group">
            <label for="nama">Nama Pelanggan</label><br>
            <input type="text" name="nama" id="nama" class="form-control"
                placeholder="Masukkan Nama Pelanggan. Contoh: John O'connor Jr." value="{{ old('nama') }}">
            @error('nama')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="alamat">Alamat Pelanggan</label><br>
            <input type="text" name="alamat" id="alamat" class="form-control"
                placeholder="Masukkan Alamat Pelanggan. Contoh:  Jl. Sidosermo Airdas No.Kav A9, Sidosermo, Kec. Wonocolo, Surabaya, Jawa Timur 60239"
                value="{{ old('alamat') }}">
            @error('alamat')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="instansi">Instansi Pelanggan</label><br>
            <input type="text" name="instansi" id="instansi" class="form-control"
                placeholder="Masukkan Instansi Pelanggan. Contoh: Performa Optima Komputindo" value="{{ old('instansi') }}">
            @error('instansi')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="notelp">Nomor Telepon Pelanggan</label><br>
            <input type="number" min="0" name="notelp" id="notelp" class="form-control"
                placeholder="Masukkan Nomor Telepon Pelanggan. Contoh: 081234567890" value="{{ old('notelp') }}">
            @error('notelp')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="email">Email Pelanggan</label><br>
            <input type="text" name="email" id="email" class="form-control"
                placeholder="Masukkan Email Pelanggan. Contoh: John@gmail.com" value="{{ old('email') }}">
            @error('email')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <button type="submit" class="btn btn-success">Tambahkan</button>
        <a class="btn btn-danger" href="/customer">Batal Tambah</a>
    </form>
@endsection
@section('javascript')
@endsection
