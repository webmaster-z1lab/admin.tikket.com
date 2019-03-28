<template>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <sub-header />

            <div :class="page === 'coupons' ? 'col-12' : 'col-8 justify-content-center'">
                <div class="card">
                    <component :is="page" @changePage="changePage"/>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import SubHeader from '../../layouts/partials/sub-header'
    import Coupons from './partials/coupons'
    import NewEditCoupon from './partials/new-edit-coupon'

    import {mapState} from 'vuex'

    export default {
        name: "coupon",
        $_veeValidate: {
            validator: 'new'
        },
        components: {
            SubHeader,
            Coupons,
            NewEditCoupon
        },
        data: () => ({
            page: 'coupons'
        }),
        computed: {
            ...mapState({
                event: state => state.event
            })
        },
        methods:{
            changePage(page) {
                this.page = page
            }
        }
    }
</script>
