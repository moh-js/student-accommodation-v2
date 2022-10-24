<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <div class="row">

                    <div class="col-4">
                        <div class="form-group">
                            <label for="academic_year_id">Academic Year</label>
                            <select class="form-control" wire:model="academic_year_id" id="academic_year_id">
                                @foreach (App\Models\AcademicYear::all() as $academicYear)
                                    <option value="{{ $academicYear->slug }}">{{ $academicYear->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="form-group">
                            <label for="status">Payment Status</label>
                            <select class="form-control" wire:model="status">
                                <option value="{{ null }}">Select Payment Status</option>
                                <option value="{{ 1 }}">Paid</option>
                                <option value="{{ 0 }}">Pending</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="form-group">
                            <label for="status">Search Student</label>
                            <input type="text" wire:model="search" name="search" class="form-control">
                        </div>
                    </div>

                </div>

                <div class="clearfix"></div>

                <div class="table-responsive">
                    <table id="table" class="table  table-bordered dt-responsive nowrap"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>#</th>
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
                            @foreach ($invoices as $key => $invoice)
                                <tr>
                                    <th>{{ $key + $invoices->firstItem() }}</th>
                                    <td>{{ $invoice->student->username }}</td>
                                    <td>{{ $invoice->student->name }}</td>
                                    <td>{{ $invoice->invoice_no }}</td>
                                    <td>{{ $invoice->reference }}</td>
                                    <td>{{ $invoice->control_number }}</td>
                                    <td>{{ number_format($invoice->amount_paid) }} TZS</td>
                                    <td>{{ number_format($invoice->amount - $invoice->amount_paid) }} TZS</td>
                                    <td class="text-center">
                                        @if (!$invoice->status)
                                            <span class="badge badge-pill badge-danger">Not paid</span>
                                        @else
                                            <span class="badge badge-pill badge-primary">Paid</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="javascript:void(0)" onclick="deleteInvoice({{ $invoice }})"
                                            class="btn btn-danger waves-effect waves-light btn-sm"><i
                                                class="ri-delete-bin-line"></i></a>


                                        <a href="javascript:void(0)" data-toggle="modal"
                                            data-target="#modal{{ $invoice->slug }}"
                                            class="btn btn-primary waves-effect waves-light btn-sm"><i
                                                class="ri-speed-mini-line"></i></a>


                                        <form id="{{ $invoice->slug }}"
                                            action="{{ route('invoices.destroy', $invoice->slug) }}" method="post">
                                            @csrf @method('DELETE')</form>
                                    </td>

                                    <!-- Modal -->
                                    <div class="modal fade" id="modal{{ $invoice->slug }}" tabindex="-1"
                                        role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Enter Controll Number
                                                        {{ $invoice->student->name }}</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>

                                                <form action="{{ route('invoices.update', $invoice->slug) }}"
                                                    id="form{{ $invoice->slug }}" method="post">
                                                    <div class="modal-body">
                                                        <div class="container-fluid">
                                                            @csrf
                                                            @method('PUT')

                                                            <div class="form-group">
                                                                <label for="">Control #</label>
                                                                <input type="text" name="control_number"
                                                                    id="control_number" class="form-control"
                                                                    placeholder="994360XXXXXX">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-danger"
                                                            data-dismiss="modal">Close</button>
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
                <div>
                    {{ $invoices->links() }}
                </div>
            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->
