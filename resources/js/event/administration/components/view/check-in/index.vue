<template>
    <div class="container-fluid">
        <div class="row">
            <sub-header />

            <div class="col-12">
                <div class="text-center mt-2">
                    <figure class="mx-auto mb-4">
                        <img :src="'images/undraw/undraw_warning_cyit.svg' | aws_url" alt="SVG" width="40%">
                    </figure>

                    <div class="mb-4">
                        <h1 class="h3"><strong>Página em Construção!</strong></h1>

                        <p class="h5">Estamos trabalhando o mais rápido possível para disponibilizar essa funcionalidade! Em breve tudo estará pronto.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import SubHeader from '../../layouts/partials/sub-header'
    import {mapActions, mapState} from 'vuex'

    export default {
        name: "index",
        components: {
            SubHeader
        },
        data: () => ({

        }),
        computed: {
            ...mapState({
                event: state => state.event
            })
        },
        methods: {
            ...mapActions(['changeEvent'])
        }
    }
</script>
