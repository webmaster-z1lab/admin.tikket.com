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
                    401: {
                        title: 'Acesso não permitido',
                        message: 'Oops! Você precisa estar autenticado para acessar esse recurso.',
                        icon: 'https://s3.us-east-2.amazonaws.com/cdn-z1lab/images/undraw/purple/undraw_security.svg',
                        redirect: 'https://tawk.to/chat/5b789d4dafc2c34e96e7b2ec/default'
                    },
                    403: {
                        title: 'Acesso negado',
                        message: 'Oops! Você não possui as credenciais necessárias para acessar esse recurso.',
                        icon: 'https://s3.us-east-2.amazonaws.com/cdn-z1lab/images/undraw/purple/undraw_security.svg',
                        redirect: 'https://tawk.to/chat/5b789d4dafc2c34e96e7b2ec/default'
                    },
                    404: {
                        title: 'Página não encontrada',
                        message: 'Oops! Você está em um link que não existe.',
                        icon: 'undraw_page_not_found_su7k.svg',
                        redirect: 'https://tawk.to/chat/5b789d4dafc2c34e96e7b2ec/default'
                    },
                    405: {
                        title: 'Método não permitido',
                        message: 'Oops! Essa recurso não pode ser acessado utilizando o método atual.',
                        icon: 'https://s3.us-east-2.amazonaws.com/cdn-z1lab/images/undraw/purple/undraw_be_the_hero.svg',
                        redirect: 'https://tawk.to/chat/5b789d4dafc2c34e96e7b2ec/default'
                    },
                    422: {
                        title: 'Entidade improcessável',
                        message: '',
                        icon: 'undraw_warning_cyit.svg',
                        redirect: 'https://tawk.to/chat/5b789d4dafc2c34e96e7b2ec/default'
                    },
                    500: {
                        title: 'Falha no servidor',
                        message: 'Uma perturbação na força causou uma falha no nosso sistema.',
                        icon: 'https://s3.us-east-2.amazonaws.com/cdn-z1lab/images/undraw/purple/undraw_may_the_force.svg',
                        redirect: 'https://tawk.to/chat/5b789d4dafc2c34e96e7b2ec/default'
                    },
                    503: {
                        title: 'Nós estamos realizando alguns ajustes',
                        message: 'Pedimos desculpas pela inconveniência mas o <strong>Tikket</strong> está passando por uma manuntenção programada.',
                        icon: 'https://s3.us-east-2.amazonaws.com/cdn-z1lab/template/front/2.0.1/svg/illustrations/maintenance-mode.svg',
                        redirect: 'https://tawk.to/chat/5b789d4dafc2c34e96e7b2ec/default'
                    }
                }

                return code[this.code]
            }
        }
    }
</script>
