@extends('layouts.app')

@push('title')
    List
@endpush

@section('content')
<div class="row">
    <div class="col-12">

        <div class="text-right mb-2">
            <a href="{{ route('groups.create') }}" class="btn btn-primary">Add new group</a>
        </div>

        <div class="card">
            <div class="card-body">

                <table id="datatable" class="table  table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                    </thead>


                    <tbody>
                        @foreach ($roles as $role)
                            <tr>
                                <td>{{ $role->proper_name }}</td>
                                <td class="text-center">
                                    @if ($role->deleted_at)
                                        <span class="badge badge-pill badge-danger">Inactive</span>
                                    @else
                                        <span class="badge badge-pill badge-primary">Active</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if ($role->deleted_at)
                                        <a href="javascript:void(0)" onclick="$('#{{ $role->name }}').submit()" class="btn btn-info waves-effect waves-light btn-sm"><i class=" ri-arrow-left-right-line"></i></a>
                                    @else
                                        <a href="{{ route('groups.edit', $role->name) }}" class="btn btn-success waves-effect waves-light btn-sm"><i class="ri-shield-keyhole-line"></i></a>
                                        <a href="{{ route('groups.edit', $role->name) }}" class="btn btn-warning waves-effect waves-light btn-sm"><i class="ri-edit-line"></i></a>
                                        <a href="javascript:void(0)" onclick="$('#{{ $role->name }}').submit()" class="btn btn-danger waves-effect waves-light btn-sm"><i class="ri-delete-bin-line"></i></a>

                                    @endif
                                    <form id="{{ $role->name }}" action="{{ route('groups.destroy', $role->name) }}" method="post">@csrf @method('DELETE')</form>
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
