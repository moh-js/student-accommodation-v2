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
                            <p><strong>Username</strong>: {{ $student->username }}</p>
                        </div>
                        <div class="col-sm-4">
                            <p><strong>Programme</strong>: {{ $student->programme }}</p>
                        </div>
                        <div class="col-sm-4">
                            <p><strong>Level</strong>: {{ title_case($student->level) }}</p>
                        </div>
                    </div>

                    @if ($student->currentApplication())
                        @if (($deadline->end_date->addWeek()) < now())
                            @if ($shortlisted && ($studentKeyNumber <= $roomsCount))
                                <div class="alert alert-success" role="alert">
                                    <strong>Congrats</strong>
                                    <p>You have been selected for in-campus accommodation. complete the payment to secure your place on time and avoid any inconvinience</p>
                                </div>

                                <a href="{{ route('payment', $student->slug) }}" class="btn btn-primary">Next</a>
                            @else
                                <div class="alert alert-danger" role="alert">
                                    <strong>Sorry</strong>
                                    <p>There is no vacancy available that we can allocate to you right now. but stay close we will notify you when there is vancancy available for you</p>
                                </div>
                            @endif
                        @else
                            <div class="alert alert-success" role="alert">
                                <strong>Your application is sent successfull</strong>
                                <p>Your application ID is <strong>{{ $student->currentApplication()->application_id }}</strong> save it for later use. Wait for the result that will be released {{ $deadline->end_date->addWeek()->format('d-m-Y') }}</p>
                            </div>
                        @endif


                    @else
                        <form action="{{ route('application.send', $student->slug) }}" method="post">
                            @csrf

                            <button type="submit" class="btn btn-primary">Apply</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
