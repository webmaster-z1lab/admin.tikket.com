<template>


    <div class="paginator">
        <div class="paginator-body">

        </div>
        <div class="paginator-footer" layout="row center-justify">
            <div class="paginator-button paginator-page-previous" @click="movePrevious">
                <span>Prev</span>
            </div>
            <div class="paginator-page-numbers">
                <div class="paginator-button paginator-page-number" :class="{ 'active': num === pageNumber }" v-for="num in pages.length" @click="moveTo(num)">
                    <span>{{ num }}</span>
                </div>
            </div>
            <div class="paginator-button paginator-page-next" @click="moveNext">
                <span>Next</span>
            </div>
        </div>
    </div>


    <div id="datatables" class="container">
        <h1>Vue.JS Advanced Datatable Component</h1>
        <p>
            This is an early demonstration of the datatable component as part of the vuetiful component framework. The component (and
            the framework) isn't complete yet but this will give you an idea of where I'm headed with it. If you have any feedback
            or suggestions please open an issue on the GitHub repo. This is the successor to the version I wrote for Vue 1.x.
            You can see the original datatable <a href="https://codepen.io/andrewcourtice/pen/VabXQV" target="_blank">here</a>.
        </p>
        <p>
            <a href="https://github.com/andrewcourtice/vuetiful" target="_blank">Vuetiful Repo on GitHub</a>
        </p>
        <p>
            The datatable has the following features:
        <ul>
            <li>Sorting</li>
            <li>Multi-column grouping</li>
            <li>Filtering</li>
            <li>Real-time editing</li>
            <li>Custom filter/formatter support</li>
            <li>Custom aggregate functions (min, max, total etc.)</li>
            <li>Custom column header templates</li>
            <li>Custom cell templates (for both view and edit modes)</li>
        </ul>
        </p>
        <p>
            This component makes no assumptions about your architecture, design, and app functionality. It is completely customizable and very easy to use.
        </p>
        <h3>How to use</h3>
        <p>
            Click column headers to sort by that column (click again to change sort direction). You can filter the table's data by typing in the textbox at the bottom of the table. Drag a column to the middle of the table to group by that column. The grouping sequence will be displayed at the top of the table. Click the <strong>x</strong> on the group to stop grouping by that column. Full documentation is available <a href="https://github.com/andrewcourtice/vuetiful/tree/master/src/components/datatable" target="_blank">here</a>.
        </p>
        <div>
            <h3>Configuration</h3>
            <p>
                Use this table to see real-time editing of the column names, widths, sorting, grouping and the calculation of totals. You can also toggle edit mode and line numbers.
            </p>
            <div class="grid-row" layout="row top-stretch">
                <div class="grid-cell">
                    <toggle id="striped" v-model="customers.striped" data-intro="Toggle alternate row colouring on or off for all datatables" data-step="1">Striped</toggle>
                    <toggle id="line-numbers" v-model="customers.lineNumbers" data-intro="Toggle line numbers on or off for all datatables" data-step="2">Line Numbers</toggle>
                    <toggle id="editable" v-model="customers.editable" data-intro="Toggle edit mode for all datatables" data-step="3">Editable</toggle>
                </div>
            </div>
            <div class="grid-row" layout="row top-stretch">
                <div class="grid-cell">
                    <datatable id="data-table-options" :source="customers.columns" :filterable="false" editable>
                        <datatable-column id="label" label="Column Name" width="25"></datatable-column>
                        <datatable-column id="width" label="Width"></datatable-column>
                        <datatable-column id="sortable" label="Sortable" data-intro="Clicking a column will sort by that column" data-step="4"></datatable-column>
                        <datatable-column id="groupable" label="Groupable" data-intro="Drag a column into the middle of the table to group by that column. You can repeat this process to perform nested grouping" data-step="5"></datatable-column>
                        <template slot="sortable" scope="cell">
                            <div class="datatable-options-toggle">
                                <toggle :id="cell.row.id + '-sortable'" v-model="cell.row.sortable"></toggle>
                            </div>
                        </template>
                        <template slot="groupable" scope="cell">
                            <div class="datatable-options-toggle">
                                <toggle :id="cell.row.id + '-groupable'" v-model="cell.row.groupable"></toggle>
                            </div>
                        </template>
                    </datatable>
                </div>
            </div>
        </div>
        <div>
            <h3>Basic Example</h3>
            <p>
                This is a basic example of the datatable component. As you can see from the source (in the editor view) the amount of markup and script required use the datatable is minimal.
            </p>
            <div class="grid-row" layout="row top-stretch">
                <div class="grid-cell">
                    <datatable id="data-table-main"
                               :source="customers.rows"
                               :striped="customers.striped"
                               :editable="customers.editable"
                               :line-numbers="customers.lineNumbers">
                        <datatable-column
                                v-for="column in customers.columns"
                                :id="column.id"
                                :label="column.label"
                                :width="column.width"
                                :sortable="column.sortable"
                                :groupable="column.groupable"
                                :aggregators="column.aggregators"
                                :formatter="column.formatter">
                        </datatable-column>
                    </datatable>
                </div>
            </div>
        </div>
        <div>
            <h3>Custom Cell and Header Templates</h3>
            <p>
                This example shows how you can leverage the flexibility of the datatable's custom templating features to create selectable items. This technique can be used to cater for most custom templating requirements you may have.
            </p>
            <div class="grid-row" layout="row top-stretch">
                <div class="grid-cell">
                    <h4>Main datatable</h4>
                    <datatable id="data-table-main"
                               :source="customers.rows"
                               :striped="customers.striped"
                               :editable="customers.editable"
                               :line-numbers="customers.lineNumbers">
                        <datatable-column id="sel" label="sel" width="3.25rem" class="checkable-column" :sortable="false" :groupable="false" data-intro="Use custom cell tamplates to put your own content in cells" data-step="6">
                            <checkbox id="sel-all" v-model="selectAll"></checkbox>
                        </datatable-column>
                        <datatable-column
                                v-for="column in customers.columns"
                                :id="column.id"
                                :label="column.label"
                                :width="column.width"
                                :sortable="column.sortable"
                                :groupable="column.groupable"
                                :formatter="column.formatter">
                        </datatable-column>
                        <datatable-column id="actions" label="Actions" :sortable="false" :groupable="false"></datatable-column>
                        <template slot="sel" scope="cell">
                            <div class="checkable-column">
                                <checkbox :id="cell.row.id" :value="cell.row" v-model="customers.selected"></checkbox>
                            </div>
                        </template>
                        <template slot="actions" scope="cell">
                            <a @click="deleteCustomer(cell.row)">Delete Customer</a>
                        </template>
                    </datatable>
                </div>
            </div>
            <div class="grid-row" layout="row top-stretch">
                <div class="grid-cell">
                    <h4>Selected Items</h4>
                    <datatable id="data-table-selected" :source="customers.selected">
                        <datatable-column
                                v-for="column in customers.columns"
                                :id="column.id"
                                :label="column.label"
                                :width="column.width"
                                :formatter="column.formatter">
                        </datatable-column>
                    </datatable>
                </div>
            </div>
        </div>
        <div>
            <h3>Formatting</h3>
            <div class="grid-row" layout="row top-stretch">
                <div class="grid-cell">
                    <datatable id="data-table-options" :source="formatters" :filterable="false" editable data-intro="Apply different formatters to data to customize how your data is displayed" data-step="7">
                        <datatable-column id="name" label="Name" width="33" :sortable="false" :groupable="false"></datatable-column>
                        <datatable-column id="format" label="Format" :sortable="false" :groupable="false"></datatable-column>
                        <template slot="format" scope="cell">
                            <div v-if="cell.row.id === 'C'">
                                <select v-model.lazy="customers.currency">
                                    <option :value="code" v-for="(symbol, code) in currencies">{{ code }} ({{ symbol }})</option>
                                </select>
                            </div>
                            <div v-else>
                                <select v-model.lazy="customers.dateFormat">
                                    <option :value="format" v-for="format in dateFormats">{{ format }}</option>
                                </select>
                            </div>
                        </template>
                    </datatable>
                </div>
            </div>
            <div class="grid-row" layout="row top-stretch">
                <div class="grid-cell">
                    <datatable id="data-table-main"
                               :source="customers.rows"
                               :striped="customers.striped"
                               :editable="customers.editable"
                               :line-numbers="customers.lineNumbers">
                        <datatable-column
                                v-for="column in customers.columns"
                                :id="column.id"
                                :label="column.label"
                                :width="column.width"
                                :sortable="column.sortable"
                                :groupable="column.groupable"
                                :formatter="column.formatter">
                        </datatable-column>
                    </datatable>
                </div>
            </div>
        </div>
        <div>
            <h3>Aggregation</h3>
            <p>
                You can use custom aggregate functions to calculate values such as min, max, total etc. Vuetiful comes with built-in functions such as min, max, total, average, median, variance and standard deviation. You aren't limited to just the built-in functions however. Check out the documentation in the Vuetiful repo to see how to write your own custom aggregator to use with the datatable.
            </p>
            <div class="grid-row" layout="row top-stretch">
                <div class="grid-cell">
                    <datatable id="data-table-options" :source="customers.columns" :filterable="false" editable data-intro="Use custom aggregate functions to calculate values such as min, max, total etc." data-step="8">
                        <datatable-column id="label" label="Column Name" width="25"></datatable-column>
                        <datatable-column id="min" label="Min"></datatable-column>
                        <datatable-column id="max" label="Max"></datatable-column>
                        <datatable-column id="average" label="Average (mean)"></datatable-column>
                        <datatable-column id="median" label="Median"></datatable-column>
                        <datatable-column id="total" label="Total"></datatable-column>
                        <template slot="min" scope="cell">
                            <div class="datatable-options-toggle">
                                <toggle :id="cell.row.id + 'min'" :value="aggregators.min" v-model="cell.row.aggregators"></toggle>
                            </div>
                        </template>
                        <template slot="max" scope="cell">
                            <div class="datatable-options-toggle">
                                <toggle :id="cell.row.id + 'max'" :value="aggregators.max" v-model="cell.row.aggregators"></toggle>
                            </div>
                        </template>
                        <template slot="average" scope="cell">
                            <div class="datatable-options-toggle">
                                <toggle :id="cell.row.id + 'average'" :value="aggregators.average" v-model="cell.row.aggregators"></toggle>
                            </div>
                        </template>
                        <template slot="median" scope="cell">
                            <div class="datatable-options-toggle">
                                <toggle :id="cell.row.id + 'median'" :value="aggregators.median" v-model="cell.row.aggregators"></toggle>
                            </div>
                        </template>
                        <template slot="total" scope="cell">
                            <div class="datatable-options-toggle">
                                <toggle :id="cell.row.id + 'total'" :value="aggregators.total" v-model="cell.row.aggregators"></toggle>
                            </div>
                        </template>
                    </datatable>
                </div>
            </div>
            <div class="grid-row" layout="row top-stretch">
                <div class="grid-cell">
                    <datatable id="data-table-main"
                               :source="customers.rows"
                               :striped="customers.striped"
                               :editable="customers.editable"
                               :line-numbers="customers.lineNumbers">
                        <datatable-column
                                v-for="column in customers.columns"
                                :id="column.id"
                                :label="column.label"
                                :width="column.width"
                                :sortable="column.sortable"
                                :groupable="column.groupable"
                                :aggregators="column.aggregators"
                                :formatter="column.formatter">
                        </datatable-column>
                    </datatable>
                </div>
            </div>
        </div>
        <div>
            <h3>Pagination</h3>
            <p>
                This example shows how you can use the paginator component to page data before it's bound to the datatable. The paginator can be used to page data for any child component, not just a datatable. You can even filter the paginated data. Type into the textbox below to filter the paginated data.

                <strong>Note:</strong> The styling on the paginator isn't finished yet.
            </p>
            <div class="grid-row" layout="row top-stretch">
                <div class="grid-cell" layout="row">
                    <input type="text" placeholder="Type here to filter paginated data" self="size-x1" v-model="customers.filter" data-intro="You can filter the data in a datatable by typing in any of the filter fields" data-step="9" data-position="top">
                </div>
            </div>
            <div class="grid-row" layout="row top-stretch">
                <div class="grid-cell">
                    <paginator :source="customers.rows" :page-size="4" :filter="customers.filter" data-intro="Use the paginator to page data for easier viewing" data-step="10" data-position="top">
                        <template scope="page">
                            <datatable id="data-table-main"
                                       :source="page.data"
                                       :filterable="false"
                                       :striped="customers.striped"
                                       :editable="customers.editable"
                                       :line-numbers="customers.lineNumbers">
                                <datatable-column
                                        v-for="column in customers.columns"
                                        :id="column.id"
                                        :label="column.label"
                                        :width="column.width"
                                        :sortable="column.sortable"
                                        :groupable="column.groupable"
                                        :formatter="column.formatter">
                                </datatable-column>
                            </datatable>
                        </template>
                    </paginator>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    var aggregators = vuetiful.aggregators;
    var formatters = vuetiful.formatters;
    var currencies = vuetiful.maps.currencies;

    var customers = {
        striped: true,
        editable: false,
        lineNumbers: false,
        filter: null,

        currency: "USD",
        dateFormat: "D MMMM YYYY",

        columns: [
            {
                id: "purchasor_name",
                label: "Client Name",
                width: null,
                sortable: true,
                groupable: true,
                aggregators: []
            },
            {
                id: "purchasor_email",
                label: "Client Email",
                width: 25,
                sortable: true,
                groupable: true,
                aggregators: []
            },
            {
                id: "purchase_date",
                label: "Purchase Date",
                width: null,
                sortable: true,
                groupable: true,
                aggregators: [
                    aggregators.min,
                    aggregators.max
                ],
                formatter: function (value) {
                    return formatters.datetime(value, customers.dateFormat);
                }
            },
            {
                id: "purchase_amount",
                label: "Purchase Amount",
                width: null,
                sortable: true,
                groupable: true,
                aggregators: [
                    aggregators.min,
                    aggregators.max,
                    aggregators.total
                ],
                formatter: function (value) {
                    return formatters.currency(value, 2, customers.currency);
                }
            }
        ],

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

        selected: []
    };

    new Vue({
        el: "#datatables",

        data: function () {
            return {
                customers: customers,
                currencies: currencies,
                aggregators: aggregators,
                dateFormats: [
                    "DD/MM/YYYY",
                    "DD MMM YYYY",
                    "D MMMM YYYY",
                    "D/MM/YYYY h:mm a"
                ],
                formatters: [
                    { id: "C", name: "Currency" },
                    { id: "DT", name: "Date and Time" }
                ]
            };
        },
        computed: {
            selectAll: {
                get: function () {
                    return customers.selected.length == customers.rows.length;
                },
                set: function (value) {
                    customers.selected = value ? customers.rows : [];
                }
            }
        },
        methods: {
            deleteCustomer: function(customer) {
                var result = window.confirm("You are about to delete " + customer.purchasor_name + ". Are you sure?");

                if (result) {
                    var index = customers.rows.indexOf(customer);

                    if (index === -1) {
                        return;
                    }
                    customers.rows.splice(index, 1);
                }
            }
        },
        mounted() {
            setTimeout(function() {
                introJs().start();
            }, 1000);
        }
    });
</script>

<style>
    h1 {
        margin-top: 0.25em;
    }

    a {
        cursor: pointer;
    }

    .container {
        padding: 1rem 0;
    }

    .datatable-options-toggle {
        padding: 0.5rem 1rem;
    }

    .checkable-column {
        text-align: center;

        .checkbox {
            margin: 0;
        }
    }

    .paginator {

        .datatable {
            border: none;
        }
    }
</style>
