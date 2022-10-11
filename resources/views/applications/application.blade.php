@extends('layouts.app')

@section('content')
@include('layouts.partials.nav')

<div class="row no-gutters">
    <div class="col-sm-12">
        <div class="container">
            <div class="card mt-5">
                <div class="card-body">
                    <span class="card-title" style="font-size: 18px;"><strong>YOUR INFO</strong></span>
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
                            <p><strong>Username</strong>: {{ $student->username }}</p>
                        </div>
                        <div class="col-sm-6">
                            <p><strong>Programme</strong>: {{ $student->programme }}</p>
                        </div>
                        <div class="col-sm-4">
                            <p><strong>Level</strong>: {{ title_case($student->level) }}</p>
                        </div>
                        <div class="col-sm-4">
                            <p><strong>Sponsor</strong>: {{ strtoupper($student->sponsor) }}</p>
                        </div>
                    </div>

                    @if ($student->currentApplication())
                        @if (($deadline->end_date->addDays(3)) < now())
                            @if($shortlisted)
                                @if (!$shortlist->is_published)
                                    <div class="alert alert-success" role="alert">
                                        <strong>Be patient</strong>
                                        <p>The result has not been published yet, kindly wait and continue to visit this page. We will release the result soon.</p>
                                    </div>
                                
                                @elseif ($shortlist->is_banned)
                                    <div class="alert alert-danger" role="alert">
                                        <strong>Banned</strong>
                                        <p>Sorry your application has been banned due to the delay in payment.</p>
                                    </div>
                                @elseif (checkEligibility($student))
                                    <div class="alert alert-success" role="alert">
                                        <strong>Congrats</strong>
                                        <p>You have been selected for in-campus accommodation. complete the payment to secure your place on time and avoid any inconvinience</p>
                                    </div>
                                    
                                    @if ($student->is_fresher)
                                        <form action="{{ route('payment.fresher', $student->slug) }}" method="post">
                                            @csrf
    
                                            <div class="row">
                                                <div class="form-group col-sm-6">
                                                    <label for="reg_number">Registration Number
    
                                                        <a href="javascript:void(0)" data-toggle="modal" data-target="#how-to" class="text-info">
                                                            <span class="d-flex align-items-center">
                                                                <span style=""><i class="mr-1 ri-question-line"></i></span> where do i get registration number
                                                            </span>
                                                        </a>
                                                    </label>
                                                    <input type="text" name="reg_number" id="reg_number" class="form-control @error('reg_number') is-invalid @enderror" placeholder="22XXXXXXXXXXXXXX" aria-describedby="reg_number" value="{{ old('reg_number', $shortlist->has_reg_number?$student->username:'') }}">
                                                    
                                                    @error('reg_number')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
        
                                                <div class="form-group col-12">
                                                    <button type="submit" class="btn btn-primary">Next</button>
                                                </div>
                                            </div>
                                        </form>
    
                                        <!-- Modal -->
                                        <div class="modal fade" id="how-to" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">How to get your registration number</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <strong>In order to get your registration number you should do the following steps.
                                                        </strong>
                                                        <ol>
                                                            <li>
                                                                Login to your sims account <a href="https://sims.must.ac.tz" target="_blank">Here</a>
                                                            </li>
                                                            <li>
                                                                Create your first invoice so that you can pay for registration of your programme 
                                                            </li>
                                                            <li>
                                                                After successfully creating your invoice you should see the list of your invoices, click on the one of the invoice number to download the invoice document
                                                            </li>
                                                            <li>
                                                                Open the downloaded document and you will see the registration number on the list of your information
                                                            </li>
                                                            <li>
                                                                Copy that registration number. and that's it you have your registration number.
                                                            </li>
                                                        </ol>
    
                                                        <h5 class="text-danger">
                                                            If you don't know how to create an invoice click <a target="_blank" href="https://must.ac.tz/portal/frontend/web/uploads/documents/275016319189158611201414121310_8.pdf">here</a> to get the instructions
                                                        </h5>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    @else
                                        <a href="{{ route('payment', $student->slug) }}" class="btn btn-primary">Next</a>
                                    @endif
                                @else
                                    <div class="alert alert-danger" role="alert">
                                        <strong>Sorry</strong>
                                        <p>There is no vacancy available that we can allocate to you right now. but stay close we will notify you when there is vancancy available for you</p>
                                    </div>
                                @endif
                            @endif
                        @else
                            <div class="alert alert-success" role="alert">
                                <strong>Your application is sent successfull</strong>
                                <p>Your application ID is <strong>{{ $student->currentApplication()->application_id }}</strong> save it for later use. Wait for the result that will be released {{ $deadline->end_date->addDays(3)->format('d M Y') }}</p>
                            </div>
                        @endif


                    @else
                        <form action="{{ route('application.send', $student->slug) }}" method="post">
                            @csrf

                            @if ($student->edit)
                                <section class="mt-5">
                                    <span class="card-title" style="font-size: 18px;"><strong>EDIT YOUR INFO</strong></span>

                                    <div class="alert alert-danger" role="alert">
                                        <strong><u>NOTE:</u></strong>
                                        <ol>
                                            <li>All foreigner and disabled students must have a supporting documents for proof.</li>
                                            <li>Any misinformation provided below will lead to your application being cancelled and furthermore we will ban you from applying for In Campus Accommodation.</li>
                                        </ol>
                                    </div>

                                    <hr>

                                    <div class="row justify-content-center">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">Programme</label>
                                                <select class="form-control @error('programme') is-invalid @enderror" type="text" name="programme">
                                                    <option selected value="{{ null }}">Choose the your programme</option>
                                                    @foreach ($programmes as $programme)
                                                        <option {{ old('programme', $student->programme) == $programme['name']? 'selected':'' }} value="{{ $programme['name'] }}">{{ $programme['name'] }}</option>
                                                    @endforeach
                                                </select>
                                                @error('programme')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="">Level</label>
                                                <select class="form-control @error('level') is-invalid @enderror" name="level">
                                                    <option selected value="{{ null }}">Choose the your level</option>
                                                    <option {{ old('level', $student->level) == 'first year'? 'selected':'' }} value="first year">First Year</option>
                                                    <option {{ old('level', $student->level) == 'second year'? 'selected':'' }} value="second year">Second Year</option>
                                                    <option {{ old('level', $student->level) == 'third year'? 'selected':'' }} value="third year">Third Year</option>
                                                    <option {{ old('level', $student->level) == 'fourth year'? 'selected':'' }} value="fourth year">Fourth Year</option>
                                                </select>
                                                @error('level')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">Award</label>
                                                <select class="form-control @error('award') is-invalid @enderror" name="award">
                                                    <option value="{{ null }}">Choose the your award</option>
                                                    @foreach (['certificate', 'diploma', 'bachelor', 'master', 'PhD', 'postgraduate diploma'] as $item)
                                                        <option {{ old('award', $student->award) == $item? 'selected':'' }} value="{{ $item }}">{{ $item }}</option>
                                                    @endforeach
                                                </select>
                                                @error('award')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="">Email</label>
                                                <input type="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $student->email) }}" name="email">
                                                @error('email')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
            
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="">Phone Number</label>
                                                <input type="text" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $student->phone) }}" name="phone">
                                                @error('phone')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
            
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">Do you have any disability?</label>
                                                <select class="form-control" name="disabled" id="disabled">
                                                    <option value="{{ 0 }}">No</option>
                                                    <option value="{{ 1 }}">Yes</option>
                                                </select>
                                            </div>
                                        </div>
            
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">Are you a foreigner student?</label>
                                                <select class="form-control" name="foreigner" id="foreigner">
                                                    <option value="{{ 0 }}">No</option>
                                                    <option value="{{ 1 }}">Yes</option>
                                                </select>
                                                @error('phone')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                    </div>
                                </section>
                            @endif

                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#sumitForm">
                                Apply
                            </button>
                            
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
                                            <button type="submit" class="btn btn-primary">Yes</button>
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

@push('link')
    <style>
        ul {
            text-align:justify;
        }

        li {
            padding-top: 10px;
            padding-bottom: 10px;
        }
    </style>
@endpush
