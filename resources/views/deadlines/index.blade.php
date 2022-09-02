@extends('layouts.app')

@push('title')
    List
@endpush

@section('content')
<div class="row">
    <div class="col-12">

        <div class="d-flex justify-content-end mb-2">
            <a href="{{ route('deadline.set') }}" class="btn btn-primary">Set New Deadline</a>
        </div>
        <div class="card">
            <div class="card-body">
                <table id="datatable" class="table  table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                    <tr>
                        <th>Type</th>
                        <th>Start</th>
                        <th>End</th>
                        <th class="text-center">Action</th>
                    </tr>
                    </thead>


                    <tbody>
                        @foreach ($deadlines as $deadline)
                            <tr>
                                <td>{{ title_case($deadline->student_type) }}</td>
                                <td>{{ $deadline->start_date->format('dS M Y') }}</td>
                                <td>{{ $deadline->end_date->format('dS M Y') }}</td>
                                <td class="text-center">
                                    <a href="javascript:void(0)" onclick="$('#{{ $deadline->id }}').submit()" class="btn btn-danger waves-effect waves-light btn-sm"><i class="ri-delete-bin-2-line"></i></a>

                                    <form id="{{ $deadline->id }}" action="{{ route('deadline.delete', $deadline->id) }}" method="post">@csrf @method('DELETE') </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->
@endsection


@push('script')
    <!-- Required datatable js -->
    <script src="{{ asset('assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Responsive examples -->
    <script src="{{ asset('assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>

    <script>
        // $('#datatable').DataTable();
    </script>

    <!-- Datatable init js -->
    <script src="{{ asset('assets/js/pages/datatables.init.js') }}"></script>

@endpush

@push('link')
    <!-- DataTables -->
    <link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/libs/datatables.net-select-bs4/css//select.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- Responsive datatable examples -->
    <link href="{{ asset('assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />

@endpush
