@extends('layouts/main')
@section('title', 'Wallet')
@section('content')
<div class="row">
    <div class="col-lg-8 col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Wallet</h4>
            </div>
            <div class="card-content dashboard">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable" class="table zero-configuration" width="100%">
                            <thead>
                                <tr>
                                    <th width="5%">ID</th>
                                    <th width="20%">Username</th>
                                    <th width="20%">Amount</th>
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
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">History Wallet</h4>
            </div>
            <div class="card-content dashboard">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Amount</th>
                                        <th>Type</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(item, index) in details" :key="item.id" 
                                    v-bind:class="[item.type == 'addition' ? 'table-success' : 'table-danger']">
                                        <td>@{{ item.date }}</td>
                                        <td>@{{ item.amount }}</td>
                                        <td>@{{ item.type }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
<script type="text/javascript">
    new Vue({
        el: '#app',
        data() {
            return {
                url: '/wallet',
                dt: null,
                details: []
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
                    await axios.get(`${me.url}/list/${id}`).then(function (resp) {
                        console.log(resp)
                        if (resp.data.code === 200) {
                            me.details = resp.data.data.details;
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
                this.details = []
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
                    {data: 'amount', name: 'amount'},
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