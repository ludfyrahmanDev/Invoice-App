<style>
    table,
    th,
    td {
        border: 1px solid;
    }
</style>

<table>
    <tr>
        <th width="50px"></th>
        <th style="font-size: 16px;"><strong>{{ $data->title }}</strong></th>
    </tr>
    @if ($data->type == 'belandang')
        <tr>
            <th width="50px"></th>
            <th></th>
            <th style="font-size: 14px;"><strong>Nama Belandang</strong></th>
            <th style="font-size: 14px;"><strong>{{ $data->belandang }}</strong></th>
        </tr>
    @endif
</table>
<table>
    <thead>
        <tr>
            <th width="50px"></th>
            <th width="40px" style="border: 1px solid black ; font-weitght: bold;">No</th>
            @if ($data->type == 'all')
                <th style="border: 1px solid black ; font-weitght: bold;">Nama Belandang</th>
            @endif
            <th style="border: 1px solid black ; font-weitght: bold;">Total VS</th>
            <th style="border: 1px solid black ; font-weitght: bold;">Total Bayar</th>
            <th style="border: 1px solid black ; font-weitght: bold;">Sisa</th>
        </tr>
    </thead>
    <tbody>
        @php
            $total = 0;
            $totalPaid = 0;
            $number = 1;
            $totalUnpaid = 0;
        @endphp
        @foreach ($data->data as $idx => $item)
        @php
            $totalBayar = $item->total_payment;
            $totalPaid += $totalBayar;
        @endphp
            <tr>
                <th width="50px"></th>
                <td width="40px" style="border: 1px solid black ;">{{ $number++ }}</td>
                @if ($data->type == 'all')
                    <td style="border: 1px solid black ;">{{ $item->supplier->name_alias }}</td>
                @endif
                <td style="border: 1px solid black ;text-align: right;">{{ Helper::price($item->quantity) }}</td>
                <td style="border: 1px solid black ;text-align: right;">{{ Helper::price($totalBayar) }}</td>
                <td style="border: 1px solid black ;text-align: right;">{{ Helper::price(($item->quantity - $totalBayar)) }}</td>

            </tr>
            @php
                $total += $item->quantity;
            @endphp
        @endforeach
        <tr>
            <th width="50px"></th>
            <td style="border: 1px solid black ;" colspan="{{$data->type == 'all' ? 4:3}}">Total Terbayar</td>
            <td style="border: 1px solid black ;text-align: right;">
                {{ Helper::price($totalPaid) }}</td>
        </tr>
        <tr>
            <th width="50px"></th>
            <td style="border: 1px solid black ;" colspan="{{$data->type == 'all' ? 4:3}}">Total Belum Terbayar</td>
            <td style="border: 1px solid black ;text-align: right;">
                {{ Helper::price($total - $totalPaid) }}</td>
        </tr>
        <tr>
            <th width="50px"></th>
            <td style="border: 1px solid black ;" colspan="{{$data->type == 'all' ? 4:3}}">Total Peminjaman</td>
            <td style="border: 1px solid black ;text-align: right;">{{ Helper::price($total) }}
            </td>
        </tr>
    </tbody>
</table>
