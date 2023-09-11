@extends('utama')
@section('title')
    Tambahkan Bengkel Baru
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
    <form method="POST" action="{{ route('workshop.store') }}">
        @csrf
        <div class="form-group">
            <label for="nama">Nama Bengkel</label><br>
            <input type="text" name="nama" id="nama" class="form-control" placeholder="Masukkan Nama Bengkel"
            value="{{ old('nama') }}">
            @error('nama')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="alamat">Alamat Bengkel</label><br>
            <input type="text" name="alamat" id="alamat" class="form-control" placeholder="Masukkan Alamat Bengkel"
            value="{{ old('alamat') }}">
            @error('alamat')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <button type="submit" class="btn btn-success">Tambahkan</button>
        <a class="btn btn-danger" href="/workshop">Batal Tambah</a>
    </form>
@endsection

@section('javascript')
@endsection
