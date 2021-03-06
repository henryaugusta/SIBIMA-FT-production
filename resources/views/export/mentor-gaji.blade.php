@extends('layout.outsider')
@section('title')
View Data Mentor
@endsection
@section('js_addon')

<script type="text/javascript" src="https://cdn.datatables.net/v/bs4-4.1.1/jszip-2.5.0/dt-1.10.23/b-1.6.5/b-colvis-1.6.5/b-flash-1.6.5/b-html5-1.6.5/b-print-1.6.5/cr-1.5.3/r-2.2.7/sb-1.0.1/sp-1.2.2/datatables.min.js">
</script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>


<script>
    $('.btn-reset').on('click', function() {
        var mentor_id = $(this).attr('mentor');
        var mentor_name = $(this).attr('data-name');
        $('input[id="mentor_id"]').val(mentor_id);
        $('#mentor_name').val(mentor_name);
    });

    $('#dataTable').DataTable({
        dom: 'Bfrtip',
        "paging": false,
        "ordering": false,
        "info": false,
        "searching": false,
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
        ]
    });

    var paginate = {{request()->route('paginate')}}
    $('#selectPaginate').val(paginate);
</script>

@endsection
@section('content')
@include('layout.dashboard.alert_flash')

<div class="card card-block">
    <h4 class="card-title">Penggajian Mentor</h4>
    <h6 class="text-muted">Butuh Bantuan Teknis ? Hubungi Helpdesk IT Support SIBIMA <a href="">Disini</a></h6>
    <hr>
    <form method="get">
        <div class="row">
            <div class="col-md-9 col-sm-12 col-xs-12">
                <div class="row">
                    <div class="col-xs-12 col-md-3">
                        <div class="form-group">
                            <select class="form-control" name="jk">
                                <option selected value="">Select Filter</option>
                                <option value="1" {{ $jk == 1 ? "selected" : "" }}>Laki-Laki</option>
                                <option value="2" {{ $jk == 2 ? "selected" : "" }}>Perempuan</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-6">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Filter</button>
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="">Menampilkan {{ request()->paginate }} data</label>
                            <select class="form-control" name="paginate" id="selectPaginate" onchange="this.form.submit()">
                                <option value="">Jumlah Data per Halaman</option>
                                <option value="10">10</option>
                                <option value="20">20</option>
                                <option value="30">30</option>
                                <option value="40">40</option>
                                <option value="50">50</option>
                                <option value="60">60</option>
                                <option value="70">70</option>
                                <option value="80">80</option>
                                <option value="90">90</option>
                                <option value="100">100</option>
                                <option value="99999999">Semua Halaman</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-12 col-xs-12 float-md-right float-sm-none row">
                <div class="col-12">
                    <div class="form-group">
                        <input type="text" class="search form-control" placeholder="Search by NIM/Nama/Fakultas" name="search" value="{{ $search or "" }}">
                    </div>
                </div>
            </div>
        </div>
    </form>

    <div class="table-responsive">
        <table id="dataTable" class="table table-sm">
            <thead>
                <tr>
                    <th>#</th>
                    <th>NIM</th>
                    <th>Nama</th>
                    <th>JK</th>
                    <th>Fakultas</th>
                    <th>Line</th>
                    <th>Kontak</th>
                    <th>As Mentor</th>
                    <th>As Asisten</th>
                </tr>
            </thead>
            <tbody>
                <?php $skipped = ($list_mentor->currentPage() * $list_mentor->perPage())
                    - $list_mentor->perPage(); ?>
                @foreach($list_mentor as $mentor)
                <tr>
                    <td>{{ $skipped + $loop->iteration }}</td>
                    <td>{{ $mentor->nim }}</td>
                    <td>{{ $mentor->nama }}</td>
                    <td>{{ $mentor->getJK() }}</td>
                    <td>{{ $mentor->fakultas }}</td>
                    <td>{{ $mentor->line_id }}</td>
                    <td>{{ $mentor->no_telp }}</td>
                    <td class="text-xs-center">{{ $mentor->getKelompok->count() }}</td>
                    <td class="text-xs-center">{{ $mentor->getKelompokAsisten->count() }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <hr>
    @if($jk != 0)
    {{ $list_mentor
				->appends(['search' => $search, 'jk' => $jk])
				->links('vendor.pagination.bootstrap-4')
			}}
    @else
    {{ $list_mentor
				->appends(['search' => $search])
				->links('vendor.pagination.bootstrap-4')
			}}
    @endif

</div>


@endsection