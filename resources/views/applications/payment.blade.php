@extends('layouts.app')

@section('content')
@include('layouts.partials.nav')

<div class="row no-gutters">
    <div class="col-sm-12">
        <div class="container">
            <div class="card mt-5">
                <div class="card-body">
                    <span class="card-title" style="font-size: 18px;"><strong>Application</strong></span>
                    <hr>
                    <div class="row">
                        <div class="col-sm-4">
                            <p><strong>Name</strong>: {{ $student->name }}</p>
                        </div>
                        <div class="col-sm-4">
                            <p><strong>Email</strong>: {{ $student->email }}</p>
                        </div>
                        <div class="col-sm-4">
                            <p><strong>Phone Number</strong>: {{ $student->phone }}</p>
                        </div>
                        <div class="col-sm-4">
                            <p><strong>Registration #</strong>: {{ $student->username }}</p>
                        </div>
                        <div class="col-sm-4">
                            <p><strong>Sponsor</strong>: {{ strtoupper($student->sponsor) }}</p>
                        </div>
                        <div class="col-sm-4">
                            <p><strong>Award</strong>: {{ strtoupper($student->award) }}</p>
                        </div>
                        <div class="col-sm-4">
                            <p><strong>Level</strong>: {{ title_case($student->level) }}</p>
                        </div>
                        <div class="col-sm-8">
                            <p><strong>Programme</strong>: {{ $student->programme }}</p>
                        </div>
                    </div>

                    @if (session('no_costumer'))
                        <div class="alert alert-danger" role="alert">
                            <h5 class="alert-heading">Alert</h5>
                            {{-- <strong>{{ session('no_costumer') }}</strong> --}}
                            <p>You must use your <a href="https://sims.must.ac.tz" target="_blank">SIMS</a> account to create invoice and pay for administrative fee first, before paying the accommodation fee.</p>
                        </div>
                    @endif

                    @if ($invoice)
                        @livewire('invoice-table', ['student' => $student], key($student->id))

                        @if ($invoice->status)
                            <a href="{{ route('allocation', ['student' => $student->slug, 'academic_year' => $currentAcademicYear->slug]) }}" class="btn btn-primary">Next</a>
                        @endif
                    @else
                        
                        <form id="form" action="{{ URL::temporarySignedRoute('invoice.create-otp', now()->addMinutes(1), ['otp' => $shortlist->otp, 'student' => $student->slug]) }}" method="POST">
                            @csrf

                            {{-- <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">OTP</label>
                                        <input type="text" class="form-control @error('otp') is-invalid @enderror" value="{{ old('otp') }}" name="otp">
                                        @error('otp')
                                            <span class="text-danger">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div> --}}

                            <div class="form-group">
                                {{-- <a href="{{ route('otp.send', $student->slug) }}" class="btn btn-info">Get otp code</a> --}}
                                @if ($student->sponsor == 'government')
                                    <div class="alert alert-danger" role="alert">
                                        <h5 class="alert-heading">Note</h5>
                                        <p>If you are not a government sponsored student and you see this alert then don't click next because you won't be able to create invoice, consult with the Head of Students Welfare first </p>
                                        <p><strong>Phone Number:</strong> 0755 836 970</p>
                                    </div>
                                    <button id="btnSubmit" type="submitForm()" class="btn btn-primary" onclick="submit(); this.disabled = true;">Next</button>
                                @else
                                    <div class="alert alert-danger" role="alert">
                                        <h5 class="alert-heading">Note</h5>
                                        <p>If you are a government sponsored student and you see this alert then don't create the invoice, consult with the Head of Students Welfare first </p>
                                        <p><strong>Phone Number:</strong> 0755 836 970</p>
                                    </div>

                                    <button id="btnSubmit" type="button" class="btn btn-primary" data-toggle="modal" data-target="#sumitForm">Create invoice</button>
                                @endif
                            </div>
                            

                            <!-- Modal -->
                            <div class="modal fade" id="sumitForm" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Are sure?</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
                                            <button type="submit" onclick="submitForm(); this.disabled = true;" class="btn btn-primary">Yes</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>

@include('layouts.partials.footer')

@endsection

@push('script')
    <script>
        function submitForm () {
            $('#form').submit();
        }
    </script>
@endpush