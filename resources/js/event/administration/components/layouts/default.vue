<template>
    <div class="wrapper">
        <side-bar-partial />
        <div class="content-page">
            <div class="content">
                <header-partial />

                <slot />
            </div>
            <footer-partial />
        </div>
    </div>
</template>

<script>
    import SideBarPartial from './partials/sidebar'
    import HeaderPartial from './partials/header'
    import FooterPartial from './partials/footer'

    export default {
        name: 'LayoutDefault',
        components: {
            SideBarPartial,
            HeaderPartial,
            FooterPartial
        }
    }
</script>
