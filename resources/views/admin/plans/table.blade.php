<div class="row">
    <div class="col-sm-12 table-responsive">
        <table class="table align-middle datatable dt-responsive table-check nowrap dataTable no-footer  table-bordered"
            id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
            <thead>
                <tr role="row">
                    <th scope="col">
                        <div class="d-flex justify-content-between w-50px">
                            @sortablelink('plan_id', __('system.crud.id'), [], ['class' => 'w-100 text-gray'])
                        </div>
                    </th>
                    <th scope="col">
                        <div class="d-flex justify-content-between">
                            @sortablelink('title', __('system.fields.name'), [], ['class' => 'w-100 text-gray'])
                        </div>
                    </th>
                    <th scope="col">
                        <div class="d-flex justify-content-between ">
                            @sortablelink('amount', __('system.plans.amount'), [], ['class' => 'w-100 text-gray'])
                        </div>
                    </th>
                    <th scope="col">
                        <div class="d-flex justify-content-between">
                            @sortablelink('type', __('system.plans.type'), [], ['class' => 'w-100 text-gray'])
                        </div>
                    </th>
                    <th class="h-mw-80px">{{ __('system.crud.action') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($plans as $key => $plan)
                    <tr>
                        <th scope="row" class="sorting_1">{{ $plan->plan_id }}</th>
                        <td>{{ $plan->local_title }}</td>
                        <td>{{ displayCurrency($plan->amount) }}</td>
                        <td>{{ trans('system.plans.' . $plan->type) }}</td>
                        <td>
                            @if (auth()->user()->user_type == App\Models\User::USER_TYPE_ADMIN)
                                {!! html()->form('DELETE', route('admin.plans.destroy', ['plan' => $plan->plan_id]))
                                ->id('delete-form_' . $plan->id)
                                ->class('data-confirm')
                                ->attribute('autocomplete', 'off')
                                ->attribute('data-confirm-message', __('system.plans.are_you_sure', ['name' => $plan->local_title]))
                                ->attribute('data-confirm-title', __('system.crud.delete'))->open() !!}
                            @endif

                            <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                <a role="button"
                                    href="{{ route('admin.plans.edit', ['plan' => $plan->plan_id]) }}"
                                    class="btn btn-success">{{ __('system.crud.edit') }}</a>
                                <button type="submit" class="btn btn-danger">{{ __('system.crud.delete') }}</button>
                            </div>
                            @if (auth()->user()->user_type == App\Models\User::USER_TYPE_ADMIN)
                                    {!! html()->closeModelForm() !!}
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">
                            {{ __('system.crud.data_not_found', ['table' => __('system.plans.menu')]) }}
                        </td>
                    </tr>
                @endforelse

            </tbody>
        </table>
    </div>
</div>
