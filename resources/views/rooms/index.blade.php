@extends('layouts.app')

@push('title')
    List
@endpush

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-end mb-2">
            <a href="{{ route('rooms.create') }}" class="btn btn-primary">Add New Room</a>
        </div>
        <div class="card">
            <div class="card-body">

                <table id="datatable" class="table  table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Block</th>
                        <th>Capacity</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                    </thead>


                    <tbody>
                        @foreach ($rooms as $room)
                            <tr>
                                <td>{{ $room->name }}</td>
                                <td>{{ $room->side->block->name }}</td>
                                <td>{{ $room->capacity }}</td>
                                <td class="text-center">
                                    @if ($room->deleted_at)
                                        <span class="badge badge-pill badge-danger">Inactive</span>
                                    @else
                                        <span class="badge badge-pill badge-primary">Active</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if ($room->deleted_at)
                                        <a href="javascript:void(0)" onclick="$('#{{ $room->slug }}').submit()" class="btn btn-info waves-effect waves-light btn-sm"><i class=" ri-store-3-line"></i></a>
                                    @else
                                        <a href="{{ route('rooms.edit', $room->slug) }}" class="btn btn-warning waves-effect waves-light btn-sm"><i class="ri-edit-line"></i></a>
                                        <a href="javascript:void(0)" onclick="$('#{{ $room->slug }}').submit()" class="btn btn-danger waves-effect waves-light btn-sm"><i class="ri-delete-bin-line"></i></a>

                                    @endif
                                    <form id="{{ $room->slug }}" action="{{ route('rooms.destroy', $room->slug) }}" method="post">@csrf @method('DELETE')</form>
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
