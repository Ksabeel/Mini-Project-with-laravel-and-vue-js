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
                                    <th v-text="record.id"></th>
                                    <td v-text="record.name"></td>
                                    <td v-text="record.email"></td>
                                    <td v-text="record.phone"></td>
                                    <td>
                                        <button class="btn btn-outline-info btn-sm" data-toggle="modal" data-target="#viewRecord" @click="get(record.id)"><i class="fa fa-eye"></i></button>

                                        <button class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#editRecord" @click="get(record.id)"><i class="fa fa-edit"></i></button>

                                        <button class="btn btn-outline-danger btn-sm" @click="remove(record.id)"><i class="fa fa-trash"></i></button>
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
            <create @recordAdded="refreshRecord"></create>
            <edit :editRec="editRec" @recordUpdated="refreshRecord"></edit>
            <show :viewRec="editRec"></show>
        </div>
    
    </div>
</template>

<script>
    import Pagination from 'laravel-vue-pagination'
    import Create from './Create'
    import Edit from './Edit'
    import Show from './Show'

    export default {
        data() {
            return {
                records: {},
                editRec: [],
                errors: [],
                search: ''
            }
        },

        components: {
            Pagination, Create, Edit, Show
        },

        methods: {
            getResults(page) {
                if (typeof page === 'undefined') {
                    page = 1;
                }

                axios.get(`/phonebooks?page=${page}`)
                    .then(response => this.records = response.data)
                    .catch(error => console.log(error))
            },

            refreshRecord(record) {
                this.records = record.data;
            },

            get(id) {
                axios.get(`/phonebooks/${id}/edit`)
                    .then(response => this.editRec = response.data)
                    .catch(error => this.errors = error.response.data.errors)
            },

            remove(id) {
                swal({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                })
                .then((result) => {
                    if (result.value) {
                        axios.delete(`/phonebooks/${id}`, { id })
                            .then(response => {
                                this.refreshRecord(response);

                                swal(
                                    'Deleted!',
                                    'Your file has been deleted.',
                                    'success'
                                )
                            })
                    }
                })
            },

            searchRecord() {
                if (this.search.length >= 3) {
                    axios.get(`/phonebooks/search/${this.search}`)
                        .then(response => this.records = response)
                        .catch(error => console.log(error))
                } else {
                    this.getResults();
                }
            }
        },

        created() {
            axios.get('/phonebooks')
                .then(response => this.records = response.data)
                .catch(error => console.log(error))
        }
    };
</script>
