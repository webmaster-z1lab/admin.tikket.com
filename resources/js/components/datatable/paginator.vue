<template>
    <div class="table-responsive-sm">
        <slot />

        <div class="row justify-content-between" v-if="active">
            <div class="col-sm-12 col-md-4">
                <div class="dataTables_info" id="basic-datatable_info">Mostrando de {{meta.from}} a {{meta.to}} de {{meta.total}} items</div>
            </div>
            <div class="col-sm-12 col-md-6">
                <ul class="pagination pagination-rounded justify-content-end">
                    <li class="paginate_button page-item previous" :class="links.prev ? '' : 'disabled'">
                        <button type="button" @click="changePage(links.prev)" class="page-link">
                            <i class="mdi mdi-chevron-left"></i>
                        </button>
                    </li>
                    <li class="paginate_button page-item" v-if="showPrevRange">
                        <a href="javascript:;" class="page-link">...</a>
                    </li>
                    <li class="paginate_button page-item" v-for="page in pages" :class="page === meta.current_page ? 'active' : ''">
                        <button type="button" class="page-link" @click="changePage(meta.path, {page: page})" v-if="page !== meta.current_page">{{page}}</button>
                        <button type="button" class="page-link" v-else>{{page}}</button>
                    </li>
                    <li class="paginate_button page-item" v-if="showNextRange">
                        <a href="javascript:;" class="page-link">...</a>
                    </li>
                    <li class="paginate_button page-item next" :class="links.next ? '' : 'disabled'">
                        <button type="button" @click="changePage(links.next)" class="page-link">
                            <i class="mdi mdi-chevron-right"></i>
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
    import {toSeek} from "../../vendor/common";

    export default {
        props: {
            active: {
                default: true
            },
            links: {
                required: true,
                default: () => ({
                    first: null,
                    last: null,
                    next: null,
                    prev: null
                })
            },
            meta: {
                required: true,
                default: () => ({
                    current_page: 0,
                    from: 0,
                    last_page: 0,
                    path: "",
                    per_page: 0,
                    to: 0,
                    total: 0
                })
            }
        },
        data() {
            return {
                range_pages: 10,
                containers: 0,
                current_containers: 0
            }
        },
        computed: {
            pages() {
                if (this.meta.last_page <= this.range_pages) {
                    return this.meta.last_page
                } else {
                    let arr = []

                    for(let i = 1; i <= this.meta.last_page; i++) {
                        if(_.isInteger(i / (this.range_pages - 1))) {
                            arr.push(i)
                            arr.push(i + 1)
                        }

                        arr.push(i)
                    }

                    this.containers = Math.ceil(this.meta.last_page / this.range_pages)
                    this.current_containers = Math.ceil(this.meta.current_page / (this.range_pages - 1))

                    return _.chunk(arr, this.range_pages)[(this.current_containers - 1)]
                }
            },
            showPrevRange() {
                return this.current_containers > 1
            },
            showNextRange() {
                return this.current_containers < this.containers
            }
        },
        methods: {
            changePage(page, params = null) {
                toSeek(page, params).then(
                    response => {
                        this.$emit('change-paginate', response)
                    }
                )
            }
        }
    }
</script>
