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
                                <input type="text" value="{{ old('search', request()->search) }}" class="form-control"
                                    placeholder="Enter username" name="search">
                            </div>
                            <button type="submit" class="btn btn-primary">Search</button>
                        </form>
                    </div>
                    <div class="float-left">
                        <a href="{{ route('publish') }}" class="btn btn-warning">Publish Shortlisted</a>
                        
                        <a href="javascript:void(0)" onclick="banShortlist()" class="btn btn-danger">Ban Selection</a>

                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary" data-toggle="modal"
                            data-target="#export-published">
                            Export Published
                        </button>

                        <form hidden id="ban" action="{{ route('ban.selection') }}" method="post">
                            @csrf
                        </form>

                        <div class="clearfix"></div>
                        <div class="mt-4">
                            @if (session()->has('shortlist_file_name'))
                                @if (is_file(storage_path('app/' . session('shortlist_file_name'))))
                                    @php
                                        $file_path = storage_path('app/' . session('shortlist_file_name'));
                                    @endphp
                                    Download the exported excel for shortlisted students
                                    <a
                                        href="{{ route('download.file', session('shortlist_file_name')) }}">{{ session('shortlist_file_name') }}</a>
                                @endif
                            @endif
                        </div>
                    </div>


                    <!-- Modal -->
                    <div class="modal fade" id="export-published" tabindex="-1" role="dialog"
                        aria-labelledby="modelTitleId" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Select gender base</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="{{ route('export.shortlisted.simple') }}" method="post">
                                    @csrf

                                    <div class="modal-body">
                                        <select class="form-control" name="gender_id" id="gender_id">
                                            <option value="{{ 3 }}">All</option>
                                            @foreach (App\Models\Gender::all() as $gender)
                                                <option value="{{ $gender->id }}">{{ $gender->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-success">Export</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table id="" class="table  table-bordered dt-responsive nowrap"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Full Name</th>
                                    <th>Username</th>
                                    <th>Phone</th>
                                    <th>Student Type</th>
                                    <th>Level</th>
                                    {{-- <th>Eligible Status</th> --}}
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
                                        <td>{{ $shortlist->student->phone }}</td>
                                        <td>{{ $shortlist->student->student_type }}</td>
                                        <td>{{ $shortlist->student->level }}</td>
                                        <td>{{ $shortlist->student->sponsor }}</td>
                                        {{-- <td>
                                        @if (checkEligibility($shortlist->student))
                                            <span class="badge badge-primary">Selected</span>
                                        @else
                                            <span class="badge badge-danger">Not Selected
                                            </span>
                                        @endif
                                    </td> --}}
                                        <td class="text-center">
                                            <a href="{{ route('invoice.create', $shortlist->student->slug) }}"
                                                class="btn btn-primary waves-effect waves-light btn-sm"
                                                title="create invoice"><i class="ri-refund-line"></i></a>

                                            <a href="javascript:void(0)" onclick="removeShortlist({{ $shortlist->id }})"
                                                class="btn btn-danger waves-effect waves-light btn-sm"><i
                                                    class="ri-delete-bin-2-line"></i></a>

                                            <form id="{{ $shortlist->id }}"
                                                action="{{ route('remove.shortlisted', $shortlist->id) }}" method="post">
                                                @csrf @if (!$shortlist->red_flagged)
                                                    @method('DELETE')
                                                @endif
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

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
                $('#' + id).submit()
            }
        }

        function banShortlist(id) {
            if (confirm('Are you sure? ban student selection')) {
                $('#ban').submit()
            }
        }
    </script>

    <!-- Datatable init js -->
    <script src="{{ asset('assets/js/pages/datatables.init.js') }}"></script>
@endpush

@push('link')
    <!-- DataTables -->
    <link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('assets/libs/datatables.net-select-bs4/css//select.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />

    <!-- Responsive datatable examples -->
    <link href="{{ asset('assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}"
        rel="stylesheet" type="text/css" />
@endpush
