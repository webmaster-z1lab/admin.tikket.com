<template>
    <div class="container-fluid">
        <div class="row">
            <sub-header />

            <div class="col-12">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-6">
                                        <h5 class="mt-0 text-truncate" title="Quant. Participantes">
                                            <i class="fas fa-users text-primary mr-1"></i>
                                            Quant. Participantes
                                        </h5>
                                        <h3 class="my-2 py-1">0</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-6">
                                        <h5 class="mt-0 text-truncate" title="Quant. Confimados">
                                            <i class="fas fa-users text-success mr-1"></i>
                                            Quant. Confimados
                                        </h5>
                                        <h3 class="my-2 py-1">0</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-6">
                                        <h5 class="mt-0 text-truncate" title="Quant. Cancelados">
                                            <i class="fas fa-users text-danger mr-1"></i>
                                            Quant. Cancelados
                                        </h5>
                                        <h3 class="my-2 py-1">0</h3>
                                    </div>
                                    <div class="col-6">
                                        <div class="text-right" style="position: relative;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!--<div class="col-12">-->
                <!--<div class="card">-->
                    <!--<div class="card-body">-->
                        <!--<h4 class="header-title">Pedidos</h4>-->
                        <!--<p class="text-muted font-14 mb-4">-->
                            <!--Lista de-->
                        <!--</p>-->

                        <!--<div class="table-responsive-sm">-->
                            <!--<div class="row justify-content-end">-->
                                <!--<div class="col-sm-12 col-md-6 col-xl-4">-->
                                    <!--<div class="form-group mb-3">-->
                                        <!--<label for="simpleinput">Text</label>-->
                                        <!--<input type="text" id="simpleinput" class="form-control">-->
                                    <!--</div>-->
                                <!--</div>-->
                            <!--</div>-->
                            <!--<div class="row my-2">-->
                                <!--<div class="col-12">-->
                                    <!--<table class="table table-striped table-centered mb-0">-->
                                        <!--<thead>-->
                                        <!--<tr>-->
                                            <!--<th>User</th>-->
                                            <!--<th>Account No.</th>-->
                                            <!--<th>Balance</th>-->
                                            <!--<th>Action</th>-->
                                        <!--</tr>-->
                                        <!--</thead>-->
                                        <!--<tbody>-->
                                        <!--<tr>-->
                                            <!--<td>-->
                                                <!--Risa D. Pearson-->
                                            <!--</td>-->
                                            <!--<td>AC336 508 2157</td>-->
                                            <!--<td>July 24, 1950</td>-->
                                            <!--<td class="table-action">-->
                                                <!--<a href="javascript: void(0);" class="action-icon"> <i class="mdi mdi-pencil"></i></a>-->
                                                <!--<a href="javascript: void(0);" class="action-icon"> <i class="mdi mdi-delete"></i></a>-->
                                            <!--</td>-->
                                        <!--</tr>-->
                                        <!--<tr>-->
                                            <!--<td>-->
                                                <!--Ann C. Thompson-->
                                            <!--</td>-->
                                            <!--<td>SB646 473 2057</td>-->
                                            <!--<td>January 25, 1959</td>-->
                                            <!--<td class="table-action">-->
                                                <!--<a href="javascript: void(0);" class="action-icon"> <i class="mdi mdi-pencil"></i></a>-->
                                                <!--<a href="javascript: void(0);" class="action-icon"> <i class="mdi mdi-delete"></i></a>-->
                                            <!--</td>-->
                                        <!--</tr>-->
                                        <!--<tr>-->
                                            <!--<td>-->
                                                <!--Paul J. Friend-->
                                            <!--</td>-->
                                            <!--<td>DL281 308 0793</td>-->
                                            <!--<td>September 1, 1939</td>-->
                                            <!--<td class="table-action">-->
                                                <!--<a href="javascript: void(0);" class="action-icon"> <i class="mdi mdi-pencil"></i></a>-->
                                                <!--<a href="javascript: void(0);" class="action-icon"> <i class="mdi mdi-delete"></i></a>-->
                                            <!--</td>-->
                                        <!--</tr>-->
                                        <!--<tr>-->
                                            <!--<td>-->
                                                <!--Sean C. Nguyen-->
                                            <!--</td>-->
                                            <!--<td>CA269 714 6825</td>-->
                                            <!--<td>February 5, 1994</td>-->
                                            <!--<td class="table-action">-->
                                                <!--<a href="javascript: void(0);" class="action-icon"> <i class="mdi mdi-pencil"></i></a>-->
                                                <!--<a href="javascript: void(0);" class="action-icon"> <i class="mdi mdi-delete"></i></a>-->
                                            <!--</td>-->
                                        <!--</tr>-->
                                        <!--</tbody>-->
                                    <!--</table>-->
                                <!--</div>-->
                            <!--</div>-->
                            <!--<div class="row justify-content-between">-->
                                <!--<div class="col-sm-12 col-md-4">-->
                                    <!--<div class="dataTables_info" id="basic-datatable_info" role="status" aria-live="polite">Showing 1 to 10 of 57 entries</div>-->
                                <!--</div>-->
                                <!--<div class="col-sm-12 col-md-6">-->
                                    <!--<ul class="pagination pagination-rounded justify-content-end">-->
                                        <!--<li class="paginate_button page-item previous disabled">-->
                                            <!--<a href="#" aria-controls="basic-datatable" data-dt-idx="0" tabindex="0" class="page-link">-->
                                                <!--<i class="mdi mdi-chevron-left"></i>-->
                                            <!--</a>-->
                                        <!--</li>-->
                                        <!--<li class="paginate_button page-item active">-->
                                            <!--<a href="#" aria-controls="basic-datatable" data-dt-idx="1" tabindex="0" class="page-link">1</a>-->
                                        <!--</li>-->
                                        <!--<li class="paginate_button page-item ">-->
                                            <!--<a href="#" aria-controls="basic-datatable" data-dt-idx="2" tabindex="0" class="page-link">2</a>-->
                                        <!--</li>-->
                                        <!--<li class="paginate_button page-item ">-->
                                            <!--<a href="#" aria-controls="basic-datatable" data-dt-idx="3" tabindex="0" class="page-link">3</a>-->
                                        <!--</li>-->
                                        <!--<li class="paginate_button page-item ">-->
                                            <!--<a href="#" aria-controls="basic-datatable" data-dt-idx="4" tabindex="0" class="page-link">4</a>-->
                                        <!--</li>-->
                                        <!--<li class="paginate_button page-item ">-->
                                            <!--<a href="#" aria-controls="basic-datatable" data-dt-idx="5" tabindex="0" class="page-link">5</a>-->
                                        <!--</li>-->
                                        <!--<li class="paginate_button page-item ">-->
                                            <!--<a href="#" aria-controls="basic-datatable" data-dt-idx="6" tabindex="0" class="page-link">6</a>-->
                                        <!--</li>-->
                                        <!--<li class="paginate_button page-item next">-->
                                            <!--<a href="#" aria-controls="basic-datatable" data-dt-idx="7" tabindex="0" class="page-link">-->
                                                <!--<i class="mdi mdi-chevron-right"></i>-->
                                            <!--</a>-->
                                        <!--</li>-->
                                    <!--</ul>-->
                                <!--</div>-->
                            <!--</div>-->
                        <!--</div>-->
                    <!--</div>-->
                <!--</div>-->
            <!--</div>-->

            <!--<paginator :source="rows" :page-size="4"></paginator>-->
        </div>
    </div>
