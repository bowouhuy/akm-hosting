@extends('layouts/main')
@section('title', 'Participant')
@section('content')
<div class="row">
    <div class="col-lg-8 col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Students</h4>
            </div>
            <div class="card-content dashboard">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable" class="table zero-configuration" width="100%">
                            <thead>
                                <tr>
                                    <th width="5%">ID</th>
                                    <th width="20%">Username</th>
                                    <th width="20%">Email</th>
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
                <h4 class="card-title">Data Diri</h4>
            </div>
            <div class="card-content dashboard">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <fieldset class="form-group">
                                <label>Username</label>
                                <input type="text" class="form-control" v-model="form.username" placeholder="Username">
                            </fieldset>
                            <fieldset class="form-group">
                                <label>Nama Depan</label>
                                <input type="text" class="form-control" v-model="form.first_name" placeholder="Nama Depan">
                            </fieldset>
                            <fieldset class="form-group">
                                <label>Nama Belakang</label>
                                <input type="text" class="form-control" v-model="form.last_name" placeholder="Nama Belakang">
                            </fieldset>
                            <fieldset class="form-group">
                                <label>Email</label>
                                <input type="text" class="form-control" v-model="form.email" placeholder="Email">
                            </fieldset>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-right">
                <a class="btn btn-secondary" @click="clearData()">Clear</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
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
                url: '/participant',
                dt: null,
                form: {
                    id:'',
                    username:'',
                    first_name:'',
                    last_name:'',
                    email:'',
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
                        if (resp.data.code === 200) {
                            me.form = resp.data.data;
                        }
                    });
                else this.clear()
            },
            async submit() {
                let me = this;

                if (me.id != null) {
                    await axios.put(`${me.url}/${me.id}?${myApp.csrf}`, me.form)
                        .then(function (resp) {
                            me.fireResponse(resp);
                        })
                        .catch((resp) => {
                            swal.fire("Oops", resp.data.message, "error")
                        });
                } else {
                    await axios.post(`${me.url}?${myApp.csrf}`, me.form)
                        .then(function (resp) {
                            me.fireResponse(resp);
                        })
                        .catch((resp) => {
                            swal.fire("Oops", resp.data.message, "error")
                        });
                }
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
                    username:'',
                    first_name:'',
                    last_name:'',
                    email:'',
                }
            },
            clear() {
                let me = this;
                this.clearData();
                me.drawTable();
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
                                me.clearData();
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
                    {data: 'username', name: 'username'},
                    {data: 'email', name: 'email'},
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