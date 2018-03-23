@extends('layouts.backend')
@section('title', 'Users')
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
                            <h1> Manage Users</h1>
                        </div>
                        <div class="col-md-8 ">
                            <form action="{{ route('users.index') }}" class="form-inline float-right" id="form_search" method="get">
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
                                        <a href="{{ route('users.index') }}">
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
                                <th width="20%" class="{{ $sort_class_name }}" id="sort_name" onclick="sortFields('name','{{ ($order=='asc')?'desc':'asc' }}');"  data-toggle="tooltip" data-original-title="Sort by name">Name</th>
                                <th width="20%" class="{{ $sort_class_name }}" id="sort_name" onclick="sortFields('email','{{ ($order=='asc')?'desc':'asc' }}');"  data-toggle="tooltip" data-original-title="Sort by email">Email</th>
                                <th width="20%">Role</th>
                                <th width="20%" class="{{ $sort_class_registration }}" id="sort_registration" onclick="sortFields('created_at','{{ ($order=='asc')?'desc':'asc' }}')" data-toggle="tooltip" data-original-title="Sort by registration date">Registration</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $limit_start = (($users->currentPage() - 1) * $users->perPage())+1;
                                $limit_end   = ($users->currentPage() * $users->perPage());
                                $row_id = $limit_start;
                            ?>
                            @foreach ($users as $user)
                            <tr>
                                <td>
                                    <span class="checkbox-custom checkbox-primary">
                                        <input  v-model="selectedIds" type="checkbox" name="select_id" class="inputCheckbox selected_id" value="{{ $user->id }}">
                                        <label for="inputCheckbox"></label>
                                    </span>
                                </td>
                                <td>{{ $row_id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>Role</td>
                                <td>{{ $user->created_at->format('F d, Y h:ia') }}</td>
                                <td>
                                    <button @click="initEdit({{ $user->id }})" data-toggle="tooltip" data-original-title="Edit"
                                            class="btn btn-md btn-icon btn-pure btn-primary on-default edit-row waves-effect waves-light waves-round float-left" title="Edit">
                                        <i class="far fa-edit" aria-hidden="true"></i>
                                    </button>
                                    <button type="button" @click="initDelete({{ $user->id }})" data-toggle="tooltip" data-original-title="Delete"
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
                            Showing <strong>{{ $limit_start }}</strong> to <strong>{{ ($limit_end>=$users->total())?$users->total():$limit_end }}</strong> of <strong>{{ $users->total() }}</strong> entries
                        </div>
                        <div class="col-md-6">
                            {!! $users->appends([
                                            'sort' => $sort,
                                            'order' => $order,
                                            'limit' => $limit,
                                            'search' => $search
                                            ])->links() !!}</div>
                        <div class="col-md-3 text-right vertical-align h-50 vertical-align-middle">
                            Page <strong>{{ $users->currentPage() }}</strong> of <strong>{{ $users->lastPage() }}</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div>
        <div class="fixed-bottom popupButton">
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
                    <h4 class="modal-title" id="modalCreatelLabel">Add a New User</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xl-12" v-if="errors.length > 0">
                            <div v-for="error_data in errors" class="alert alert-danger alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                                @{{ error_data }}
                            </div>
                        </div>
                        <div class="col-xl-12 form-group">
                            <h5>Name</h5>
                            <input v-model="user.name" class="form-control" name="name" id="name" placeholder="Name" type="text">
                        </div>

                        <div class="col-xl-12 form-group">
                            <h5>Email</h5>
                            <input v-model="user.email" class="form-control" name="email" id="email" placeholder="Email" type="email" required>
                        </div>
                        <div class="col-xl-12 form-group">
                            <h5>Password</h5>
                            <input v-model="user.password" class="form-control" name="password" id="password" placeholder="Password" type="password" required>
                        </div>
                        <div class="col-xl-12 form-group">
                            <h5>Assign Role</h5>
                            <span v-for="role in roles" class="checkbox-custom checkbox-primary">
                                <input v-model="assigned_roles" type="checkbox"  class="inputCheckbox" id="role.id" :value="role.id">
                                <label for="inputCheckbox">@{{ role.name }}</label>
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
                        <div class="col-xl-12" v-if="errors.length > 0">
                            <div v-for="error_data in errors" class="alert alert-danger alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                                @{{ error_data }}
                            </div>
                        </div>
                        <div class="col-xl-12 form-group">
                            <h5>Name</h5>
                            <input v-model="user.name" class="form-control" name="name" id="name" placeholder="Name" type="text">
                        </div>

                        <div class="col-xl-12 form-group">
                            <h5>Email</h5>
                            <input v-model="user.email" class="form-control" name="email" id="email" placeholder="Email" type="email" required>
                        </div>
                        <div class="col-xl-12 form-group">
                            <h5>Password</h5>
                            <input v-model="user.password" class="form-control" name="password" id="password" placeholder="Password" type="password" required>
                        </div>
                        <div class="col-xl-12 form-group">
                            <h5>Assign Role</h5>
                            <span v-for="role in roles" class="checkbox-custom checkbox-primary">
                                <input v-model="assigned_roles" type="checkbox"  class="inputCheckbox" id="role.id" :value="role.id">
                                <label for="inputCheckbox">@{{ role.name }}</label>
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
                    <p>Do you really wants to delete this user?</p>
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
                    <p>Do you really wants to delete the selected users?</p>
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
                    user: {
                        name: '',
                        email: '',
                        password: '',
                    },
                    roles: [],
                    assigned_roles: [],
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
                    this.reset();
                    axios.get("{{ route('roles.list') }}")
                        .then(response => {
                            this.roles = response.data;
                        })
                        .catch(e => {
                            this.errors.push(e)
                        });
                    $('#modalCreate').modal('show');
                },
                initStore() {
                    this.errors = [];
                    axios.post("{{ route('users.store') }}", {
                        name: this.user.name,
                        email: this.user.email,
                        password: this.user.password,
                        roles: this.assigned_roles,
                    })
                        .then(response => {
                            window.location = response.data.redirectTo;
                        })
                        .catch(error => {
                            this.errors = [];
                            if (error.response.data.errors.name) {
                                this.errors.push(error.response.data.errors.name[0]);
                            }
                            if (error.response.data.errors.email) {
                                this.errors.push(error.response.data.errors.email[0]);
                            }
                            if (error.response.data.errors.password) {
                                this.errors.push(error.response.data.errors.password[0]);
                            }
                        });
                },
                initEdit(index) {
                    this.errors = [];
                    this.reset();
                    axios.get('/users/'+index)
                        .then(response => {
                            // JSON responses are automatically parsed.
                            this.user = response.data.user;
                            this.roles = response.data.roles;
                            let myArray = this.assigned_roles;
                            if (response.data.user.roles) {
                                response.data.user.roles.forEach(function (selectedRoles) {
                                    myArray.push(selectedRoles.id.toString());
                                });
                            }
                            this.assigned_roles = myArray;
                        })
                        .catch(e => {
                            this.errors.push(e)
                        })
                    $('#modalEdit').modal('show');
                },
                initUpdate() {
                    axios.patch('/users/' + this.user.id, {
                        name: this.user.name,
                        email: this.user.email,
                        password: this.user.password,
                        roles: this.assigned_roles,
                    })
                        .then(response => {
                            window.location = response.data.redirectTo;
                        })
                        .catch(error => {
                            this.errors = [];
                            if (error.response.data.errors.name) {
                                this.errors.push(error.response.data.errors.name[0]);
                            }
                            if (error.response.data.errors.email) {
                                this.errors.push(error.response.data.errors.email[0]);
                            }
                            if (error.response.data.errors.password) {
                                this.errors.push(error.response.data.errors.password[0]);
                            }
                        });
                },
                initDelete(index) {
                    this.delete_id = index;
                    $('#modalDelete').modal('show');
                },
                initDestroy(index) {
                    axios.delete('/users/' + index)
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
                    axios.delete('/users/0', { params: {
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
                    this.user.name = '';
                    this.user.email = '';
                    this.user.password = '';
                    this.assigned_roles = [];
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