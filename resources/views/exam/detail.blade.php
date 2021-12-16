<template id="detailExamTemplate">
    <div class="modal fade" id="detail-exam-dialog" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel160" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary white">
                    <h5 class="modal-title" id="myModalLabel160">Detail Ujian</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row my-2">
                        <div class="col-md-6">
                            <h6>Nama Peserta : @{{ exam.user.first_name }} @{{ exam.user.last_name }}</h6>
                            <h6>Paket Ujian : @{{ exam.package.name }} - @{{ exam.package.description }}</h6>
                        </div>
                        <div class="col-md-6 text-right">
                            <h5>Score : @{{ exam.score }}</h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th width="55%">Pertanyaan</th>
                                        <th width="30%">Jawaban</th>
                                        <th width="10%">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(item, index) in exam.details" :key="item.id">
                                        <td class="text-center">@{{ item.question_no }}</td>
                                        <td>@{{ item.question.question }}</td>
                                        <td>@{{ item.answer.answer }}</td>
                                        <td class="text-center">
                                            <span v-if="item.answer_key == 'yes'">Benar</span>
                                            <span v-else>Salah</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script type="text/javascript">
    Vue.component('detail-exam-component', {
        template: '#detailExamTemplate',
        props: {'isParentList': false},
        data() {
            return {
                url: '/exam',
                exam: {
                    id:'',
                    user: {},
                    package: {},
                    details: []
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
                            me.exam = resp.data.data;
                            me.exam.details = resp.data.data.details;
                        }
                    });
                else this.clear()
            },
            clearData() {
                this.id = null;
                this.exam = {
                    id:'',
                    user: {},
                    package: {},
                    details: []
                };
            },
            clear() {
                this.clearData();

                if (this.isParentList)
                    this.$parent.drawTable();
                $('#detail-exam-dialog').modal('hide');
            }
        }
    })
</script>