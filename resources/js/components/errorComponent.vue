<template>
    <div class="text-center">
        <img src="assets/images/file-searching.svg" height="90" alt="File not found Image">

        <h1 class="text-error mt-4">{{code}}</h1>
        <h4 class="text-uppercase text-danger mt-3">{{errorMessage.title}}</h4>
        <p class="text-muted mt-3">{{errorMessage.message}}</p>

        <a class="btn btn-info mt-3" href="/"><i class="mdi mdi-reply"></i> Voltar a Home</a>
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
            errorMessage(){
                const code = {
                    422: {
                        title: 'Entidade improcessável',
                        message: ''
                    },
                    404: {
                        title: 'Página não encontrada',
                        message: 'Oops! Você está em um link que não existe.'
                    }
                }

                return code[this.code]
            }
        }
    }
</script>
