<template id="formQuestionTemplate">
    <div class="modal fade" id="form-question-dialog" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel160" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form @submit.prevent="submit">
            <div class="modal-content">
                <div class="modal-header bg-primary white">
                    <h5 class="modal-title" id="myModalLabel160">Data Soal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <fieldset class="form-group">
                                <label>Deskripsi Soal</label>
                                <textarea class="form-control" v-model="form.question" style="height:200px" placeholder="Deskripsi Soal"></textarea>
                            </fieldset>
                            <label>Jawaban Soal</label>
                            <fieldset class="mb-1">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">A.</span>
                                    </div>
                                    <input type="text" v-model="form.answer1" class="form-control" placeholder="Jawaban 1">
                                </div>
                            </fieldset>
                            <fieldset class="mb-1">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">B.</span>
                                    </div>
                                    <input type="text" v-model="form.answer2" class="form-control" placeholder="Jawaban 2">
                                </div>
                            </fieldset>
                            <fieldset class="mb-1">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">C.</span>
                                    </div>
                                    <input type="text" v-model="form.answer3" class="form-control" placeholder="Jawaban 3">
                                </div>
                            </fieldset>
                            <fieldset class="mb-1">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">D.</span>
                                    </div>
                                    <input type="text" v-model="form.answer4" class="form-control" placeholder="Jawaban 4">
                                </div>
                            </fieldset>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
            </form>
        </div>
    </div>
</template>
<script type="text/javascript">
    Vue.component('form-question-component', {
        template: '#formQuestionTemplate',
        props: {'isParentList': false},
        data() {
            return {
                url: "/question",
                id: null,
                form: {
                    id: '',
                    question: '',
                    answer1: '',
                    answer2: '',
                    answer3: '',
                    answer4: '',
                    question_id: ''
                }
            }
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
                            me.form.question_id = resp.data.data.id
                            console.log(me.form.question_id)
                            me.fireResponse(resp);
                        })
                        .catch((resp) => {
                            swal.fire("Oops", resp.response.data.message, "error")
                        });
                } else {
                    await axios.post(`${me.url}?${myApp.csrf}`, me.form)
                        .then(function (resp) {
                            me.fireResponse(resp);
                        })
                        .catch((resp) => {
                            swal.fire("Oops", resp.response.data.message, "error")
                        });
                }
            },
            fireResponse(resp) {
                if (resp.data.code === 201) {
                    swal.fire('Sukses', resp.data.message, "success")
                    this.clear();
                } else
                    swal.fire("Oops", resp.data.message, "error")
            },
            clearData() {
                this.id = null;
                this.form = {
                    id: '',
                    question: '',
                    answer1: '',
                    answer2: '',
                    answer3: '',
                    answer4: '',
                    question_id: ''
                }
            },
            clear() {
                this.clearData();

                if (this.isParentList)
                    this.$parent.drawTable();
                $('#form-question-dialog').modal('hide');
            }
        }
    });
</script>