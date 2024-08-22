<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Mutu</title>
</head>
<style>
     table {
        width: 100%;
        text-align: center;
    }
    table, th, td {
        padding: 8px;
        border: 1px solid #dddd;
        border-collapse: collapse;
    }
</style>
<body>
    {{-- include header --}}
    @include('pages.backoffice.purchase.header')
    <h3>Laporan Mutu</h3>
    @if ($request->category_id)
        <h4>Kategori: {{ $data['category']->name }}</h4>
    @else
        <h4>Kategori: Semua Kategori</h4>
    @endif
    @if($request->start_date && $request->end_date)
        <h4>Periode:{{$request->start_date}} / {{ $request->end_date }}</h4>
    @endif
    <table>
        <thead>
            <tr>
                <th>Grade</th>
                <th>Berat</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data['data'] as $item)
                <tr>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->qty }} Kg</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td>Total</td>
                <td>{{ $data['qty'] != 0 ? $data['qty'] : (count($data['data']) > 0 ? $data['data']?->sum('qty') : 0)}} Kg</td>
            </tr>
        </tfoot>
    </table>
</body>
</html>
