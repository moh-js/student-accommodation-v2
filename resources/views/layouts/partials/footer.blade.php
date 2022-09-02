<section id="footer">
    <footer>
        <div class="float-left p-4 d-inline font-weight-bold">
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
            position: fixed;
            bottom: 0;
            width: 100%;
            height: 60px;   /* Height of the footer */
            /* background: #6cf; */
            }
    </style>
@endpush