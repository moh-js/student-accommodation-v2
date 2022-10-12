@extends('layouts.app')

@push('title')
    Invoice List
@endpush

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex mb-2">
            <form action="{{ route('invoices.fetch') }}" method="post">
                @csrf
                <div class="form-group">
                    <label for="academic_year_id">Academic Year</label>
                    <select class="form-control" name="academic_year_id" id="academic_year_id">
                        @foreach (App\Models\AcademicYear::all() as $academicYear)
                                <option value="{{ $academicYear->slug }}">{{ $academicYear->name }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Get</button>
            </form>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="datatable" class="table  table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                        <tr>
                            <th>Registration #</th>
                            <th>Student Name</th>
                            <th>Invoice #</th>
                            <th>Reference</th>
                            <th>Control #</th>
                            <th>Amount Paid</th>
                            <th>Balance</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                        </thead>
    
    
                        <tbody>
                            @foreach ($invoices as $invoice)
                                <tr>
                                    <td>{{ $invoice->student->username }}</td>
                                    <td>{{ $invoice->student->name }}</td>
                                    <td>{{ $invoice->invoice_no }}</td>
                                    <td>{{ $invoice->reference }}</td>
                                    <td>{{ $invoice->control_number }}</td>
                                    <td>{{ number_format($invoice->amount_paid) }} TZS</td>
                                    <td>{{ number_format($invoice->amount - $invoice->amount_paid) }} TZS</td>
                                    <td class="text-center">
                                        @if (1)
                                            <span class="badge badge-pill badge-danger">Not paid</span>
                                        @else
                                            <span class="badge badge-pill badge-primary">Paid</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                            <a href="javascript:void(0)" onclick="deleteInvoice({{ $invoice }})" class="btn btn-danger waves-effect waves-light btn-sm"><i class="ri-delete-bin-line"></i></a>
                                            
                                            
                                            <a href="javascript:void(0)" data-toggle="modal" data-target="#modal{{ $invoice->slug }}" class="btn btn-primary waves-effect waves-light btn-sm"><i class="ri-speed-mini-line"></i></a>
                                            
                                            
                                            <form id="{{ $invoice->slug }}" action="{{ route('invoices.destroy', $invoice->slug) }}" method="post">@csrf @method('DELETE')</form>
                                    </td>

                                    <!-- Modal -->
                                    <div class="modal fade" id="modal{{ $invoice->slug }}" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Enter Controll Number {{ $invoice->student->name }}</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                </div>

                                                <form action="{{ route('invoices.update', $invoice->slug) }}" id="form{{ $invoice->slug }}" method="post">
                                                    <div class="modal-body">
                                                        <div class="container-fluid">
                                                            @csrf
                                                            @method('PUT')

                                                            <div class="form-group">
                                                              <label for="">Control #</label>
                                                              <input type="text" name="control_number" id="control_number" class="form-control" placeholder="994360XXXXXX">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Save</button>
                                                    </div>
                                                </form>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <script>
                                        $('#exampleModal').on('show.bs.modal', event => {
                                            var button = $(event.relatedTarget);
                                            var modal = $(this);
                                            // Use above variables to manipulate the DOM
                                            
                                        });
                                    </script>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
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
        function deleteInvoice(invoice) {
            if (confirm("Delete " + invoice.student.name + ' invoice?')) {
                $('#'+invoice.slug).submit()
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
