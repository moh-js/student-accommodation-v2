@extends('layouts.app')

@push('title')
    Shortlist
@endpush

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="float-right">
                    <form class="mb-4" action="{{ route('shortlist') }}" method="get">
        
                        <div class="form-group">
                            <input type="text" value="{{ old('search', request()->search) }}" class="form-control" placeholder="Enter username" name="search">
                        </div>
                        <button type="submit" class="btn btn-primary">Search</button>
                    </form>
                </div>

                <table id="" class="table  table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Full Name</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Student Type</th>
                        <th>Level</th>
                        <th>Sponsorship</th>
                        {{-- <th class="text-center">Status</th> --}}
                        <th class="text-center">Action</th>
                    </tr>
                    </thead>


                    <tbody>
                    @foreach ($shortlists as $key => $shortlist)
                            <tr>
                                <th>{{ $key + $shortlists->firstItem() }}</th>
                                <td>{{ $shortlist->student->name }}</td>
                                <td>{{ $shortlist->student->username }}</td>
                                <td>{{ $shortlist->student->email }}</td>
                                <td>{{ $shortlist->student->phone }}</td>
                                <td>{{ $shortlist->student->student_type }}</td>
                                <td>{{ $shortlist->student->level }}</td>
                                <td>{{ $shortlist->student->sponsor }}</td>
                                <td class="text-center">
                                    <a href="javascript:void(0)" onclick="removeShortlist({{ $shortlist->id }})" class="btn btn-danger waves-effect waves-light btn-sm"><i class="ri-delete-bin-2-line"></i></a>

                                    <form id="{{ $shortlist->id }}" action="{{ route('remove.shortlisted', $shortlist->id) }}" method="post">@csrf @if (!$shortlist->red_flagged) @method('DELETE') @endif </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div>
                    {{ $shortlists->appends(request()->input())->links('pagination::bootstrap-5') }}
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
        function removeShortlist(id) {
            if (confirm('Are you sure? Decline Selection')) {
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
