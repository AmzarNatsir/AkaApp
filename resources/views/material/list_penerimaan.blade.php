@php($nom=1)
@foreach ($list_penerimaan as $r)
<tr>
    <td>{{ $nom }}</td>
    <td>{{ $r->getHeader->tanggal }}</td>
    <td>{{ $r->jumlah }}</td>
    <td>{{ $r->getHeader->keterangan }}</td>
</tr>
@php($nom++)
@endforeach
