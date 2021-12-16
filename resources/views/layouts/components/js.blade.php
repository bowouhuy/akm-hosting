<!-- BEGIN: Vendor JS-->
<script src="{{ asset('vendors/js/vendors.min.js') }}"></script>
<!-- BEGIN Vendor JS-->

<!-- BEGIN: Page Vendor JS-->
<script src="{{ asset('vendors/js/charts/apexcharts.min.js') }}"></script>
<script src="{{ asset('vendors/js/extensions/tether.min.js') }}"></script>
<!-- <script src="{{ asset('vendors/js/extensions/shepherd.min.js') }}"></script> -->
<!-- END: Page Vendor JS-->

<!-- BEGIN: Theme JS-->
<script src="{{ asset('js/core/app-menu.js') }}"></script>
<script src="{{ asset('js/core/app.js') }}"></script>
<script src="{{ asset('js/scripts/components.js') }}"></script>
<!-- END: Theme JS-->

<!-- BEGIN: Page JS-->
<script src="{{ asset('js/scripts/pages/dashboard-analytics.js') }}"></script>
<!-- END: Page JS-->
{{--custom--}}
<script src="{{ asset('vendors/vue2/vue@^2.js') }}"></script>
<script src="{{ asset('vendors/vuelidate/vuelidate.min.js') }}"></script>
<script src="{{ asset('vendors/vuelidate/validators.min.js') }}"></script>
<script src="{{ asset('vendors/vue-treeselect/vue-treeselect.umd.min.js') }}"></script>
<script src="{{ asset('vendors/currencyjs/currency.min.js') }}"></script>
<script src="{{ asset('vendors/vue-currency-input/vue-currency-input.umd.js') }}"></script>
<script src="{{ asset('vendors/sugarjs/sugar.min.js') }}"></script>
<script src="{{ asset('vendors/sweetalert2/package/dist/sweetalert2.all.js') }}"></script>
<script src="{{ asset('vendors/axios/axios.min.js') }}"></script>
<script src="{{ asset('vendors/moment/moment.js') }}"></script>
<script src="{{ asset('vendors/moment/id.js') }}"></script>
{{--datatables--}}
<script src="{{ asset('vendors/js/tables/datatable/datatables.min.js') }}"></script>
<!-- <script src="{{ asset('vendors/js/tables/datatable/pdfmake.min.js') }}"></script> -->
<script src="{{ asset('vendors/js/tables/datatable/vfs_fonts.js') }}"></script>
<script src="{{ asset('vendors/js/tables/datatable/datatables.min.js') }}"></script>
<script src="{{ asset('vendors/js/tables/datatable/datatables.buttons.min.js') }}"></script>
<script src="{{ asset('vendors/js/tables/datatable/buttons.html5.min.js') }}"></script>
<script src="{{ asset('vendors/js/tables/datatable/buttons.print.min.js') }}"></script>
<script src="{{ asset('vendors/js/tables/datatable/buttons.bootstrap.min.js') }}"></script>
<script src="{{ asset('vendors/js/tables/datatable/datatables.bootstrap4.min.js') }}"></script>

<script src="{{ asset('src/js/myapp.js') }}"></script>
@stack('js')
