@extends('layouts.app')

@push('title')
    List
@endpush

@section('content')
<div class="row">
    <div class="col-12">
        <div class="float-left">
            <form class="mb-4" action="{{ route('applications-list') }}" method="get">
                <div class="form-group">
                    <input type="text" value="{{ old('search', request()->search) }}" class="form-control" placeholder="Enter username" name="search">
                </div>

                <button type="submit" class="btn btn-primary">Search</button>
            </form>
        </div>

        <div class="float-right">
            <form class="mb-4" action="{{ route('applications.shortlist') }}" method="post">
                @csrf

                <button type="submit" class="btn btn-primary">Shortlist</button>
            </form>
        </div>

        <div class="clearfix"></div>

        <div class="card">
            <div class="card-body">


                <table id="" class="table  table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Full Name</th>
                        <th>Application ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                    </thead>


                    <tbody>
                        @foreach ($applications as $key => $application)
                            <tr>
                                <th>{{ $key + $applications->firstItem() }}</th>
                                <td>{{ $application->student->name }}</td>
                                <td>{{ $application->application_id }}</td>
                                <td>{{ $application->student->username }}</td>
                                <td>{{ $application->student->email }}</td>
                                <td>{{ $application->student->phone }}</td>
                                <td class="text-center">
                                    @if ($application->red_flagged)
                                        <span class="badge badge-danger">Declined</span>
                                    @else
                                        <span class="badge badge-primary">Received</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if ($application->red_flagged)
                                        <a href="javascript:void(0)" onclick="restoreApplication({{ $application->application_id }})" class="btn btn-info waves-effect waves-light btn-sm"><i class="ri-checkbox-multiple-line"></i></a>
                                    @else
                                        <a href="javascript:void(0)" onclick="revokeApplication({{ $application->application_id }})" class="btn btn-danger waves-effect waves-light btn-sm"><i class="ri-delete-bin-2-line"></i></a>
                                    @endif
                                    <form id="{{ $application->application_id }}" action="{{ route($application->red_flagged?'application-accept':'application-decline', $application->application_id) }}" method="post">@csrf @if (!$application->red_flagged) @method('DELETE') @endif </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                
                <div>
                    {{ $applications->appends(request()->input())->links('pagination::bootstrap-5') }}
                </div>
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
        function revokeApplication(id) {
            if (confirm('Are you sure? Delete Application')) {
                $('#'+id).submit()
            }
        }
        function restoreApplication(id) {
            if (confirm('Are you sure? Restore Application')) {
                $('#'+id).submit()
            }
        }
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
