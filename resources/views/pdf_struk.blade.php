<style>
    /* Mengatur ukuran kertas dan margin fisik */
    @page {
        size: A4 portrait;
        margin: 1cm;
        /* Margin luar diperkecil agar area cetak lebih luas */
    }

    body {
        font-family: 'Courier', monospace;
        font-size: 11px;
        margin: 0;
        padding: 0;
        background-color: #fff;
    }

    .struk-box {
        /* Gunakan 95% agar tidak mentok ke kanan pada beberapa browser/printer */
        width: 95%;
        margin: 0 auto 10px auto;
        /* Margin bottom diperkecil jadi 10px agar rapat */
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 12px 18px;
        /* Padding dalam diperkecil */
        box-sizing: border-box;
        page-break-inside: avoid;
    }

    .header {
        font-weight: bold;
        text-align: center;
        font-size: 12px;
        /* Ukuran font judul sedikit diperkecil */
        margin-bottom: 8px;
        text-transform: uppercase;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        table-layout: fixed;
    }

    td {
        padding: 2px 0;
        /* Padding antar baris dirapatkan */
        word-wrap: break-word;
        vertical-align: top;
    }

    /* Pengaturan kolom */
    .label {
        width: 18%;
    }

    .val {
        width: 32%;
    }

    .total-row td {
        border-top: 1px solid #333;
        padding-top: 5px;
        font-weight: bold;
        font-size: 11px;
    }

    .terbilang-area {
        margin-top: 6px;
        font-weight: bold;
        font-size: 9px;
        background-color: #f9f9f9;
        padding: 5px 8px;
        border-radius: 4px;
        text-transform: uppercase;
    }

    .footer {
        margin-top: 8px;
        font-size: 8px;
        text-align: center;
        color: #666;
        line-height: 1.2;
    }

    .text-right {
        text-align: right;
    }

    hr {
        margin: 5px 0;
        border: 0;
        border-top: 1px solid #eee;
    }

    .datetime-cetak {
        text-align: right;
        font-size: 8px;
        /* Ukuran kecil khas printer thermal/struk */
        color: #555;
        margin-bottom: 5px;
    }

    .header {
        margin-top: 0;
        /* Pastikan tidak terlalu jauh dari datetime */
    }
</style>

@foreach ($data as $item)
    <div class="struk-box">
        <div class="datetime-cetak">
            {{ \Carbon\Carbon::now()->translatedFormat('d F Y H:i') }}
        </div>
        <div class="header">STRUK PEMBELIAN LISTRIK PRABAYAR</div>

        <table>
            <tr>
                <td class="label">IDPEL</td>
                <td class="val">: {{ $item->pelanggan_id }}</td>
                <td class="label">BL/TH</td>
                <td class="val">: {{ $item->periode }}</td>
            </tr>
            <tr>
                <td class="label">NAMA</td>
                <td class="val">: {{ $item->pelanggan->nama ?? 'TIDAK DITEMUKAN' }}</td>
                <td class="label">STAND METER</td>
                <td class="val">: {{ $item->pelanggan->stand_meter ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">TARIF/DAYA</td>
                <td colspan="3">: {{ $item->pelanggan->tarif_daya ?? '-' }}</td>
            </tr>
        </table>

        <hr>

        <table>
            <tr>
                <td>RP TAG PLN</td>
                <td class="text-right">Rp {{ number_format($item->tagihan, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>ADMIN</td>
                <td class="text-right">Rp {{ number_format($item->biaya_admin, 0, ',', '.') }}</td>
            </tr>
            <tr class="total-row">
                <td>TOTAL BAYAR</td>
                <td class="text-right">Rp {{ number_format($item->tagihan + $item->biaya_admin, 0, ',', '.') }}</td>
            </tr>
        </table>

        <div class="terbilang-area">
            TERBILANG: {{ \App\Helpers\NumberHelper::terbilang($item->tagihan + $item->biaya_admin) }} RUPIAH
        </div>

        <div class="footer">
            "Informasi Hubungi Call Center 123 Atau hubungi PLN Terdekat"<br>
            Terimakasih - PLN menyatakan struk ini sebagai bukti pembayaran yang sah.
        </div>
    </div>
@endforeach
