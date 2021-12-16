@extends('layouts/main')
@section('title', 'Exam')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Ujian</h4>
            </div>
            <div class="card-content dashboard">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable" class="table zero-configuration" width="100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Username</th>
                                    <th>Package</th>
                                    <th>Tanggal</th>
                                    <th>Mulai</th>
                                    <th>Selesai</th>
                                    <th>Total Soal</th>
                                    <th>Status</th>
                                    <th>Hasil</th>
                                    <th>Score</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<detail-exam-component :is-parent-list="true"
ref="detailExamComponent"></detail-exam-component>
@endsection
@push('js')
@include('exam.detail')
<script type="text/javascript">
    new Vue({
        el: '#app',
        data() {
            return {
                url: '/exam',
                dt: null,
                exam: {
                    id:'',
                    user: {},
                    package: {},
                    details: []
                }
            };
        },
        methods: {
            showDetail(id) {
                this.$refs.detailExamComponent.open(id);
                $('#detail-exam-dialog').modal('show');
            },
        },
        mounted() {
            let me = this;
            me.dt = $('#datatable').DataTable({
                "columnDefs": [
                    {"width": "5%", "targets": 0},
                    {"width": "30%", "targets": 1},
                    {"width": "5%", "targets": 2},
                    {"width": "20%", "targets": 3}
                ],
                responsive: true,
                ajax: me.url + '/datatable',
                processing: true,
                serverSide: true,
                pageLength: 10,
                "aoColumnDefs": [
                    {"bSearchable": true, "aTargets": [0]},
                ],
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'user_id', name: 'user_id'},
                    {data: 'package_id', name: 'package_id'},
                    {data: 'exam_date', name: 'exam_date'},
                    {data: 'exam_start', name: 'exam_start'},
                    {data: 'exam_end', name: 'exam_end'},
                    {data: 'total_question', name: 'total_question'},
                    {data: 'status', name: 'status'},
                    {data: 'result', name: 'result'},
                    {data: 'score', name: 'score'},
                    {
                        data: 'id', name: 'id', render: function (id) {
                            return `
                            <button class="btn btn-sm btn-primary detail-record" data-value="${id}">
                            <i class="feather icon-eye"></i>
                            </button>
                            `
                        }
                    }
                ],
                drawCallback: function (settings) {
                    $(".detail-record").on('click', function (e) {
                        me.showDetail($(this).data('value'));
                    });
                }
            });
            me.dt.on('order.dt search.dt', function () {
                me.dt.column(0, {search: 'applied', order: 'applied'})
            }).draw();
        }
    });
</script>
@endpush