<template>
    <footer class="footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    © Tikket. {{dateYear}} Z1Lab
                </div>
                <div class="col-md-6">
                    <div class="text-md-right footer-links d-none d-md-block">
                        <a href="javascript: void(0);">Suporte</a>
                        <a href="javascript: void(0);">Termos de uso</a>
                        <a href="javascript: void(0);">Privacidade</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</template>

<script>
    import moment from 'moment'

    export default {
        name: 'footerPartial',
        computed: {
            dateYear() {
                return moment().format('YYYY')
            }
        }
    }
</script>
