<template>
    <div class="card-body">
        <div class="card-widgets">
            <button type="button" class="btn btn-icon btn-primary btn-sm" @click="access()">
                <i class="fas fa-plus"></i> Criar Nível de Acesso
            </button>
        </div>
        <h4 class="card-title mb-0">Nível de Acesso</h4>

        <div class="table-responsive-sm mt-3">
            <table class="table table-striped table-centered mb-0">
                <thead>
                <tr>
                    <th>Email</th>
                    <th>Nível de Acesso</th>
                    <th>Confirmado</th>
                    <th class="text-center">Ações</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="index in accesses">
                    <td>{{index.attributes.email}}</td>
                    <td>
                        {{index.attributes.name}}
                    </td>
                    <td>
                        true
                    </td>
                    <td class="table-action text-center">
                        <a href="javascript:;" class="action-icon" @click="deleteAccess(index)">
                            <i class="mdi mdi-delete"></i>
                        </a>
                    </td>
                </tr>
                </tbody>
            </table>

            <div class="text-center mt-2" v-if="checkAccess">
                <figure class="mx-auto mb-4">
                    <img :src="'images/undraw/undraw_control_panel1_20gm.svg'| aws_url" alt="SVG"
                         width="20%">
                </figure>

                <div class="mb-4">
                    <h1 class="h3"><strong>Nenhum nível de acesso foi cadastrado</strong></h1>

                    <p class="h5">Caso tenha o desejo de possuir PDV, Organizadores e Check-in deverá precisar adicionar niveis de accesso!</p>

                    <button type="button" @click="access()" class="btn btn-icon btn-primary">
                        Adicionar Nível de Acesso
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import swal from 'sweetalert2'

    import {mapActions, mapState} from 'vuex'
    import {sendAPIDELETE, exceptionError, sendAlert} from "../../../../../../vendor/common"

    export default {
        name: "accesses",
        computed: {
            ...mapState({
                event: state => state.event,
                accesses: state => state.panel.accesses
            }),
            checkAccess() {
                return _.isEmpty(this.accesses)
            }
        },
        created(){
              this.setAccesses(`${process.env.MIX_API_VERSION_ENDPOINT}/events/${this.event.id}/permissions`)
        },
        methods: {
            ...mapActions(['setAccesses', 'changeLoading']),
            access() {
                this.$emit('changePage', 'new-access')
            },
            deleteAccess(access){
                swal({
                    title: 'Você tem certeza?',
                    text: "Ao fazer isso o nível de acesso será apagado e qualquer que o tenha recebido não terá mais acesso!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sim, apagar!'
                }).then((result) => {
                    if (result.value) {
                        this.changeLoading(true)

                        sendAPIDELETE(`${process.env.MIX_API_VERSION_ENDPOINT}/events/${this.event.id}/permissions/${access.id}`, {})
                            .then(response => {
                                sendAlert({
                                    title: 'Tudo Certo!',
                                    message: 'Acesso removido.',
                                    type: 'success'
                                })

                                this.setAccesses(`${process.env.MIX_API_VERSION_ENDPOINT}/events/${this.event.id}/permissions`)
                            })
                            .catch((error) => {
                                this.changeLoading(false)
                                exceptionError(error)
                            })
                    }
                })
            }
        }
    }
</script>
