@foreach ($data as $key => $v)
    <p><strong>Indikator:</strong> {{ $v->indikator }}</p>
    <p><strong>Definisi Operasional:</strong> {{ $v->definisi_operasional }}</p>
    <hr>
@endforeach
