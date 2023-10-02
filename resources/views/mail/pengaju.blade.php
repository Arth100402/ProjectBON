Halo {{ $name }},
Terdapat Bon yang diajukan untuk direvisi
<div class="panel card-background-color">
    <h3>Detail Bon</h3>
    <div class="table-wrapper table-responsive" style="height:30vh; overflow-y:scroll">
        <table id="detailTableAcc" class="table table-bordered" style="background-color: white">
            <thead>
                <tr>
                    <th>Mulai Tanggal</th>
                    <th>Akhir Tanggal</th>
                    <th>Asal Kota</th>
                    <th>Tujuan</th>
                    <th>Project</th>
                    <th>Pengaju</th>
                    <th>No Paket</th>
                    <th>Agenda</th>
                    <th>Penggunaan</th>
                    <th>Biaya</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($results as $r)
                    <tr>
                        <td>{{ $r->tglMulai }}</td>
                        <td>{{ $r->tglAkhir }}</td>
                        <td>{{ $r->asalKota }}</td>
                        <td>{{ $r->tujuan }}</td>
                        <td>{{ $r->idOpti }}</td>
                        <td>{{ $r->name }}</td>
                        <td>{{ $r->noPaket }}</td>
                        <td>{{ $r->agenda }}</td>
                        <td>{{ $r->penggunaan }}</td>
                        <td>{{ sprintf('Rp %s', number_format($r->biaya, 0, ',', '.')) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <a href="http://127.0.0.1:8000">Klik untuk menuju web</a>
    </div>
</div>
