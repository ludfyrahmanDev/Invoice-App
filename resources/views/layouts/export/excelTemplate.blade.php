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
        <th></th>
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
            <th style="border: 1px solid black ; font-weitght: bold;">Tanggal Peminjaman</th>
            <th style="border: 1px solid black ; font-weitght: bold;">Status Peminjaman</th>
            <th style="border: 1px solid black ; font-weitght: bold;">Jumlah Peminjaman</th>
            <th style="border: 1px solid black ; font-weitght: bold;">Total Angsuran</th>
        </tr>
    </thead>
    <tbody>
        @php
            $total = 0;
            $totalPaid = 0;
            $totalUnpaid = 0;
        @endphp
        @foreach ($data->data as $idx => $item)
        @php
             $totalBayar = 0;
            foreach ($item->angsuran as $itm) {
                $totalBayar += $itm->total_payment;
            }
            $totalPaid += $totalBayar;
        @endphp
            <tr>
                <th width="50px"></th>
                <td width="40px" style="border: 1px solid black ;">{{ intval($idx) + 1 }}</td>
                @if ($data->type == 'all')
                    <td style="border: 1px solid black ;">{{ $item->supplier->name }}</td>
                @endif
                <td style="border: 1px solid black ;">{{ Helper::tanggal($item->loaning_date) }}</td>
                <td style="border: 1px solid black ;">{{ $item->status == 'paid' ? 'Paid' : 'Unpaid' }}</td>
                <td style="border: 1px solid black ;text-align: right;">{{ Helper::price($item->quantity) }}</td>
                <td style="border: 1px solid black ;text-align: right;">{{ Helper::price($totalBayar) }}</td>
            </tr>
            @php
                // if ($item->status == 'paid') {
                //     $totalPaid += $item->quantity;
                // }
                // if ($item->status == 'unpaid') {
                //     $totalUnpaid += $item->quantity;
                // }
                $total += $item->quantity;
            @endphp
        @endforeach
        <tr>
            <th width="50px"></th>
            <td style="border: 1px solid black ;" colspan="{{$data->type == 'all' ?5:4}}">Total Terbayar</td>
            <td style="border: 1px solid black ;text-align: right;">
                {{ Helper::price($totalPaid) }}</td>
        </tr>
        <tr>
            <th width="50px"></th>
            <td style="border: 1px solid black ;" colspan="{{$data->type == 'all' ?5:4}}">Total Belum Terbayar</td>
            <td style="border: 1px solid black ;text-align: right;">
                {{ Helper::price($total - $totalPaid) }}</td>
        </tr>
        <tr>
            <th width="50px"></th>
            <td style="border: 1px solid black ;" colspan="{{$data->type == 'all' ?5:4}}">Total Peminjaman</td>
            <td style="border: 1px solid black ;text-align: right;">{{ Helper::price($total) }}
            </td>
        </tr>
    </tbody>
</table>
