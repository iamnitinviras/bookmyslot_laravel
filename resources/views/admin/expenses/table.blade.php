<div class="row">
    <div class="col-sm-12">
        <table class="table align-middle datatable dt-responsive table-check nowrap dataTable no-footer table-bordered" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
            <thead>
            <tr role="row">
                <th scope="col">
                    <div class="d-flex justify-content-between">
                        @sortablelink('title', __('system.fields.name'), [], ['class' => 'w-100 text-gray'])
                    </div>
                </th>
                <th scope="col">
                    {{__('system.expenses_categories.title')}}
                </th>
                <th scope="col">
                    <div class="d-flex justify-content-between">
                        @sortablelink('amount', __('system.expenses.amount'), [], ['class' => 'w-100 text-gray'])
                    </div>
                </th>
                <th scope="col">
                    <div class="d-flex justify-content-between">
                        @sortablelink('expense_date', __('system.expenses.date'), [], ['class' => 'w-100 text-gray'])
                    </div>
                </th>
                <th scope="col">
                    {{__('system.fields.created_by')}}
                </th>
                <th class="w-mw-80px">{{ __('system.crud.action') }}</th>
            </tr>
            </thead>
            <tbody>
            @if(isset($expenses) && count($expenses)>0)
                @foreach($expenses as $expense)
                    <tr>
                        <td>{{ $expense->title }}</td>
                        <td>{{isset($expense->category)?$expense->category->local_lang_name:""}}</td>
                        <td>{{displayCurrency($expense->amount)}}</td>
                        <td>{{formatDateOnly($expense->expense_date)}}</td>
                        <td>{{isset($expense->user)?$expense->user->first_name." ".$expense->user->last_name:""}}</td>
                        <td>
                            @can('delete expenses')
                                {!! html()->form('delete', route('admin.expenses.destroy', ['expense' => $expense->id]))
                            ->class('data-confirm')
                            ->attribute('autocomplete', 'off')
                            ->attribute('data-confirm-message', __('system.fields.are_you_sure'))
                            ->attribute('data-confirm-title', __('system.crud.delete'))
                            ->id('delete-form_' . $expense->id)->open() !!}
                            @endif

                            <div class="btn-group btn-group-sm" role="group">
                                @can('edit expenses')
                                    <a role="button" href="{{ route('admin.expenses.edit', ['expense' => $expense->id]) }}" class="btn btn-success">{{ __('system.crud.edit') }}</a>
                                @endcan

                                @can('delete expenses')
                                    <button type="submit" class="btn btn-danger">{{ __('system.crud.delete') }}</button>
                                @endcan
                            </div>

                            @can('delete expenses')
                                {!! html()->closeModelForm() !!}
                            @endcan

                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="6" class="text-center">
                        {{ __('system.crud.data_not_found', ['table' => __('system.expenses.title')]) }}
                    </td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>
</div>
