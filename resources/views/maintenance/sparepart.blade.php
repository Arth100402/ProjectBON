<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
  <h4 class="modal-title">Sparepart</h4>
</div>
<div class="modal-body">
    @foreach($data as $d)
        {{ $d->sparepart->nama }} - {{ sprintf('Rp %s', number_format($d->subtotal, 0, ',', '.')) }} <br>
    @endforeach
    Harga Service : {{ sprintf('Rp %s', number_format($d->maintenance->hargaService, 0, ',', '.')) }} <br>
    ------------------------------------------------ <br>
    Total Biaya : {{ sprintf('Rp %s', number_format($d->maintenance->totalBiaya, 0, ',', '.')) }}
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>