</template>

<script>
    import SubHeader from '../../layouts/partials/sub-header'
    import Paginator from '../../../../../components/datatable/paginator'

    import {mapActions, mapState} from 'vuex'

    export default {
        name: "index",
        components: {
            Paginator,
            SubHeader
        },
        data: () => ({
            rows: [
                {
                    id: "0584e8d2-984c-4ce0-a20f-8b9e21cd2c00",
                    purchasor_name: "Nancy Fuller",
                    purchasor_email: "nfuller0@about.me",
                    purchase_date: "2002-01-02T04:45:48Z",
                    purchase_amount: 1166.14
                },
                {
                    id: "f4769183-38af-4c22-8383-6dea302466fd",
                    purchasor_name: "Melissa Meyer",
                    purchasor_email: "mmeyer1@angelfire.com",
                    purchase_date: "2010-05-15T08:13:59Z",
                    purchase_amount: 6123.50
                },
                {
                    id: "e171c9fb-2438-4f23-8d0d-011b2d8e95bc",
                    purchasor_name: "Larry Rose",
                    purchasor_email: "lrose2@cdbaby.com",
                    purchase_date: "2014-11-23T09:18:18Z",
                    purchase_amount: 8288.27
                },
                {
                    id: "3cad078d-083b-416e-9dd4-2f1470c3458d",
                    purchasor_name: "Jack Simpson",
                    purchasor_email: "jsimpson3@mayoclinic.com",
                    purchase_date: "2002-01-02T04:45:48Z",
                    purchase_amount: 1215.03
                },
                {
                    id: "ef7ff12c-90e5-4bfb-8fdd-9f20e4206afa",
                    purchasor_name: "Ernest Watson",
                    purchasor_email: "ewatson4@nytimes.com",
                    purchase_date: "2002-01-02T04:45:48Z",
                    purchase_amount: 9455.16
                },
                {
                    id: "b243be08-6b9c-4ebd-bb8b-b59256ad4956",
                    purchasor_name: "Adam Castillo",
                    purchasor_email: "acastillo5@dailymotion.com",
                    purchase_date: "2014-08-22T08:14:28Z",
                    purchase_amount: 9988.45
                },
                {
                    id: "a491adf5-8129-4f93-9442-98522fbd1e90",
                    purchasor_name: "Wayne Wilson",
                    purchasor_email: "wwilson6@indiegogo.com",
                    purchase_date: "2012-03-07T22:16:08Z",
                    purchase_amount: 4563.87
                },
                {
                    id: "497a6cca-5c9c-4b93-af8e-63c93de3eacf",
                    purchasor_name: "Roy Coleman",
                    purchasor_email: "rcoleman7@independent.co.uk",
                    purchase_date: "2010-09-14T05:05:17Z",
                    purchase_amount: 4563.87
                },
                {
                    id: "ea34a698-fb86-44a5-b80e-57087d48737c",
                    purchasor_name: "Betty Diaz",
                    purchasor_email: "bdiaz8@dropbox.com",
                    purchase_date: "2012-03-07T22:16:08Z",
                    purchase_amount: 7527.62
                },
                {
                    id: "c48e5e68-cae5-4a2e-96b2-8509fca19ddb",
                    purchasor_name: "Sharon Gardner",
                    purchasor_email: "sgardner9@seesaa.net",
                    purchase_date: "2004-10-14T14:59:00Z",
                    purchase_amount: 1166.14
                }
            ],
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
