<!DOCTYPE html>
<html>

<head>
    <title>SK Pembimbing - {{ $data['nim'] }}</title>
    <style>
        @page {
            size: Legal;
            margin: 1cm;
        }

        body {
            font-family: "Times New Roman", serif;
            line-height: 1.2;
            margin: 0;
            padding: 0;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .content {
            margin: 0 40px;
        }

        table {
            border-collapse: collapse;
        }

        table.no-border td {
            border: none;
            padding: 0px 0px;
            vertical-align: top;
        }

        .title {
            text-align: center;
            font-weight: bold;
            font-size: 12pt;
            margin-bottom: 0px;
        }

        .nomor-surat {
            text-align: center;
            margin: 0px 0;
        }

        .ttd {
            margin-top: 30px;
            text-align: left;
            float: right;
            width: 300px;
        }

        .tembusan {
            margin-top: 150px;
            font-size: 10pt;
        }
    </style>
</head>

<body>
    <table style="width: 100%;">
        <tr>
            <td></td>
            <td></td>
            <td align="right" style="font-size: 10pt; font-weight: bold;">FR-DP-04-31</td>
        </tr>
        <tr valign="top">
            <td width="150" align="right">
                <img src="{{ public_path('img/logoUndipaa.png') }}" alt="Kop Surat" style="width: 100px; height: 100px;">
            </td>
            <td align="center">
                <div style="font-size: 18pt; font-weight: bold;">YAYASAN DIPANEGARA</div>
                <div style="font-size: 15pt; font-weight: bold;">UNIVERSITAS DIPA MAKASSAR</div>
                <small>
                    Jl. Perintis Kemerdekaan KM. 9 Makassar Telp. 0411-591555, Hotline: 0812-3456-7890 <br>
                    Website: www.undipaa.ac.id Email: info@undipaa.ac.id
                </small>
            </td>
            <td width="100"></td>
        </tr>
    </table>

    <div class="content">
        <hr>
        <div class="title">SURAT KEPUTUSAN</div>
        <div class="title">REKTOR UNIVERSITAS DIPA MAKASSAR</div>
        <div class="nomor-surat">Nomor: .../UNDIPA/.../.../....</div>
        <div class="title">Tentang</div>
        <div class="title">PENGANGKATAN DOSEN PEMBIMBING TUGAS AKHIR / SKRIPSI</div>
        <div class="title">REKTOR UNIVERSITAS DIPA MAKASSAR</div>

        <table class="no-border">
            <tr valign="top">
                <td width="100">Menimbang</td>
                <td width="2">:</td>
                <td align="justify">
                    1. Bahwa untuk menyelesaikan Tugas Akhir/Skripsi studi mahasiswa Universitas Dipa Makassar perlu
                    menunjuk/mengangkat Pembimbing mahasiswa dalam menyelesaikan Tugas Akhir / Skripsi;<br>
                    2. Bahwa berdasarkan pertimbangan yang dimaksud pada poin satu (1) di atas dipandang perlu
                    menerbitkan Surat Keputusan Rektor.
                </td>
            </tr>
            <tr>
                <td width="100">Memperhatikan</td>
                <td width="2">:</td>
                <td align="justify">
                    1. Undang-undang RI Nomor: 20 Tahun 2003 tentang Sistem Pendidikan Nasional.<br>
                    2. Peraturan Pemerintah Nomor 19 tahun 2005 tentang Standar Nasional Pendidikan.<br>
                    3. Peraturan Pemerintah Nomor 17 tahun 2010 jo No. 66 Tahun 2010 tentang Pengelolaan dan
                    Penyelenggaraan Pendidikan;<br>
                    4. Peraturan Menteri Pendidikan Dan Kebudayaan Republik Indonesia nomor 3 Tahun 2020 Tentang Standar
                    Nasional Pendidikan Tinggi;<br>
                    5. Surat Keputusan Rektor Nomor: 292/UNDIPA/A1/III/2021 tentang Peraturan Akademik Universitas Dipa
                    Makassar<br>
                    6. Surat Keputusan Ketua Yayasan Dipanegara Nomor: 575/YD/ST/II/2021 Tentang Pengangkatan Rektor
                    periode 2021-2025
                </td>
            </tr>
        </table>

        <div class="title">MEMUTUSKAN:</div>
        <table class="no-border">
            <tr valign="top">
                <td width="100">Menetapkan</td>
                <td width="5">:</td>
                <td align="justify">
                    KEPUTUSAN REKTOR TENTANG PENGANGKATAN DOSEN PEMBIMBING SKRIPSI
                </td>
            </tr>
            <tr valign="top">
                <td width="100">Kesatu</td>
                <td width="5">:</td>
                <td align="justify">
                    Menunjuk dan mengangkat Dosen Pembimbing Skripsi sebagai berikut :<br>
                    1. {{ $data['pembimbing1'] }} (Pembimbing I)<br>
                    2. {{ $data['pembimbing2'] }} (Pembimbing II)<br><br>

                    Bagi Mahasiswa :<br>
                    <table class="no-border">
                        <tr>
                            <td width="150">Stambuk</td>
                            <td>Nama Mahasiswa</td>
                        </tr>
                        <tr>
                            <td>{{ $data['nim'] }}</td>
                            <td>{{ $data['nama'] }}</td>
                        </tr>
                        @if ($data['nim_partner'])
                            <tr>
                                <td>{{ $data['nim_partner'] }}</td>
                                <td>{{ $data['nama_partner'] }}</td>
                            </tr>
                        @endif
                    </table>
                    Dengan Judul : {{ $data['judul'] }}
                </td>
            </tr>
            <tr valign="top">
                <td width="100">Kedua</td>
                <td width="5">:</td>
                <td align="justify">
                    Bahwa Pembimbingan Tersebut, mulai tanggal {{ $tanggal }} sampai tanggal {{ $tanggal_akhir }}.
                </td>
            </tr>
            <tr valign="top">
                <td width="100">Ketiga</td>
                <td width="5">:</td>
                <td align="justify">
                    Segala biaya yang dikeluarkan sehubungan dengan Surat Keputusan ini dibebankan pada Dana Pembayaran
                    Tugas Akhir/Skripsi;
                </td>
            </tr>
            <tr valign="top">
                <td width="100">Keempat</td>
                <td width="5">:</td>
                <td align="justify">
                    Surat Keputusan ini berlaku mulai tanggal ditetapkannya dan apabila ditemukan kekeliruan di dalamnya
                    akan dilakukan perbaikan sebagaimana mestinya.
                </td>
            </tr>
        </table>

        <div class="ttd">
            DITETAPKAN DI : MAKASSAR<br>
            <u>PADA TANGGAL : {{ $tanggal }}</u><br>
            Rektor<br><br><br><br>
            <u>Dr. Y. Johny Wijaya Soelikno, SE., MM.</u>
        </div>

        <div class="tembusan">
            Tembusan Kepada Yth :<br>
            1. Ketua Yayasan Pendidikan Dipanegara<br>
            2. Wakil Rektor<br>
            3. Kaprodi Teknik Informatika<br>
            4. Mahasiswa yang bersangkutan untuk diketahui
        </div>
    </div>
</body>

</html>
