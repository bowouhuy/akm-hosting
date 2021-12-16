@extends('layouts/main')
@section('title', 'Question')
@section('content')
<div class="row">
    <div class="col-lg-8 col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Soal</h4>
            </div>
            <div class="card-content dashboard">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable" class="table zero-configuration" width="100%">
                            <thead>
                                <tr>
                                    <th width="5%">ID</th>
                                    <th width="10%">Paket</th>
                                    <th width="10%">Jenis</th>
                                    <th width="35%">Question</th>
                                    <th width="10%">Action</th>
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
                <h4 class="card-title">Data Soal</h4>
            </div>
            <div class="card-content dashboard">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <fieldset class="form-group">
                                <label>Paket Soal</label>
                                <treeselect
                                    placeholder="Pilih Paket"
                                    v-model="form.package_id"
                                    :multiple="false"
                                    :options="resources.packages"
                                ></treeselect>
                            </fieldset>
                            <fieldset class="form-group">
                                <label>Jenis Soal</label>
                                <treeselect
                                    placeholder="Pilih Jenis Soal"
                                    v-model="form.type_id"
                                    :multiple="false"
                                    :options="resources.question_types"
                                ></treeselect>
                            </fieldset>
                            <fieldset class="form-group">
                                <label>Deskripsi Soal</label>
                                <textarea class="form-control" v-model="form.question" style="height:150px" placeholder="Deskripsi Soal"></textarea>
                            </fieldset>
                            <label>Jawaban Soal</label>
                            <fieldset class="mb-1" v-for="(item, index) in form.answers" :key="item.id">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <div class="vs-radio-con">
                                                <input type="radio" v-model="radio" :value="index">
                                                <span class="vs-radio vs-radio-sm">
                                                    <span class="vs-radio--border"></span>
                                                    <span class="vs-radio--circle"></span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="text" class="form-control" v-model="item.answer" placeholder="Jawaban">
                                </div>
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
                url: '/question',
                route: {
                    package_url: "/package",
                    question_types_url: "/question_types",
                    answer_url: "/answer"
                },
                dt: null,
                resources: {
                    packages: [],
                    question_types: []
                },
                radio: '',
                form: {
                    id:'',
                    package_id:null,
                    type_id:null,
                    question:'',
                    answers: [
                        {
                            answer: '',
                            answer_key: 0
                        },
                        {
                            answer: '',
                            answer_key: 1
                        },
                        {
                            answer: '',
                            answer_key: 2
                        },
                        {
                            answer: '',
                            answer_key: 3
                        },
                    ],
                    question_id: ''
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
                    await axios.get(`${me.url}/list/${id}`).then(function (resp) {
                        if (resp.data.code === 200) {
                            me.form = resp.data.data;
                            me.form.answers.forEach((item, index) => {
                                if (item.answer_key == 'yes') me.radio = index;
                                item.answer_key = index;
                            });
                        }
                    });
                else this.clear()
            },
            async submit() {
                let me = this;

                if (me.id != null) {
                    await axios.put(`${me.url}/${me.id}?${myApp.csrf}`, me.form)
                        .then(function (resp) {
                            axios.delete(`${me.route.answer_url}/${resp.data.data.id}?${myApp.csrf}`)
                            me.form.answers.forEach(item => {
                                item.question_id = resp.data.data.id
                                item.answer_key = (me.radio == item.answer_key) ? 'yes' : 'no';
                                axios.post(`${me.route.answer_url}?${myApp.csrf}`, item)
                            });
                            me.fireResponse(resp);
                        })
                        .catch((resp) => {
                            swal.fire("Oops", resp.data.message, "error")
                        });
                } else {
                    await axios.post(`${me.url}?${myApp.csrf}`, me.form)
                        .then(function (resp) {
                            axios.delete(`${me.route.answer_url}/${resp.data.data.id}?${myApp.csrf}`)
                            me.form.answers.forEach(item => {
                                item.question_id = resp.data.data.id
                                item.answer_key = (me.radio == item.answer_key) ? 'yes' : 'no';
                                axios.post(`${me.route.answer_url}?${myApp.csrf}`, item)
                            });
                            me.fireResponse(resp);
                        })
                        // .catch((resp) => {
                        //     swal.fire("Oops", resp.data.message, "error")
                        // });
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
                this.id = null;
                this.radio = null;
                this.form = {
                    id: '',
                    package_id:null,
                    type_id:null,
                    question: '',
                    answers: [
                        {
                            answer: '',
                            answer_key: 0
                        },
                        {
                            answer: '',
                            answer_key: 1
                        },
                        {
                            answer: '',
                            answer_key: 2
                        },
                        {
                            answer: '',
                            answer_key: 3
                        },
                    ],
                    question_id: ''
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

            axios.get(`${this.route.package_url}/list`).then(function (resp) {
                if (resp.data.code === 200) {
                    me.resources.packages = resp.data.data.map(o => ({
                        id: o.id,
                        label: o.name+' - '+o.description
                    }));

                }
            });

            axios.get(`${this.route.question_types_url}/list`).then(function (resp) {
                if (resp.data.code === 200) {
                    me.resources.question_types = resp.data.data.map(o => ({
                        id: o.id,
                        label: o.name
                    }));

                }
            });

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
                    {data: 'package.name', name: 'package.name'},
                    {data: 'type.name', name: 'type.name'},
                    {data: 'question', name: 'question'},
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