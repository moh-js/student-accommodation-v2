<nav class="navbar navbar-expand-sm navbar-dark bg-primary">
    <a class="navbar-brand" href="{{ route('dashboard') }}">
        <span class="d-none d-md-block">
            <strong>MUST Accommodation System</strong>
        </span>
        <span class="d-block d-md-none">
            <strong>MAS</strong>
        </span>
    </a>
    <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#guestNav" aria-controls="guestNav"
        aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="guestNav">
        <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
            {{-- <li class="nav-item active">
                <a class="nav-link" href="{{ route('apply') }}">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="dropdownId" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dropdown</a>
                <div class="dropdown-menu" aria-labelledby="dropdownId">
                    <a class="dropdown-item" href="#">Action 1</a>
                    <a class="dropdown-item" href="#">Action 2</a>
                </div>
            </li> --}}
        </ul>
        <form class="form-inline my-2 my-lg-0">
            {{-- <button class="btn btn-success my-2 my-sm-0" type="submit">User Guide</button> --}}
        </form>
    </div>
</nav>
