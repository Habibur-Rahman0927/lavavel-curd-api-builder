<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
        class="bi bi-arrow-up-short"></i></a>
        <script src="{{ asset('assets/datatables/js/jquery-3.7.0.min.js') }}"></script>
        <script src="{{ asset('assets/datatables/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('assets/datatables/js/dataTables.buttons.min.js') }}"></script>
        <script src="{{ asset('assets/datatables/js/jszip.min.js') }}"></script>
        <script src="{{ asset('assets/datatables/js/vfs_fonts.js') }}"></script>
        <script src="{{ asset('assets/datatables/js/pdfmake.min.js') }}"></script>
        <script src="{{ asset('assets/datatables/js/buttons.html5.min.js') }}"></script>
        <script src="{{ asset('assets/datatables/js/buttons.print.min.js') }}"></script>
        <script src="{{ asset('assets/datatables/js/sweetalert2@11.js') }}"></script>
        
<script src="{{ asset('assets/js/apexcharts.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/js/chart.min.js') }}"></script>
<script src="{{ asset('assets/js/echarts.min.js') }}"></script>
<script src="{{ asset('assets/js/quill.min.js') }}"></script>
<script src="{{ asset('assets/js/simple-datatables.js') }}"></script>
<script src="{{ asset('assets/js/tinymce.min.js') }}"></script>
<script src="{{ asset('assets/js/validate.js') }}"></script>
<script src="{{ asset('assets/js/main.js') }}"></script>
<!-- BEGIN: Page JS-->
@yield('page-script')
<!-- END: Page JS-->
@stack('scripts')