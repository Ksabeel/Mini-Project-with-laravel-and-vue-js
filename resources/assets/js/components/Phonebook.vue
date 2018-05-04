<template>
    <div class="container m-lg-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card card-default">
                    <div class="card-header bg-primary text-white">All Records <button class="btn btn-success btn-sm pull-right" data-toggle="modal" data-target="#addRecord"><i class="fa fa-plus"></i></button></div>

                    <div class="card-body">
                        <input type="text" class="form-control mb-3" placeholder="Search By Name" v-model="search" @keyup="searchRecord">
                        <table class="table">
                            <thead>
                                <tr class="text-center">
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="record in records.data" class="text-center">
                                    <th>{{ record.id }}</th>
                                    <td>{{ record.name }}</td>
                                    <td>{{ record.email }}</td>
                                    <td>{{ record.phone }}</td>
                                    <td>
                                        <button class="btn btn-outline-info btn-sm" data-toggle="modal" data-target="#viewRecord" @click="getRecord(record.id)"><i class="fa fa-eye"></i></button>

                                        <button class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#editRecord" @click="getRecord(record.id)"><i class="fa fa-edit"></i></button>

                                        <button class="btn btn-outline-danger btn-sm" @click="deleteRecord(record.id)"><i class="fa fa-trash"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-4 offset-4 mt-4">
                    <pagination :data="records" v-on:pagination-change-page="getResults"></pagination>
                </div>
            </div>
        </div>
    <div id="modal">
        <add-record @recordAdded="refreshRecord"></add-record>
        <edit-record :editRec="editRec" @recordUpdated="refreshRecord"></edit-record>
        <view-record :viewRec="editRec"></view-record>
    </div>
    </div>
</template>

<script>
Vue.component('pagination', require('laravel-vue-pagination'));
Vue.component('add-record', require('./Add.vue'));
Vue.component('edit-record', require('./Edit.vue'));
Vue.component('view-record', require('./View.vue'));
    export default {
        data() {
            return {
                records: {},
                editRec: {},
                errors: [],
                search: ''
            }
        },
        methods: {
            // Our method to GET results from a Laravel endpoint
            getResults(page) {
                if (typeof page === 'undefined') {
                    page = 1;
                }

                // Using vue-resource as an example
                axios.get('/records?page=' + page)
                    .then(response => this.records = response.data)
                    .catch(error => console.log(error))
            },
            refreshRecord(record) {
                this.records = record.data
            },
            getRecord(id) {
                axios.get('/records/'+id+'/edit')
                .then((response) => this.editRec = response.data)
                .catch((error) => this.errors = error.response.data.errors)
            },
            deleteRecord(id) {
                if (confirm("Are you sure, you want to delete this record.?")) {
                    axios.post('/records/'+id, {
                        id: id,
                        '_method': 'DELETE'
                    })
                    .then((response) => this.refreshRecord(response))
                    .catch((error) =>  console.log(error))
                } 
            }, 
            searchRecord() {
                if (this.search.length >= 3) {
                    axios.get('/records/search/'+this.search)
                    .then(response => this.records = response)
                    .catch(error => console.log(error))
                } else {
                    this.getResults();
                }
            }
        },
        created() {
            axios.get('/records')
            .then((response) => this.records = response.data)
            .catch((error) => console.log(error))
        }
    }
</script>
