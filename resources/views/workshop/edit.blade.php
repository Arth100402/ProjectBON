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
    <h1>Ubah Data Bengkel {{ $data['nama'] }}</h1>
    <form action="{{ route('workshop.update', $data['id']) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="nama">Nama Bengkel</label><br>
            <input type="text" name="nama" id="nama" class="form-control" placeholder="Masukkan Nama Bengkel"
            value="{{ $data['nama'] }}">
            @error('nama')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="alamat">Alamat Bengkel</label><br>
            <input type="text" name="alamat" id="alamat" class="form-control" placeholder="Masukkan Alamat Bengkel"
            value="{{ $data['alamat'] }}">
            @error('alamat')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Ubah</button>
        <a class="btn btn-danger" href="/workshop">Batal Ubah</a>
    </form>
@endsection
@section('javascript')
@endsection
