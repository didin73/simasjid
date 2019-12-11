@include('layouts.header')
@include('layouts.navbar')
<!-- Main Content -->
<!-- <script type="text/javascript" src="{{asset('public/dist/assets/js/page/bootstrap-modal.js')}}"></script> -->
<?php

use Carbon\Carbon;

Carbon::setLocale('id');
//hide untuk selain sekretaris dan ketua
$inside_pengelola = in_array($anggota->id, $list_pengelola);
?>
<div class="main-content">
    <section class="section">
        <div class="row">
            <div>
                <ol class="breadcrumb float-sm-left" style="margin-bottom: 10px; margin-left: 15px;">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="fas fa-mosque"></i> Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Manajemen Aset</a></li>
                    <li class="breadcrumb-item active">Usulan</li>
                </ol>
            </div>
        </div>
        <div class="section-header">
            <div>
                <h1><i class="fa fa-lightbulb"></i> Usulan Barang</h1>
                <div>
                    <p style="padding: 10px; margin-bottom: 0px;">Usulan Barang berisi kumpulan usulan untuk barang aset yang telah dibuat oleh Takmir dan Remas. Usulan dapat dibuat dengan memilih dari katalog yang tersedia atau dengan membuat usulan non-katalog.</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="section-body" style="margin-bottom: 10px;">
                    <!-- pencarian -->
                    <div class="card" style="margin-bottom: 0px;">
                        <button class="btn btn-info" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne" style="margin: 5px; width:100%;">
                            <i class="fa fa-filter"></i> Filter Data
                        </button>
                        <div id="collapseOne" class="collapse" aria-labelledby="headingOne">
                            <div class="card-body" style="padding: 10px auto;">
                                <!-- Pakai JQuery -->
                                <div class="column-search"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="section-body" style="min-height: 300px;">
                    <div class="col-12" style="margin-left: 0px; margin-top: 0px; margin-bottom:20px; padding: 0px;">
                        <a href="#" class="btn btn-lg btn-info btn-primary" data-toggle="modal" data-target="#tambahModal"><i class="fas fas fa-plus"></i> Buat Usulan dari Katalog</a>
                        <a href="#" class="btn btn-lg btn-info btn-primary" data-toggle="modal" data-target="#tambahModal"><i class="fas fas fa-plus"></i> Buat Usulan Non-Katalog</a>
                    </div>
                    <table id="table_id" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th class="dt-center">ID</th>
                                <th class="dt-center">Jenis Usulan</th>
                                <th class="dt-center">Nama Barang</th>
                                <th class="dt-center">Kategori</th>
                                <th class="dt-center" style="width: 50px;padding-right: 5px;padding-left: 5px;height: 50px;">Jumlah</th>
                                <th class="dt-center">Harga Satuan</th>
                                <th class="dt-center">Harga Total</th>
                                <th class="dt-center">Status Usulan</th>
                                <th class="dt-center">Status Pembelian</th>
                                <th class="dt-center" style="min-width: 5em;">Action</th>
                                @if($inside_pengelola)
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($list_usulan as $usulan)
                            <tr>
                                <td>{{ $usulan->id }}</td>
                                <td> {{ $usulan->jenis_usulan }} </td>
                                <td>
                                    @if($usulan->jenis_usulan == "Katalog")
                                    {{ $usulan->katalog->nama }}
                                    @else
                                    {{ $usulan->nama }}
                                    @endif
                                </td>
                                <td>
                                    @if($usulan->jenis_usulan == "Katalog")
                                    {{ $usulan->katalog->kategori->nama }}
                                    @else
                                    -
                                    @endif
                                </td>
                                <td class="dt-center" style="width: 50px;padding-right: 5px;padding-left: 5px;height: 50px;">{{ $usulan->jumlah }}</td>
                                <!-- <td>{{ $usulan->harga }}</td>
                                <td>{{ $usulan->harga * $usulan->jumlah }}</td> -->
                                <td style="min-width: 7em;" class="harga" data-a-sign="Rp. " data-a-dec="," data-a-sep=".">{{ $usulan->harga_usulan }}</td>
                                <td style="min-width: 7em;" class="harga" data-a-sign="Rp. " data-a-dec="," data-a-sep=".">{{ $usulan->harga_usulan * $usulan->jumlah }}</td>
                                <!-- <td>{{ $usulan->updated_at->diffForHumans() }}</td> -->
                                <td class="font-status">{{ $usulan->status_usulan }}</td>
                                @if(!empty($usulan->pembelian))
                                <td class="font-status">{{ $usulan->pembelian->status_pembelian }}</td>
                                @else
                                <td class="font-status">Tidak Terdaftar</td>
                                @endif
                                <td class="dt-center">
                                    <!-- <div class="btn-group mb-3" role="group" aria-label="Basic example" style="padding-left: 20px;"> -->
                                    <a href="#" class="open-detail btn btn-icon btn-sm btn-info" data-toggle="modal" data-id="{{ $usulan->id }}" data-target="#detailModal" style="margin-bottom: 2px; width:100%"><i class="fas fa-glasses"></i> Detail</a>
                                    @if( ( $inside_pengelola || $usulan->id_pengusul == $anggota->id ) && ( $usulan->status_usulan == "Menunggu Keputusan" ) )
                                    <a href="#" class="open-edit btn btn-icon btn-sm btn-warning" data-toggle="modal" data-id="{{ $usulan->id }}" data-target="#editModal" style="margin-bottom: 2px; width:100%"><i class="fas fa-edit"></i></i> Edit</a>
                                    <a href="#" class="open-delete btn btn-icon btn-sm btn-danger" data-toggle="modal" data-id="{{ $usulan->id }}" data-target="#deleteModal" style="margin-bottom: 2px; width:100%"><i class="fas fa-trash"></i> Hapus</a>
                                    @endif
                                    @if( !empty($usulan->pembelian) )
                                    <a href="{{ route('home').'/aset/pembelian/detail/'.$usulan->pembelian->id }}" class="btn-icon btn btn-sm btn-secondary" style="margin-bottom: 2px; width:100%"><i class="fas fa-shopping-bag"></i> Pembelian</a>
                                    @endif
                                    <!-- </div> -->
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
    <!-- Modal Detail -->
    <div class="modal fade" tabindex="-1" role="dialog" id="tambahModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Usulan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="{{ route('usulanCreate') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group row">
                            <label for="pengusul" class="col-md-4 col-form-label text-md-right">Pengusul</label>
                            <div class="col-md-6">
                                <input id="pengusul" type="text" class="form-control" name="pengusul" value="{{$anggota->nama}}" readonly disabled>
                                <input id="id_pengusul" type="text" class="form-control" name="id_pengusul" value="{{$anggota->id}}" readonly hidden>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="nama" class="col-md-4 col-form-label text-md-right">Nama Barang</label>
                            <div class="col-md-6">
                                <input id="nama" type="text" class="form-control" name="nama" placeholder="Nama Barang Usulan" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="jenis_aset" class="col-md-4 col-form-label text-md-right">Jenis Aset</label>
                            <div class="col-md-6">
                                <select class="form-control" id="jenis_aset" name="jenis_aset" required>
                                    <option>Pilih Jenis Aset</option>
                                    <option value=1>Aset Tetap</option>
                                    <option value=2>Persediaan</option>
                                    <option value=3>Buku</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="id_kategori" class="col-md-4 col-form-label text-md-right">Kategori Aset</label>
                            <div class="col-md-6">
                                <select class="form-control" id="id_kategori" name="id_kategori" required>
                                    <option>Pilih Jenis Aset Dahulu</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="jumlah" class="col-md-4 col-form-label text-md-right">Jumlah</label>
                            <div class="col-md-6">
                                <input id="jumlah" type="number" class="form-control" name="jumlah" placeholder="Jumlah" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="harga" class="col-md-4 col-form-label text-md-right">Harga Satuan</label>
                            <div class="col-md-6">
                                <input id="harga" type="number" class="form-control" name="harga" placeholder="Perkiraan Harga Satuan" data-a-dec="," data-a-sep="." required>
                            </div>
                        </div>
                        <!-- <input type="text" id="usulanId" name="usulanId" value="" hidden/> -->
                    </div>
                    <div class="modal-footer bg-whitesmoke br">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Buat Usulan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Delete -->
<div class="modal fade" tabindex="-1" role="dialog" id="deleteModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Hapus Usulan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <img src="{{ route('home') }}/public/dist/assets/img/svg/trash.svg" id="detailFoto" class="mx-auto d-block" alt="hapus image" style="width:150px; height:150px;overflow: hidden;">

                <h5 align="center">Apakah Anda yakin ingin menghapus usulan ini?</h5>
            </div>
            <div class="modal-footer bg-whitesmoke br">
                <form action="{{ route('usulanDelete') }}" method="post">
                    @csrf
                    <input type="text" id="usulanId" name="usulanId" value="" />
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak, Batalkan</button>
                    <input type="submit" value="Ya, Hapus" class="btn btn-danger" />
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal Edit -->
<div class="modal fade" tabindex="-1" role="dialog" id="editModal">
    <div class="modal-dialog" role="document">
        <form method="POST" action="{{ route('usulanEdit') }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Usulan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input id="id_pengelola" type="text" class="form-control" name="id_pengelola" value="{{$anggota->id}}" readonly hidden>
                    <table style="width:90%; margin: auto;">
                        <tbody>
                            <tr>
                                <th scope="row">Nama Usulan Aset</th>
                                <td><input class="form-control" type="text" id="editNama" name="editNama" /></td>
                            </tr>
                            <tr>
                                <th scope="row">Jenis Aset</th>
                                <td><select id="editJenis" name="editJenis" class="form-control select">
                                        <option value=1>Aset Tetap</option>
                                        <option value=2>Persediaan</option>
                                        <option value=3>Buku</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Kategori Aset</th>
                                <td><select id="editKategori" name="editKategori" class="form-control select">
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Jumlah</th>
                                <td><input type="number" id="editJumlah" name="editJumlah" class="form-control"></td>
                            </tr>
                            <tr>
                                <th scope="row">Harga Satuan</th>
                                <td><input type="number" id="editHarga" name="editHarga" class="form-control" /></td>
                            </tr>
                            <!-- <tr>
                                <th scope="row">Dibuat</th>
                                <td>
                                    <input type='text' id="editDibuat" class="form-control" />
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </td>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Diperbarui</th>
                                <td><input type='text' id="editDiperbarui" class="form-control" />
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Dibuat oleh</th>
                                <td><input type='text' id="editDibuatOleh" class="form-control" readonly disabled /></td>
                            </tr>
                            <tr>
                                <th scope="row">Diperbarui oleh</th>
                                <td><input type='text' id="editDiperbaruiOleh" class="form-control" readonly disabled /></td>
                            </tr> -->
                            <!-- <tr>
                                <th scope="row">Status</th>
                                <td>
                                    <select id="editStatus" name="editStatus" class="form-control select">
                                        <option value="Ditolak">Ditolak</option>
                                        <option value="Diterima">Diterima</option>
                                        <option value="Menunggu Keputusan">Menunggu Keputusan</option>
                                    </select>
                                </td>
                            </tr> -->
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <input type="text" id="usulanId" name="usulanId" value="" hidden />
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batalkan</button>
                    <input type="submit" value="Konfirmasi Edit" class="btn btn-warning" />
                </div>
            </div>
        </form>
    </div>
</div>
<!-- Modal Detail -->
<div class="modal fade" tabindex="-1" role="dialog" id="detailModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Usulan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table style="width:90%; margin: auto;">
                    <tbody>
                        <tr>
                            <th scope="row">Jenis Usulan</th>
                            <td id="detailJenis"></td>
                        </tr>
                        <tr>
                            <th scope="row">Nama Barang</th>
                            <td id="detailNama"></td>
                        </tr>
                        <tr>
                            <th scope="row">Kategori</th>
                            <td id="detailKategori"></td>
                        </tr>
                        <tr>
                            <th scope="row">Jumlah</th>
                            <td id="detailJumlah"></td>
                        </tr>
                        <tr>
                            <th scope="row">Harga Satuan</th>
                            <td><span id="detailHarga" data-a-dec="," data-a-sep="."></span></td>
                        </tr>
                        <tr>
                            <th scope="row">Total Harga</th>
                            <td><span id="detailTotal" data-a-dec="," data-a-sep="."></span></td>
                        </tr>
                        <tr>
                            <th scope="row">Dibuat</th>
                            <td id="dibuat"></td>
                        </tr>
                        <tr>
                            <th scope="row">Diperbarui</th>
                            <td id="diperbarui"></td>
                        </tr>
                        <tr>
                            <th scope="row">Dibuat oleh</th>
                            <td id="dibuatOleh"></td>
                        </tr>
                        <tr>
                            <th scope="row">Diperbarui oleh</th>
                            <td id="diperbaruiOleh"></td>
                        </tr>
                        <tr>
                            <th scope="row">Keterangan</th>
                            <td id="detailKeterangan"></td>
                        </tr>
                        <tr>
                            <th scope="row">Status Usulan</th>
                            <td id="detailStatusUsulan" class="font-status"></td>
                        </tr>
                        <tr>
                            <th scope="row">Status Pembelian</th>
                            <td id="detailStatusPembelian" class="font-status">

                            </td>
                        </tr>
                    </tbody>
                </table>

            </div>
            <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button> -->
                <a id="linkView" href="" class="btn btn-info"><i class="fas fas fa-glasses"></i> Detail Lengkap</a>
                <!-- <input type="text" id="usulanId" name="usulanId" value="" /> -->
            </div>
        </div>
    </div>
</div>

<!-- SCRIPT -->
<script type="text/javascript">
    //JS halaman aktif
    document.getElementById("usulan-link").classList.add("active");
    document.getElementById("dropdown-aset").classList.add("active");
</script>

<script type="text/javascript">
    function status_colorized() {
        //status aktif bold
        $(".font-status").css('font-weight', 'bold');
        //ganti warna status
        $(".font-status").filter(function() {
            return $(this).text() === 'Pembelian Gagal';
        }).css('color', 'red');
        $(".font-status").filter(function() {
            return $(this).text() === 'Tidak Terdaftar';
        }).css('color', 'red');

        //warna biru
        $(".font-status").filter(function() {
            return $(this).text() === 'Dalam Proses';
        }).css('color', 'blue');

        //warna hijau
        $(".font-status").filter(function() {
            return $(this).text() === 'Disetujui';
        }).css('color', 'green');
        $(".font-status").filter(function() {
            return $(this).text() === 'Selesai';
        }).css('color', 'green');

        //warna merah
        $(".font-status").filter(function() {
            return $(this).text() === 'Ditolak';
        }).css('color', 'red');
        $(".font-status").filter(function() {
            return $(this).text() === 'Gagal';
        }).css('color', 'red');

        //status kuning
        $(".font-status").filter(function() {
            return $(this).text() === 'Menunggu Keputusan';
        }).css('color', '#FFC300');
        $(".font-status").filter(function() {
            return $(this).text() === 'Menunggu Barang Diterima';
        }).css('color', '#FFC300');

    }

    //document function
    $(document).ready(function() {
        $(".custom-select").css('width', '82px');
        status_colorized();
        //autonumeric 
        $('.harga').autoNumeric('init'); //harga
        $('#detailHarga').autoNumeric('init'); //autonumeric detailharga
        $('#detailTotal').autoNumeric('init'); //autonumeric detailtotal
        //onchange select jenis aset, show opsi kategori
        $('#jenis_aset').change(function() {
            var jenis = $(this).val();
            if (jenis) {
                $.ajax({
                    type: "get",
                    url: "{{ route('home') }}/aset/kategori/get/" + jenis,
                    success: function(res) {
                        if (res) {
                            $("#id_kategori").empty();
                            $("#id_kategori").append('<option>Pilih Kategori</option>');
                            $.each(res, function(key, value) {
                                $("#id_kategori").append('<option value="' + key + '">' + value + '</option>');
                            });
                        }
                    }
                });
            }
        });
        //JQuery Pencarian Berdasarkan Kriteria
        $('#table_id').DataTable({
            "scrollX": true,
            language: {
                search: "Cari di tabel:",
                zeroRecords: "Data tidak tersedia",
            },
            //kriteria column 0 nama tipe input
            initComplete: function() {
                //kriteria column 0 nama tipe select
                this.api().columns([1]).every(function() {
                    var column = this;
                    var select = $('<select class="form-control select" style="margin-bottom:10px;"><option value="">Filter Jenis Usulan</option></select>')
                        // .appendTo($(column.header()).empty())
                        .appendTo($(".column-search"))
                        .on('change', function() {
                            var val = $.fn.dataTable.util.escapeRegex(
                                $(this).val()
                            );
                            column
                                .search(val ? '^' + val + '$' : '', true, false)
                                .draw();
                        });
                    column.data().unique().sort().each(function(d, j) {
                        select.append('<option value="' + d + '">' + d + '</option>')
                    });
                });
                this.api().columns([2]).every(function() {
                    var column = this;
                    var input = $('<input class="form-control" placeholder="Filter Nama Barang" style="margin-bottom:10px;"></input>')
                        .appendTo($(".column-search"))
                        .on('keyup change clear', function() {
                            if (column.search() !== this.value) {
                                column
                                    .search(this.value)
                                    .draw();
                            }
                        });
                });
                this.api().columns([3]).every(function() {
                    var column = this;
                    var select = $('<select class="form-control select2" style="margin-bottom:10px; width:100%;"><option value="">Filter Kategori</option></select>')
                        // .appendTo($(column.header()).empty())
                        .appendTo($(".column-search"))
                        .on('change', function() {
                            var val = $.fn.dataTable.util.escapeRegex(
                                $(this).val()
                            );
                            column
                                .search(val ? '^' + val + '$' : '', true, false)
                                .draw();
                        });
                    column.data().unique().sort().each(function(d, j) {
                        select.append('<option value="' + d + '">' + d + '</option>')
                    });
                });
                this.api().columns([7]).every(function() {
                    var column = this;
                    var select = $('<select class="form-control select" style="margin-top:10px; width:100%;"><option value="">Filter Status Usulan</option></select>')
                        // .appendTo($(column.header()).empty())
                        .appendTo($(".column-search"))
                        .on('change', function() {
                            var val = $.fn.dataTable.util.escapeRegex(
                                $(this).val()
                            );
                            column
                                .search(val ? '^' + val + '$' : '', true, false)
                                .draw();
                        });
                    column.data().unique().sort().each(function(d, j) {
                        select.append('<option value="' + d + '">' + d + '</option>')
                    });
                });
                this.api().columns([8]).every(function() {
                    var column = this;
                    var select = $('<select class="form-control select" style="margin-top:10px; width:100%;"><option value="">Filter Status Pembelian</option></select>')
                        // .appendTo($(column.header()).empty())
                        .appendTo($(".column-search"))
                        .on('change', function() {
                            var val = $.fn.dataTable.util.escapeRegex(
                                $(this).val()
                            );
                            column
                                .search(val ? '^' + val + '$' : '', true, false)
                                .draw();
                        });
                    column.data().unique().sort().each(function(d, j) {
                        select.append('<option value="' + d + '">' + d + '</option>')
                    });
                });
            }
        });
    });

    $(document).on("click", ".open-delete", function() {
        /* passing data dari view button detail ke modal */
        var thisDataUsulan = $(this).data('id');
        $(".modal-footer #usulanId").val(thisDataUsulan);
    });

    // onclick btn edit, show modal
    $(document).on("click", ".open-edit", function() {
        /* passing data dari view button detail ke modal */
        var thisDataUsulan = $(this).data('id');
        $(".modal-footer #usulanId").val(thisDataUsulan);
        var linkDetail = "{{ route('home') }}/aset/usulan/view/" + thisDataUsulan;
        $.get(linkDetail, function(data) {
            //deklarasi var obj JSON data detail anggota
            var obj = data;
            var kategori = obj.kategori;
            var pengusul = obj.pengusul;
            var pengelola = obj.pengusul;
            // ganti elemen pada dokumen html dengan hasil data json dari jquery
            $("#editNama").val(obj.nama);
            $("#editJenis").val(obj.id_jenis);
            $("#editKategori").ready(function() {
                var jenis = $(editJenis).val();
                if (jenis) {
                    $.ajax({
                        type: "get",
                        url: "{{ route('home') }}/aset/kategori/get/" + jenis,
                        success: function(res) {
                            if (res) {
                                $.each(res, function(key, value) {
                                    $("#editKategori").append('<option value="' + key + '">' + value + '</option>');
                                });
                                $("#editKategori").val(kategori.id);
                            }
                        }
                    });
                }
            });
            $("#editJenis").change(function() {
                var jenis = $(editJenis).val();
                if (jenis) {
                    $.ajax({
                        type: "get",
                        url: "{{ route('home') }}/aset/kategori/get/" + jenis,
                        success: function(res) {
                            if (res) {
                                $("#editKategori").empty();
                                $("#editKategori").append('<option>Pilih Kategori</option>');
                                $.each(res, function(key, value) {
                                    $("#editKategori").append('<option value="' + key + '">' + value + '</option>');
                                });
                            }
                        }
                    });
                }
            });

            $("#editJumlah").val(obj.jumlah);
            $("#editHarga").val(obj.harga);
            // $("#editDibuat").val(obj.created_at);
            // $("#editDiperbarui").val(obj.updated_at);
            // $("#editDibuatOleh").val(pengusul.nama);
            // $("#editDiperbaruiOleh").val(pengelola.nama);
            $("#editStatus").val(obj.status_usulan);
            $('#editHarga').autoNumeric('update', {
                aSign: 'Rp. '
            }); //autonumeric detailharga

            //base root project url + url dari db
            // var link_foto = "{{ route('home') }}/" + obj.link_foto;
            // $("#detailFoto").attr('src', link_foto);
            // console.log(link_foto);
        });
    });

    // onclick btn detail, show modal
    $(document).on("click", ".open-detail", function() {
        /* passing data dari view button detail ke modal */
        var thisDataUsulan = $(this).data('id');
        $(".modal-footer #usulanId").val(thisDataUsulan);
        var linkView = "{{ route('home') }}/aset/usulan/view/" + thisDataUsulan;
        $("#linkView").attr("href", linkView);
        var linkDetail = "{{ route('home') }}/aset/usulan/detail/" + thisDataUsulan;
        $.get(linkDetail, function(data) {
            //deklarasi var obj JSON data detail anggota
            var obj = data;
            if (obj.jenis_usulan == "Katalog") {
                var katalog = obj.katalog;
                var kategori = katalog.kategori;
            }
            //deklarasi variabel yang ada dalam objek
            var pengelola = obj.pengelola;
            var pengusul = obj.pengusul;
            // ganti elemen pada dokumen html dengan hasil data json dari jquery
            $("#detailJenis").html(obj.jenis_usulan);
            if (obj.jenis_usulan == "Katalog") {
                $("#detailNama").html(katalog.nama);
                $("#detailKategori").html(kategori.nama);
            } else {
                $("#detailNama").html(obj.nama);
                $("#detailKategori").html('-');
            }
            $("#detailJumlah").html(obj.jumlah);
            $("#detailHarga").html(obj.harga_usulan);
            $("#detailTotal").html(obj.harga_usulan * obj.jumlah);
            $("#dibuat").html(obj.dibuat);
            $("#diperbarui").html(obj.diperbarui);
            $("#dibuatOleh").html(pengusul.nama);
            if (pengelola == null) {
                $("#diperbaruiOleh").html('-');
            } else {
                $("#diperbaruiOleh").html(pengelola.nama);
            }
            if (obj.keterangan == null) {
                $("#detailKeterangan").html('-');
            } else {
                $("#detailKeterangan").html(obj.keterangan);
            }
            $('#detailHarga').autoNumeric('update', {
                aSign: 'Rp. '
            }); //autonumeric detailharga
            $('#detailTotal').autoNumeric('update', {
                aSign: 'Rp. '
            });
            $("#detailStatusUsulan").html(obj.status_usulan);
            if (obj.pembelian != null) {
                var pembelian = obj.pembelian;
                $("#detailStatusPembelian").html(pembelian.status_pembelian);
            } else {
                $("#detailStatusPembelian").html("Tidak Terdaftar");
            }
            status_colorized();
            //autonumeric detailtotal
            //base root project url + url dari db
            // var link_foto = "{{ route('home') }}/" + obj.link_foto;
            // $("#detailFoto").attr('src', link_foto);
            // console.log(link_foto);


        });
    });
</script>
@include('layouts.footer')