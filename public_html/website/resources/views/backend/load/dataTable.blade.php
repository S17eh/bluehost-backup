@push('before-style')
<!-- DataTables -->
<link href="{{ asset('backend/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
<!-- Responsive datatable examples -->
<link href="{{ asset('backend/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />

@endpush()

@push('before-script')
<!-- Required datatable js -->
<script src="{{ asset('backend/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('backend/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<!-- Responsive examples -->
<script src="{{ asset('backend/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{ asset('backend/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
@endpush()