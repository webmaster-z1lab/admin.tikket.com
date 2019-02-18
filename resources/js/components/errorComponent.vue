<template>
    <div class="text-center">
        <figure class="mx-auto my-5">
            <img :src="`http://127.0.0.5:8000/svg/${errorMessage.icon}`" width="80%" alt="File not found Image">
        </figure>


        <h3 class="text-uppercase text-primary mt-3"><strong>{{code}} -</strong> {{errorMessage.title}}</h3>
        <h5 class="text-muted mt-3">{{errorMessage.message}}</h5>

        <a class="btn btn-primary mt-3" href="/evento/meus-eventos"><i class="mdi mdi-reply"></i> Voltar a Home</a>
    </div>
</template>

<script>
    export default {
        name: "VueError",
        props: {
            code: {
                required: true
            }
        },
        computed: {
            errorMessage() {
                const code = {
                    422: {
                        title: 'Entidade improcessável',
                        message: '',
                        icon: 'undraw_warning_cyit.svg'
                    },
                    404: {
                        title: 'Página não encontrada',
                        message: 'Oops! Você está em um link que não existe.',
                        icon: 'undraw_page_not_found_su7k.svg'
                    }
                }

                return code[this.code]
            }
        }
    }
</script>
