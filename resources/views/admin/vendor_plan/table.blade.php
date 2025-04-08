<div class="row">
    <div class="col-sm-12">
        <table class="table align-middle datatable dt-responsive table-check nowrap dataTable no-footer  table-bordered" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
            <thead>
            <tr role="row">
                <th scope="col">
                    <div class="d-flex justify-content-between w-50px">
                        @sortablelink('plan_id', __('system.crud.id'), [], ['class' => 'w-100 text-gray'])
                    </div>

                </th>
                <th scope="col">
                    <div class="d-flex justify-content-between w-260px">
                        @sortablelink('amount', __('system.fields.name'), [], ['class' => 'w-100 text-gray'])
                    </div>
                </th>
                <th scope="col">
                    <div class="d-flex justify-content-between w-260px">
                        @sortablelink('amount', __('system.plans.amount'), [], ['class' => 'w-100 text-gray'])
                    </div>
                </th>
                <th scope="col">
                    <div class="d-flex justify-content-between w-150px">
                        @sortablelink('type', __('system.plans.type'), [], ['class' => 'w-100 text-gray'])
                    </div>
                </th>
                <th class="h-mw-80px">{{ __('system.crud.action') }}</th>
            </tr>
            </thead>
            <tbody>
                @if(isset($reports) && count($reports)>0)
                    @foreach($reports as $reports)
                        <tr>
                            <th scope="row" class="sorting_1">{{ $plan->plan_id }}</th>
                            <td>{{ $plan->local_title }}</td>
                            <td>{{ $plan->amount }}</td>
                            <td>{{ trans('system.plans.' . $plan->type) }}</td>
                            <td>
                                @if (auth()->user()->user_type == App\Models\User::USER_TYPE_ADMIN)
                                    {{ Form::open(['route' => ['admin.plans.destroy', ['plan' => $plan->plan_id]], 'autocomplete' => 'off', 'class' => 'data-confirm', 'data-confirm-message' => __('system.users.are_you_sure', ['name' => $plan->name]), 'data-confirm-title' => __('system.crud.delete'), 'id' => 'delete-form_' . $plan->id, 'method' => 'delete']) }}
                                @endif

                                <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                    <a role="button" href="{{ route('admin.plans.edit', ['plan' => $plan->plan_id]) }}" class="btn btn-success">{{ __('system.crud.edit') }}</a>
                                    <button type="submit" class="btn btn-danger">{{ __('system.crud.delete') }}</button>
                                </div>
                                @if (auth()->user()->user_type == App\Models\User::USER_TYPE_ADMIN)
                                    {{ Form::close() }}
                                @endif
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="6" class="text-center">
                            {{ __('system.crud.data_not_found', ['table' => __('system.plans.menu')]) }}
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
