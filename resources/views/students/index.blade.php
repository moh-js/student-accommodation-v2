@extends('layouts.app')

@push('title')
    List
@endpush

@section('content')
<div class="row">
    <div class="col-12">
        <div class="float-left">
            <form class="mb-4" action="{{ route('students.index') }}" method="get">
                <div class="form-group">
                    <input type="text" value="{{ old('search', request()->search) }}" class="form-control" placeholder="Enter username" name="search">
                </div>

                <button type="submit" class="btn btn-primary">Search</button>
            </form>
        </div>

        <div class="text-right mb-2">
            <a href="{{ route('students.import.gov') }}" class="btn btn-info">Government Students</a>
            <a href="{{ route('students.create') }}" class="btn btn-primary">Add New Student</a>
            <a href="{{ route('students.create', ['method' => 'bulk']) }}" class="btn btn-warning">Add Bulk Students</a>
        </div>

        <div class="clearfix"></div>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table  table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Full Name</th>
                            <th>Reg #</th>
                            <th>Programme</th>
                            <th>Phone</th>
                            <th>Sponsor</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                        </thead>
    
    
                        <tbody>
                        @foreach ($students as $key => $student)
                                <tr>
                                    <td>{{ $key + $students->firstItem() }}</td>
                                    <td>{{ $student->name }}</td>
                                    <td>{{ $student->username }}</td>
                                    <td>{{ $student->programme }}</td>
                                    <td>{{ $student->phone }}</td>
                                    <td>{{ $student->sponsor }}</td>
                                    <td class="text-center">
                                        @if ($student->deleted_at)
                                            <span class="badge badge-pill badge-danger">Inactive</span>
                                        @else
                                            <span class="badge badge-pill badge-primary">Active</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if ($student->deleted_at)
                                            <a href="javascript:void(0)" onclick="$('#{{ $student->slug }}').submit()" class="btn btn-info waves-effect waves-light btn-sm"><i class="ri-user-received-line"></i></a>
                                        @else
                                            <a href="{{ route('students.edit', $student->slug) }}" class="btn btn-warning waves-effect waves-light btn-sm"><i class="ri-edit-line"></i></a>
                                            <a href="javascript:void(0)" onclick="$('#{{ $student->slug }}').submit()" class="btn btn-danger waves-effect waves-light btn-sm"><i class="ri-delete-bin-line"></i></a>
    
                                        @endif
                                        <form id="{{ $student->slug }}" action="{{ route('students.destroy', $student->username) }}" method="post">@csrf @method('DELETE')</form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div>
                    {{ $students->appends(request()->input())->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->
@endsection


@push('script')

@endpush

@push('link')
 
@endpush
