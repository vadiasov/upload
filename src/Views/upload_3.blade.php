@extends('layouts.admin.main')

@section('title', 'Upload Files')

@section('css')
    <!-- DataTables -->
    <link rel="stylesheet"
          href="{{ asset('admin/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
     folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{ asset('admin/dist/css/skins/_all-skins.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dropzone.css') }}">
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>{{ $config['pageHeader'] }}</h1>
            {{--<ol class="breadcrumb">--}}
                {{--<li><a href="{{ route('admin/albums') }}"><i class="fa fa-dashboard"></i> Albums</a></li>--}}
                {{--<li><a href="#">Add Arts</a></li>--}}
            {{--</ol>--}}
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-md-6">
                    <div class="box box-info">
                        <div class="box-header with-border" style="margin-bottom: 10px">
                            <h3 class="box-title">{{ $config['header'] . ': '}} <span
                                        style="color: #00c0ef">{{ $title }}</span></h3>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <form class="form-horizontal dropzone" method="post" enctype="multipart/form-data"
                              id="my-awesome-dropzone" style="margin: 10px">
                            <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                            <input type="hidden" name="path" value="{!! $config['path'] !!}">
                            <input type="hidden" name="db_table" value="{!! $config['db_table'] !!}">
                            <input type="hidden" name="column" value="{!! $config['column'] !!}">
                            <input type="hidden" name="id_item" value="{!! $config['id_item'] !!}">
                            <input type="hidden" name="id_item_2" value="{!! $config['id_item_2'] !!}">
                            <input type="hidden" name="albumId" value="{!! $albumId !!}">
                            <input type="hidden" name="trackId" value="{!! $trackId !!}">
                        </form>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <a href="{{ action($config['backUrl'], $albumId) }}" class="btn btn-default">Back</a>
                        </div>
                        <!-- /.box-footer -->
                    </div>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection

@section('js')
    <!-- DataTables -->
    <script src="{{ asset('admin/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('admin/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
    <!-- SlimScroll -->
    <script src="{{ asset('admin/bower_components/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
    <!-- FastClick -->
    <script src="{{ asset('admin/bower_components/fastclick/lib/fastclick.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('admin/dist/js/adminlte.min.js') }}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{ asset('admin/dist/js/demo.js') }}"></script>
    <!-- Dropzone.js -->
    <script src="{{ asset('js/dropzone.js') }}"></script>
    <!-- page script -->
    <script>
        $(function () {
            $('#example1').DataTable({
                'paging': true,
                'lengthChange': false,
                'searching': false,
                'ordering': true,
                'info': true,
                'autoWidth': false
            });
        })

        $("#my-awesome-dropzone").dropzone(
            {
                url: '{{ $config['rules']['url'] }}',
                acceptedFiles: '{{ $config['rules']['acceptedFiles'] }}',
                maxFilesize: '{{ $config['rules']['maxFilesize'] }}'
            });
    </script>
@endsection