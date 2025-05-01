@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">Daftar Barang</h3>
            <div class="card-tools">

                <button onclick="modalAction('{{ url('/barang/import') }}')" class="btn btn-info">Import Barang</button>

                <a href="{{ url('/barang/export_excel') }}" class="btn btn-primary"><i class="fa fa-fileexcel"></i>
                    Export Barang</a>

                <a href="{{ url('/barang/export_pdf') }}" class="btn btn-warning"><i class="fa fa-filepdf"></i>
                    Export Barang PDF</a>

                <a href="{{ url('/barang/create') }}" class="btn btn-primary">Tambah Data (Ajax)</a>
            </div>
        </div>

        <!-- Untuk Filter Data -->
        <div id="filter" class="form-horizontal filter-date p-2 border-bottom mb-2">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group form-group-sm row text-sm mb-0">
                        <label for="filter_kategori" class="col-md-1 col-form-label">Filter</label>
                        <div class="col-md-3">
                            <select name="filter_kategori" class="form-control filter_kategori">
                                <option value="">- Semua -</option>
                                @foreach ($kategori as $l)
                                    <option value="{{ $l->Kategori_id }}">{{ $l->kategori_nama }}</option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">Kategori Barang</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <table class="table table-bordered table-sm table-striped table-hover" id="table-barang">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Harga Beli</th>
                    <th>Harga Jual</th>
                    <th>Kategori</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
    </div>

    <div id="myModal" class="modal fade animate shake" tabindex="-1" data-backdrop="static" data-keyboard="false"
        data-width="75%"></div>
@endsection

@push('js')
    <script>
        function modalAction(url = '') {
            $('#myModal').load(url, function() {
                $('#myModal').modal('show');
            });
        }

        var datUser;
        $(document).ready(function() {
            datUser = $('#table-barang').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ url('barang/list') }}",
                    type: "POST",
                    dataType: "json",
                    // Kirim Kategori_id sebagai parameter untuk filter
                    data: function(d) {
                        d.Kategori_id = $('.filter_Kategori').val();
                    }
                },
                columns: [{
                        data: "DT_RowIndex",
                        className: "text-center",
                        width: "5%",
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: "barang_kode",
                        className: "",
                        width: "10%"
                    },
                    {
                        data: "barang_nama",
                        className: "",
                        width: "25%"
                    },
                    {
                        data: "harga_beli",
                        className: "",
                        width: "10%",
                        render: function(data) {
                            return new Intl.NumberFormat('id-ID').format(data);
                        }
                    },
                    {
                        data: "harga_jual",
                        className: "",
                        width: "10%",
                        render: function(data) {
                            return new Intl.NumberFormat('id-ID').format(data);
                        }
                    },
                    {
                        data: "kategori.kategori_nama",
                        className: "",
                        width: "15%"
                    },
                    {
                        data: "aksi",
                        className: "text-center",
                        width: "15%",
                        orderable: false,
                        searchable: false
                    }
                ]
            });
            $('#table-barang_filter input').unbind().bind('keyup', function(e) {
                if (e.keyCode == 13) {
                    datUser.search(this.value).draw();
                }
            });

            $('.filter_kategori').change(function() {
                datUser.draw();
            });
        });
    </script>
@endpush
