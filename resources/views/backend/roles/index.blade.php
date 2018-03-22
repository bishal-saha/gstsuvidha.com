@extends('layouts.backend')
@section('title', 'Roles')
@section('page')
<div class="page" id="myApp">
    <div class="page-content">
        <!-- Panel -->
        <div class="panel">
            <div class="panel-body">
                <div class="container">
                    <div class="row">
                        <div class="col-md-4 page-title">
                            <span class="fontawesome"><i class="fas fa-users"></i></span>
                            <h1> All Roles</h1>
                        </div>
                        <div class="col-md-8 ">
                            <form action="{{ route('roles.index') }}" class="form-inline float-right" id="form_search" method="get">
                                <input type="hidden" name="sort" id="sort" value="{{ $sort }}">
                                <input type="hidden" name="order" id="order" value="{{ $order }}">
                                <div class="form-group">
                                    Show
                                    <select class="form-control mx-5" name="limit" id="limit">
                                        <option <?php echo ($limit==10)?'selected':''; ?>>10</option>
                                        <option <?php echo ($limit==25)?'selected':''; ?>>25</option>
                                        <option <?php echo ($limit==50)?'selected':''; ?>>50</option>
                                        <option <?php echo ($limit==100)?'selected':''; ?>>100</option>
                                    </select>
                                    Entries
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <input value="{{ $search }}" class="form-control" name="search" placeholder="Search..." type="text" required>
                                        <span class="input-group-btn">
                                            <button type="submit" class="btn btn-primary waves-effect waves-classic"><i class="icon md-search" aria-hidden="true"></i></button>
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <a href="{{ route('roles.index') }}">
                                            <button data-toggle="tooltip" data-original-title="Refresh" type="button" class="btn btn-icon btn-primary waves-effect waves-classic">
                                                <i class="icon md-refresh-alt" aria-hidden="true"></i>
                                            </button>
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover dataTable table-striped w-full dtr-inline">
                        <thead>
                            <tr>
                                <th width="1%">
                                    <span class="checkbox-custom checkbox-primary">
                                        <input v-model="selectAll" type="checkbox" data-toggle="tooltip" data-original-title="Select All" >
                                        <label for="select_all"></label>
                                    </span>
                                </th>
                                <th width="4%">
                                    <a @click="initDeleteAll" href="javascript:void(0);" class="delete_all" data-toggle="tooltip" data-original-title="Delete All" >
                                        <i class="far fa-trash-alt delete_all" aria-hidden="true"></i>
                                    </a>
                                </th>
                                <?php
                                    if($sort == 'name' && $order == 'asc') {
                                        $sort_class_name = 'sorting_asc';
                                    } else if($sort == 'name' && $order == 'desc') {
                                        $sort_class_name = 'sorting_desc';
                                    } else {
                                        $sort_class_name = 'sorting';
                                    }

                                    if($sort == 'created_at' && $order == 'asc') {
                                        $sort_class_registration = 'sorting_asc';
                                    } else if($sort == 'created_at' && $order == 'desc') {
                                        $sort_class_registration = 'sorting_desc';
                                    } else {
                                        $sort_class_registration = 'sorting';
                                    }
                                ?>
                                <th width="25%" class="{{ $sort_class_name }}" id="sort_name" onclick="sortFields('name','{{ ($order=='asc')?'desc':'asc' }}');"  data-toggle="tooltip" data-original-title="Sort by role">Role</th>
                                <th width="40%" id="sort_name">Permissions</th>
                                <th width="20%" class="{{ $sort_class_registration }}" id="sort_registration" onclick="sortFields('created_at','{{ ($order=='asc')?'desc':'asc' }}')" data-toggle="tooltip" data-original-title="Sort by registration date">Registration</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $limit_start = (($roles->currentPage() - 1) * $roles->perPage())+1;
                                $limit_end   = ($roles->currentPage() * $roles->perPage());
                                $row_id = $limit_start;
                                $roleIdArray = array(); // used to vue select all button
                            ?>
                            @foreach ($roles as $role)
                            <tr>
                                <td>
                                    <span class="checkbox-custom checkbox-primary">
                                        <input  v-model="selectedIds" type="checkbox" name="select_id" class="inputCheckbox selected_id" value="{{ $role->id }}">
                                        <label for="inputCheckbox"></label>
                                    </span>
                                </td>
                                <td>{{ $row_id }}</td>
                                <td>{{ $role->name }}</td>
                                <td>{{ $role->name }}</td>
                                <td>{{ $role->created_at->format('F d, Y h:ia') }}</td>
                                <td id="myNewApp">
                                    <button @click="initEdit({{ $role->id }})" data-toggle="tooltip" data-original-title="Edit"
                                            class="btn btn-md btn-icon btn-pure btn-primary on-default edit-row waves-effect waves-light waves-round float-left" title="Edit">
                                        <i class="far fa-edit" aria-hidden="true"></i>
                                    </button>
                                    <button type="button" @click="initDelete({{ $role->id }})" data-toggle="tooltip" data-original-title="Delete"
                                            class="btn btn-md btn-icon btn-pure btn-warning on-default edit-row waves-effect waves-light waves-round">
                                        <i class="far fa-trash-alt" aria-hidden="true"></i>
                                    </button>
                                </td>
                            </tr>
                            <?php $row_id++;?>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="container mt-30">
                    <div class="row">
                        <div class="col-md-3 vertical-align h-50 vertical-align-middle">
                            Showing <strong>{{ $limit_start }}</strong> to <strong>{{ ($limit_end>=$roles->total())?$roles->total():$limit_end }}</strong> of <strong>{{ $roles->total() }}</strong> entries
                        </div>
                        <div class="col-md-6">
                            {!! $roles->appends([
                                            'sort' => $sort,
                                            'order' => $order,
                                            'limit' => $limit,
                                            'search' => $search
                                            ])->links() !!}</div>
                        <div class="col-md-3 text-right vertical-align h-50 vertical-align-middle">
                            Page <strong>{{ $roles->currentPage() }}</strong> of <strong>{{ $roles->lastPage() }}</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div>
        <div class="fixed-bottom m-20">
            <button @click="initCreate()" type="button" class="btn-raised btn btn-info btn-floating waves-effect waves-classic vertical-align-bottom float-right block font-size-20">
                <i class="icon md-plus" aria-hidden="true"></i>
            </button>
        </div>
    </div>
    <!-- Modal  -->
    <div class="modal fade" id="modalCreate" aria-labelledby="modalCreatelLabel" role="dialog" tabindex="-1" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-simple">
            <form class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title" id="modalCreatelLabel">Add a New Role</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xl-12 alert alert-danger" v-if="errors.length > 0">
                            <ul>
                                <li v-for="error_data in errors">@{{ error_data }}</li>
                            </ul>
                        </div>
                        <div class="col-xl-12 form-group">
                            <h5>Role Name</h5>
                            <input v-model="role.name" class="form-control" name="name" id="name" placeholder="Name" type="text">
                        </div>
                        <div class="col-xl-12 form-group">
                            <h5>Permissions</h5>
                            <span v-for="permission in permissions" class="checkbox-custom checkbox-primary">
                                <input v-model="role_permissions" type="checkbox"  class="inputCheckbox" :id="permission.id" :value="permission.id">
                                <label for="inputCheckbox">@{{ permission.name }}</label>
                            </span>
                        </div>
                        <div class="col-md-12 float-right">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button @click="initStore" class="btn btn-primary waves-effect waves-classic" type="button">Submit</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="modal fade" id="modalEdit" aria-labelledby="modalCreatelLabel" role="dialog" tabindex="-1" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-simple">
            <form class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title" id="modalCreatelLabel">Edit</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xl-12 alert alert-danger" v-if="errors.length > 0">
                            <ul>
                                <li v-for="error_data in errors">@{{ error_data }}</li>
                            </ul>
                        </div>
                        <div class="col-xl-12 form-group">
                            <h5>Role Name</h5>
                            <input v-model="role.name" class="form-control" name="name" placeholder="Name" type="text">
                        </div>
                        <div class="col-xl-12 form-group">
                            <h5>Permissions</h5>
                            <span v-for="permission in permissions" class="checkbox-custom checkbox-primary">
                                <input v-model="role_permissions" type="checkbox"  class="inputCheckbox" id="permission.id" :value="permission.id">
                                <label for="inputCheckbox">@{{ permission.name }}</label>
                            </span>
                        </div>
                        <div class="col-md-12 float-right">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button @click="initUpdate" class="btn btn-primary waves-effect waves-classic" type="button">Submit</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- End Modal -->
    <!-- Modal Delete -->
    <div class="modal fade modal-primary" id="modalDelete" aria-labelledby="exampleModalPrimary" role="dialog" tabindex="-1" style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title">Please Confirm...</h4>
                </div>
                <div class="modal-body">
                    <p>Do you really wants to delete the record?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-pure waves-effect waves-classic" data-dismiss="modal">No</button>
                    <button @click="initDestroy(delete_id)" type="button" class="btn btn-primary waves-effect waves-classic">Yes</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal Delete -->
    <!-- Modal Delete All -->
    <div class="modal fade modal-primary" id="modalDeleteAll" aria-labelledby="exampleModalPrimary" role="dialog" tabindex="-1" style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title">Please Confirm...</h4>
                </div>
                <div class="modal-body">
                    <p>Do you really wants to delete the selected records?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-pure waves-effect waves-classic" data-dismiss="modal">No</button>
                    <button @click="initDestroyAll" type="button" class="btn btn-primary waves-effect waves-classic">Yes</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal Delete All -->
