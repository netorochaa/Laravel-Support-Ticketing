@extends('layouts.admin')
@section('content')
    @can('ticket_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route('admin.tickets.create') }}">
                    {{ trans('global.add') }} {{ trans('cruds.ticket.title_singular') }}
                </a>
            </div>
        </div>
    @endcan
    <div class="card">
        <div class="card-header">
            {{ trans('cruds.ticket.title_singular') }} {{ trans('global.list') }}
        </div>

        <div class="card-body">
            <form class="form-inline mb-2" id="filtersForm">
                <div class="form-row">
                    <div class="form-group">
                        <label for="min">Data inicial</label>
                        <input type="text" id="min" class="form-control form-control-sm ml-1" name="min" value="@if (session('filters')) {{ session('filters')['min'] ?? '' }} @endif">
                    </div>
                    <div class="form-group ml-2">
                        <label for="min">Data Final</label>
                        <input type="text" id="max" class="form-control form-control-sm ml-1" name="max" value="@if (session('filters')) {{ session('filters')['max'] ?? '' }} @endif">
                    </div>
                    <div class="form-group ml-2">
                        <select class="form-control custom-select-sm" name="status">
                            <option value="">Todos pendentes</option>
                            @foreach ($statuses as $status)
                                <option 
                                    value="{{ $status->id }}" 
                                    @if (session('filters')) {{ session('filters')['status'] == $status->id ? 'selected' : '' }} @endif>
                                    {{ $status->name }}
                                </option>
                            @endforeach
                        </select>            
                    </div>    
                    <div class="form-group ml-2">
                        <select class="form-control custom-select-sm" name="priority">
                            <option value="">Todas prioridades</option>
                            @foreach ($priorities as $priority)
                                <option value="{{ $priority->id }}" @if (session('filters')) {{ session('filters')['priority'] == $priority->id ? 'selected' : '' }} @endif>
                                    {{ $priority->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group ml-2">
                        <select class="form-control custom-select-sm" name="category">
                            <option value="">Todas categorias</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @if (session('filters')) {{ session('filters')['category'] == $category->id ? 'selected' : '' }} @endif>
                                    {{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    @if (session('filters'))
                        <button type="button" class="btn btn-warning btn-sm ml-2">
                            <a class="text-dark" href="{{ route('admin.tickets.clearFilters') }}">Limpar
                                filtros</a>
                        </button>
                    @endif
                </div>
            </form>
            <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-Ticket">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.ticket.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.ticket.fields.title') }}
                        </th>
                        <th>
                            {{ trans('cruds.ticket.fields.created_at') }}
                        </th>
                        <th>
                            {{ trans('cruds.ticket.fields.status') }}
                        </th>
                        <th>
                            {{ trans('cruds.ticket.fields.priority') }}
                        </th>
                        <th>
                            {{ trans('cruds.ticket.fields.category') }}
                        </th>
                        <th>
                            {{ trans('cruds.ticket.fields.author_name') }}
                        </th>
                        <th>
                            {{ trans('cruds.ticket.fields.author_email') }}
                        </th>
                        @if (Auth::user()->email == 'newdsonguedes@hotmail.com' || Auth::user()->email == 'zelia@roseannedore.com.br' || Auth::user()->isAdmin())
                            <th>
                                Valor
                            </th>
                        @endif
                        <th>
                            {{ trans('cruds.ticket.fields.assigned_to_user') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
            </table>


        </div>
    </div>
@endsection
@section('scripts')
    @parent
    <script>
        $(function() {
            $('.card-body').on('change', function() {
                $('#filtersForm').submit();
            })

            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)

            @can('ticket_delete')
                let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
                let deleteButton = {
                    text: deleteButtonTrans,
                    url: "{{ route('admin.tickets.massDestroy') }}",
                    className: 'btn-danger',
                    action: function (e, dt, node, config) {
                        var ids = $.map(dt.rows({ selected: true }).data(), function (entry) {
                            return entry.id
                        });
                
                        if (ids.length === 0) {
                            alert('{{ trans('global.datatables.zero_selected') }}')
                    
                            return
                        }
                
                        if (confirm('{{ trans('global.areYouSure') }}')) {
                            $.ajax({
                                headers: {'x-csrf-token': _token},
                                method: 'POST',
                                url: config.url,
                                data: { ids: ids, _method: 'DELETE' }})
                            .done(function () { location.reload() })
                        }
                    }
                }
                dtButtons.push(deleteButton)
            @endcan
            let dtOverrideGlobals = {
                buttons: dtButtons,
                processing: true,
                serverSide: true,
                retrieve: true,
                aaSorting: [],
                columns: [{
                        data: 'placeholder',
                        name: 'placeholder'
                    },
                    {
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'title',
                        name: 'title',
                        render: function(data, type, row) {
                            return '<a href="' + row.view_link + '">' + data + ' (' + row
                                .comments_count + ')</a>';
                        }
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        render: function(data, type, row) {
                            let objDate = new Date(data);
                            let formatDate = (objDate.getFullYear() + "-" + ((objDate.getMonth() + 1) <
                                    10 ? "0" + (objDate.getMonth() + 1) : (objDate.getMonth() + 1)
                                ) + "-" + objDate.getDate() + " " + objDate.getHours() + ":" +
                                objDate.getMinutes());
                            return '<small>' + formatDate + '</small>';
                        }
                    },
                    {
                        data: 'status_name',
                        name: 'status.name',
                        render: function(data, type, row) {
                            return '<span style="color:' + row.status_color + '">' + data + '</span>';
                        }
                    },
                    {
                        data: 'priority_name',
                        name: 'priority.name',
                        render: function(data, type, row) {
                            return '<span style="color:' + row.priority_color + '">' + data + '</span>';
                        }
                    },
                    {
                        data: 'category_name',
                        name: 'category.name',
                        render: function(data, type, row) {
                            return '<span style="color:' + row.category_color + '">' + data + '</span>';
                        }
                    },
                    {
                        data: 'author_name',
                        name: 'author_name'
                    },
                    {
                        data: 'author_email',
                        name: 'author_email'
                    },
                    @if (Auth::user()->email == 'newdsonguedes@hotmail.com' || Auth::user()->email == 'zelia@roseannedore.com.br' || Auth::user()->isAdmin())
                        { data: 'value', name: 'value' },
                    @endif {
                        data: 'assigned_to_user_name',
                        name: 'assigned_to_user.name'
                    },
                    {
                        data: 'actions',
                        name: '{{ trans('global.actions') }}'
                    }
                ],
                order: [
                    [1, 'desc']
                ],
                pageLength: 100,
            };
            // $(".datatable-Ticket").one("preInit.dt", function() {
            //     $(".dataTables_filter").after(filters);
            // });
            $('.datatable-Ticket').DataTable(dtOverrideGlobals);
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });
            $.extend(true, $.fn.dataTable.defaults, {
                order: [
                    [1, 'desc']
                ],
                pageLength: 100,
            });
            $('.datatable-Ticket:not(.ajaxTable)').DataTable({
                buttons: dtButtons
            })
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });

            var minDate, maxDate;

            minDate = new DateTime($('#min'), {
                format: 'DD MMM YYYY'
            });
            maxDate = new DateTime($('#max'), {
                format: 'DD MMM YYYY'
            });
        });
    </script>
@endsection
