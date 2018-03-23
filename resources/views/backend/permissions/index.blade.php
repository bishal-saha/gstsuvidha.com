@extends('layouts.backend')
@section('title', 'Permissions')
@section('page')
<div class="page" id="myApp">
    <div class="page-content">
        <!-- Panel -->
        <div class="panel">
            <div class="panel-body">
                <div class="container">
                    <div class="row">
                        <div class="col-md-4 page-title">
                            <span class="fontawesome"><i class="fas fa-cog"></i></span>
                            <h1>Permissions</h1>
                        </div>
                        <div class="col-md-8 ">
                            <form action="{{ route('permissions.index') }}" class="form-inline float-right" id="form_search" method="get">
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
                                        <a href="{{ route('permissions.index') }}">
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
                                <th width="65%" class="{{ $sort_class_name }}" id="sort_name" onclick="sortFields('name','{{ ($order=='asc')?'desc':'asc' }}');"  data-toggle="tooltip" data-original-title="Sort by role">Name</th>
                                <th width="20%" class="{{ $sort_class_registration }}" id="sort_registration" onclick="sortFields('created_at','{{ ($order=='asc')?'desc':'asc' }}')" data-toggle="tooltip" data-original-title="Sort by registration date">Registration</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $limit_start = (($permissions->currentPage() - 1) * $permissions->perPage())+1;
                                $limit_end   = ($permissions->currentPage() * $permissions->perPage());
                                $row_id = $limit_start;
                                $roleIdArray = array(); // used to vue select all button
                            ?>
                            @foreach ($permissions as $permission)
                            <tr>
                                <td>
                                    <span class="checkbox-custom checkbox-primary">
                                        <input  v-model="selectedIds" type="checkbox" name="select_id" class="inputCheckbox selected_id" value="{{ $permission->id }}">
                                        <label for="inputCheckbox"></label>
                                    </span>
                                </td>
                                <td>{{ $row_id }}</td>
                                <td>{{ $permission->name }}</td>
                                <td>{{ $permission->created_at->format('F d, Y h:ia') }}</td>
                                <td id="myNewApp">
                                    <button @click="initEdit({{ $permission->id }})" data-toggle="tooltip" data-original-title="Edit"
                                            class="btn btn-md btn-icon btn-pure btn-primary on-default edit-row waves-effect waves-light waves-round float-left" title="Edit">
                                        <i class="far fa-edit" aria-hidden="true"></i>
                                    </button>
                                    <button type="button" @click="initDelete({{ $permission->id }})" data-toggle="tooltip" data-original-title="Delete"
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
                            Showing <strong>{{ $limit_start }}</strong> to <strong>{{ ($limit_end>=$permissions->total())?$permissions->total():$limit_end }}</strong> of <strong>{{ $permissions->total() }}</strong> entries
                        </div>
                        <div class="col-md-6">
                            {!! $permissions->appends([
                                            'sort' => $sort,
                                            'order' => $order,
                                            'limit' => $limit,
                                            'search' => $search
                                            ])->links() !!}</div>
                        <div class="col-md-3 text-right vertical-align h-50 vertical-align-middle">
                            Page <strong>{{ $permissions->currentPage() }}</strong> of <strong>{{ $permissions->lastPage() }}</strong>
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
                    <h4 class="modal-title" id="modalCreatelLabel">Add New</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xl-12 alert alert-danger" v-if="errors.length > 0">
                            <ul>
                                <li v-for="error_data in errors">@{{ error_data }}</li>
                            </ul>
                        </div>
                        <div class="col-xl-12 form-group">
                            <h5>Permissions Name</h5>
                            <input v-model="permission.name" class="form-control" name="name" id="name" placeholder="Name" type="text" required>
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
                            <h5>Permission Name</h5>
                            <input v-model="permission.name" class="form-control" name="name" placeholder="Name" type="text" required>
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
                    <p>Do you really wants to delete this record?</p>
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
        let rowIds = [];
        $.each($("input[name='select_id']"), function() {
            rowIds.push($(this).val());
        });

        new Vue({
            el: '#myApp',
            data() {
                return {
                    permission: {
                        name: ''
                    },
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
                    $('#modalCreate').modal('show');
                },
                initStore() {
                    axios.post("{{ route('permissions.store') }}", {
                        name: this.permission.name
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

                    axios.get('/permissions/'+index)
                        .then(response => {
                            // JSON responses are automatically parsed.
                            this.permission = response.data.permission;
                        })
                        .catch(e => {
                            this.errors.push(e)
                        })
                    $('#modalEdit').modal('show');
                },
                initUpdate() {
                    axios.patch('/permissions/' + this.permission.id, {
                        name: this.permission.name,
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
                    axios.delete('/permissions/' + index)
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
                    axios.delete('/permissions/0', { params: {
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
                    this.permissions.name = '';
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