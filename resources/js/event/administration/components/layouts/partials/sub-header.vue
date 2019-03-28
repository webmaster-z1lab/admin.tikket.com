<template>
    <div class="col-12 mb-3">
        <div class="page-title-box">
            <div class="page-title-right">
                <slot />
            </div>

            <h3 class="page-title">{{event.attributes.name}}</h3>
            <p>
                <i class="fas fa-project-diagram" :class="statusEvent.color"></i> <strong :class="statusEvent.color">{{statusEvent.name}}</strong>
                <i class="far fa-calendar-alt ml-2"></i> {{event.attributes.starts_at}} - {{event.attributes.finishes_at}}
                <i class="fas fa-map-marked-alt ml-2"></i> {{event.attributes.address.formatted}}
            </p>
        </div>
    </div>
</template>

<style>
    .page-title-box .page-title {
        font-size: 1.5rem;
        margin: 0;
        line-height: 70px;
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
        color: inherit;
    }
</style>

<script>
    import moment from 'moment'
    import {mapState} from 'vuex'

    export default {
        name: 'subHeaderPartial',
        computed: {
            ...mapState({
                event: state => state.event
            }),
            dateYear() {
                return moment().format('YYYY')
            },
            statusEvent() {
                let translate = {
                    completed: {
                        name: 'Aguardando Publicação',
                        color: 'text-primary'
                    },
                    draft: {
                        name: 'Rascunho',
                        color: 'text-info'
                    },
                    finalized: {
                        name: 'Evento Finalizado',
                        color: 'text-secondary'
                    },
                    canceled: {
                        name: 'Evento Cancelado',
                        color: 'text-danger'
                    },
                    published: {
                        name: 'Evento Publicado',
                        color: 'text-success'
                    }
                }

                return translate[this.event.attributes.status]
            }
        }
    }
</script>
