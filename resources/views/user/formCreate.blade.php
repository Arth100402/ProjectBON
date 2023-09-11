@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<div class="form-group">
    <label for="projectSelect">Project: </label>
    <select name="projectSelect" id="projectSelect"
        class="selectpicker form-control border-0 mb-1 px-4 py-4 rounded shadow">
        <option value="{{ $data->id }}" disabled selected>{{ $data->namaOpti }}</option>
    </select>
    @error('projectSelect')
        <span class="text-danger">{{ $message }}</span>
    @enderror
</div>
<div class="form-group">
    <label for="inputNoPol">Nama Aktifitas: </label>
    <input type="text" class="form-control" name="namaAktifitas" id="namaAktifitas"
        placeholder="Masukkan Nama Aktifitas" value="{{ $data->namaAktifitas }}">
    @error('projectSelect')
        <span class="text-danger">{{ $message }}</span>
    @enderror
</div>
<div class="form-group">
    <label for="deviceSelect">Barang </label>
    <select name="deviceSelect" id="deviceSelect"
        class="selectpicker form-control border-0 mb-1 px-4 py-4 rounded shadow">
    </select>
    @error('deviceSelect')
        <span class="text-danger">{{ $message }}</span>
    @enderror
    <label for="status">Status</label><br>
    <select name="status" id="status" class="selectpicker form-control border-0 mb-1 px-4 py-4 rounded shadow">
        <option value="Proses">Proses</option>
        <option value="Ditunda">Ditunda</option>
        <option value="Selesai">Selesai</option>
    </select>
    @error('status')
        <span class="text-danger">{{ $message }}</span>
    @enderror
    <br>
    <button type="button" id="addDevice" class="btn btn-primary addDevice">Tambah Device</button>
</div>

<table id="myTable" class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>Nama Device</th>
            <th>Jenis Device</th>
            <th>Tipe Device</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody id="table-container">

    </tbody>
</table>
<div class="form-group">
    <label for="inputNoPol">Keterangan: </label>
    <input type="text" rows="4" cols="50" class="form-control" name="keterangan" id="keterangan"
        placeholder="Masukkan Keterangan Aktifitas" value="{{ $data->keterangan }}">
</div>
<div class="form-group">
    <label for="waktuTiba">Waktu Tiba: </label><br>
    <input type="time" name="waktuTiba" id="waktuTiba" class="form-control"style="width: 30%"
        value="{{ $data->waktuTiba }}" disabled>
</div>
<div class="form-group">
    <label for="waktuSelesai">Waktu Selesai: </label><br>
    <input type="time" name="waktuSelesai" id="waktuSelesai" class="form-control" style="width: 30%"
        value="{{ $data->waktuSelesai }}" disabled>
</div>
