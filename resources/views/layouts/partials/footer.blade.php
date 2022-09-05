<section id="footer" class="d-none d-md-block">
    <footer>
        <div class="float-left p-4 d-lg-inline d-none font-weight-bold">
            Copyright © {{ now()->year }}  Mbeya University of Science and Technology
        </div>
        <div class="float-right p-4 d-inline font-weight-bold">
            Developed and Maintained By:  <a href="https://must.ac.tz" target="_blank">Mbeya University of Science and Technology</a>
        </div>
    </footer>
</section>

@push('link')
    <style>
        #footer {
            position: absolute;
            bottom: 0;
            width: 100%;
            /* height: 60px;   Height of the footer */
            /* background: #6cf; */
        }
        .footer {
            padding: 20px 5px !important;
        }
    </style>
@endpush