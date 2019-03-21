<template>
    <div class="table-responsive-sm">
        <slot :data="data" :page-number="pageNumber"></slot>

        <div class="row justify-content-between">
            <div class="col-sm-12 col-md-4">
                <div class="dataTables_info" id="basic-datatable_info" role="status" aria-live="polite">Showing 1 to 10 of 57 entries</div>
            </div>
            <div class="col-sm-12 col-md-6">
                <ul class="pagination pagination-rounded justify-content-end">
                    <li class="paginate_button page-item previous disabled">
                        <a href="#" aria-controls="basic-datatable" data-dt-idx="0" tabindex="0" class="page-link">
                            <i class="mdi mdi-chevron-left"></i>
                        </a>
                    </li>
                    <li class="paginate_button page-item active">
                        <a href="#" aria-controls="basic-datatable" data-dt-idx="1" tabindex="0" class="page-link">1</a>
                    </li>
                    <li class="paginate_button page-item next">
                        <a href="#" aria-controls="basic-datatable" data-dt-idx="7" tabindex="0" class="page-link">
                            <i class="mdi mdi-chevron-right"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
    // import filterBy from "../../utilities/filter-by.js";
    // import page from "../../utilities/page.js";

    export default {
        props: {
            source: {
                type: Array,
                default: () => []
            },
            pageSize: {
                type: Number,
                default: 25
            },
            filter: {
                type: String
            }
        },
        data() {
            return {
                index: 0
            };
        },
        computed: {
            pages() {
                let data = this.source;

                if (this.filter) {
                    data = filterBy(data, this.filter);
                }

                let pages = page(data, this.pageSize);

                // need to reset the page number if the data length changes
                // otherwise the index will be outside the bounds of the data
                if (this.pageNumber > pages.length) {
                    this.pageNumber = 1;
                }

                return pages;
            },
            pageNumber: {
                get() {
                    return this.index + 1;
                },
                set(value) {
                    this.index = value - 1;
                    this.$emit("page-changed", value);
                }
            },
            data() {
                return this.pages[this.index];
            }
        },
        methods: {
            movePrevious() {
                this.pageNumber -= this.pageNumber > 1 ? 1 : 0;
            },
            moveNext() {
                this.pageNumber += (this.pageNumber != this.pages.length) ? 1 : 0;
            },
            moveTo(pageNumber) {
                if (pageNumber > 0 && pageNumber <= this.pages.length) {
                    this.pageNumber = pageNumber;
                }
            }
        }

    }
</script>
