<template>
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <a href="/" class="btn btn-warning btn-sm">Voltar a Home</a>

                <slot />
            </div>

            <h4 class="page-title">Novo Evento</h4>
        </div>
    </div>
</template>

<script>
    import moment from 'moment'

    export default {
        name: 'subHeaderPartial',
        computed: {
            dateYear() {
                return moment().format('YYYY')
            }
        }
    }
</script>
