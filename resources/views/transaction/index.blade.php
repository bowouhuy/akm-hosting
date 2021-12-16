@extends('layouts/main')
@section('title', 'Transactions')
@section('content')
<div class="row">
    <div class="col-lg-8 col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Transaksi</h4>
            </div>
            <div class="card-content dashboard">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable" class="table zero-configuration" width="100%">
                            <thead>
                                <tr>
                                    <th width="5%">ID</th>
                                    <th width="20%">Username</th>
                                    <th width="10%">Date</th>
                                    <th width="20%">Amount</th>
                                    <th width="10%">Status</th>
                                    <th width="15%">Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-12">
        <form @submit.prevent="submit">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Detail Transaksi</h4>
            </div>
            <div class="card-content dashboard">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <fieldset class="form-group">
                                <label>Nama</label>
                                <input type="text" class="form-control" v-model="form.user_id" placeholder="Nama Paket"
                                v-bind:disabled="form.status != 'waiting'">
                            </fieldset>
                            <fieldset class="form-group">
                                <label>Tanggal Transaksi</label>
                                <input type="text" class="form-control" v-model="form.date" placeholder="Tanggal Transaksi"
                                v-bind:disabled="form.status != 'waiting'">
                            </fieldset>
                            <fieldset class="form-group">
                                <label>Jumlah</label>
                                <input type="text" class="form-control" v-model="form.amount" placeholder="Jumlah"
                                v-bind:disabled="form.status != 'waiting'">
                            </fieldset>
                            <fieldset class="form-group">
                                <label>Status</label>
                                <treeselect
                                    placeholder="Pilih Status"
                                    v-model="form.status"
                                    :multiple="false"
                                    :options="resources.status"
                                    v-bind:disabled="form.status != 'waiting'"
                                ></treeselect>
                            </fieldset>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-right">
                <a class="btn btn-secondary" @click="clearData()">Clear</a>
                <button type="submit" class="btn btn-primary" v-bind:disabled="form.status != 'waiting'">Konfirmasi</button>
            </div>
        </div>
        </form>
    </div>
</div>
@endsection
@push('js')
<script type="text/javascript">
    new Vue({
        el: '#app',
        data() {
            return {
                url: '/transaction',
                dt: null,
                resources: {
                    status: [
                        {
                            id: 'paid',
                            label: 'paid',
                        },
                        {
                            id: 'waiting',
                            label: 'waiting',
                        },
                        {
                            id: 'cancel',
                            label: 'cancel',
                        }
                    ]
                },
                form: {
                    id:'',
                    user_id:'',
                    date:'',
                    amount:'',
                    status:null,
                }
            };
        },
        methods: {
            open(id) {
                this.clearData();
                if (id != null)
                    this.getById(id);
            },
            async getById(id) {
                let me = this;
                me.id = id;
                if (me.id != null)
                    await axios.get(`${me.url}/${id}`).then(function (resp) {
                        console.log(resp)
                        if (resp.data.code === 200) {
                            me.form = resp.data.data;
                        }
                    });
                else this.clear()
            },
            fireResponse(resp) {
                if (resp.data.code === 201) {
                    swal.fire('Sukses', resp.data.message, "success")
                    this.clear();
                } else {
                    swal.fire("Oops", resp.data.message, "error")
                }
            },
            clearData() {
                this.form = {
                    id:'',
                    user_id:'',
                    date:'',
                    amount:'',
                    status:''
                }
            },
            clear() {
                let me = this;
                this.clearData();
                me.drawTable();
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
                    {"width": "15%", "targets": 2}
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
                    {data: 'user.username', name: 'user.username'},
                    {data: 'date', name: 'date'},
                    {data: 'amount', name: 'amount'},
                    {data: 'status', name: 'status'},
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
                        me.open($(this).data('value'));
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