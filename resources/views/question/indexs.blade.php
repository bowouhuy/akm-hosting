@extends('layouts/main')
@section('title', 'Question')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Paket Soal</h4>
                <div class="card-header-right">
                    <ul class="list-inline mb-0">
                        <li>
                        <button @click="showForm(null)" class="btn btn-outline-primary">
                            <i class="fa fa-plus mr-2"></i> Tambah Data
                        </button>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="card-content dashboard">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable" class="table zero-configuration" width="100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Question</th>
                                    <th>Answer</th>
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
<form-question-component :is-parent-list="true"
ref="formQuestionComponent"></form-question-component>
@endsection
@push('js')
@include('question.form')
<script type="text/javascript">
    new Vue({
        el: '#app',
        data() {
            return {
                url: '/question',
                dt: null,
                form: {
                    id:'',
                    question:'',
                    answers: {}
                }
            };
        },
        methods: {
            showForm(id) {
                this.$refs.formQuestionComponent.open(id);
                $('#form-question-dialog').modal('show');
            },
            destroy(id) {
                let me = this;
                swal.fire({
                    title: 'Anda yakin menghapus data ini?',
                    text: "Data yang sudah dihapus tidak dapat dikembalikan.",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Hapus sekarang!',
                    cancelButtonText: 'Batalkan.'
                }).then(function (result) {
                    if (result.value) {
                        axios.delete(`${me.url}/${id}?${myApp.csrf}`)
                            .then(function (resp) {
                                console.log(resp, "resp")
                                me.drawTable();
                            });
                    }
                });
            },
            drawTable() {
                let me = this;
                me.dt.on('order.dt search.dt', function () {
                    me.dt.column(0, {search: 'applied', order: 'applied'})
                }).draw();
            }
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
                ajax: me.url + '/fetch/datatable',
                processing: true,
                serverSide: true,
                pageLength: 10,
                "aoColumnDefs": [
                    {"bSearchable": true, "aTargets": [0]},
                ],
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'question', name: 'question'},
                    {data: 'created_at', name: 'created_at'},
                    {
                        data: 'id', name: 'id', render: function (id) {
                            return `
                            <button class="btn btn-sm btn-warning edit-record" data-value="${id}">
                            <i class="feather icon-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-danger delete-record" data-value="${id}">
                            <i class="feather icon-trash"></i>
                            </button>
                            `
                        }
                    }
                ],
                drawCallback: function (settings) {
                    $(".delete-record").on('click', function (e) {
                        me.destroy($(this).data('value'));
                    });
                    $(".edit-record").on('click', function (e) {
                        me.showForm($(this).data('value'));
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