</div>

@endsection

@section('extra-footer')
    <script>
        var rowIds = [];
        $.each($("input[name='select_id']"), function() {
            rowIds.push($(this).val());
        });

        new Vue({
            el: '#myApp',
            data() {
                return {
                    role: {
                        name: ''
                    },
                    permissions: {},
                    role_permissions: [],
                    errors: [],
                    selectedIds: [],
                    rowIdArray: rowIds,
                    delete_id: '0',
                }
            },
            mounted() {
                //this.readTasks();
            },
            computed: {
                selectAll: {
                    get: function () {
                        return this.rowIdArray ? this.selectedIds.length == this.rowIdArray.length : false;
                    },
                    set: function (value) {
                        let selected = [];

                        if (value) {
                            this.rowIdArray.forEach(function (value) {
                                selected.push(value.toString());
                            });
                        }
                        this.selectedIds = selected;
                    }
                }
            },
            methods: {
                initCreate() {
                    this.errors = [];

                    axios.get('/permissions/list')
                        .then(response => {
                            this.permissions = response.data;
                        })
                        .catch(e => {
                            this.errors.push(e)
                        })
                    $('#modalCreate').modal('show');
                },
                initStore() {
                    axios.post("{{ route('roles.store') }}", {
                        name: this.role.name,
                        permissions: this.role_permissions,
                    })
                        .then(response => {
                            window.location = response.data.redirectTo;
                        })
                        .catch(error => {
                            this.errors = [];
                            if (error.response.data.errors.name) {
                                this.errors.push(error.response.data.errors.name[0]);
                            }

                            if (error.response.data.errors.permissions) {
                                this.errors.push(error.response.data.errors.permissions[0]);
                            }
                        });
                },
                initEdit(index) {
                    this.errors = [];

                    axios.get('/roles/'+index)
                        .then(response => {
                            // JSON responses are automatically parsed.
                            this.role = response.data.role;
                            this.permissions = response.data.permissions;
                            this.role_permissions = response.data.role_permissions;
                        })
                        .catch(e => {
                            this.errors.push(e)
                        })
                    $('#modalEdit').modal('show');
                },
                initUpdate() {
                    axios.patch('/roles/' + this.role.id, {
                        name: this.role.name,
                        permissions: this.role_permissions,
                    })
                        .then(response => {
                            window.location = response.data.redirectTo;
                        })
                        .catch(error => {
                            this.errors = [];
                            if (error.response.data.errors.name) {
                                this.errors.push(error.response.data.errors.name[0]);
                            }

                            if (error.response.data.errors.permissions) {
                                this.errors.push(error.response.data.errors.permissions[0]);
                            }
                        });
                },
                initDelete(index) {
                    this.delete_id = index;
                    $('#modalDelete').modal('show');
                },
                initDestroy(index) {
                    axios.delete('/roles/' + index)
                        .then(response => {
                            window.location = response.data.redirectTo;
                        })
                        .catch(error => {

                        });
                },
                initDeleteAll() {
                    if(this.selectedIds.length) {
                        $('#modalDeleteAll').modal('show');
                    }
                },
                initDestroyAll() {
                    $('#modalDelete').modal('show');
                    axios.delete('/roles/0', { params: {
                        delete_ids: this.selectedIds,
                    }
                    })
                        .then(response => {
                            window.location = response.data.redirectTo;
                        })
                        .catch(error => {

                        });
                },
                reset() {
                    this.task.name = '';
                    this.task.description = '';
                },
            }
        });


        $(document).ready( function() {
            $('#limit').change( function () {
                $('#form_search').submit();
            });
        });

        function sortFields(name, order) {
            $('#sort').val(name);
            $('#order').val(order);
            $('#form_search').submit();
        }
    </script>
@endsection