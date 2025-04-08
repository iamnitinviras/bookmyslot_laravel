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
                    <div class="d-flex justify-content-between">
                        @sortablelink('status', __('system.fields.status'), [], ['class' => 'w-100 text-gray'])
                    </div>
                </th>
                <th class="w-mw-80px">{{ __('system.crud.action') }}</th>
            </tr>
            </thead>
            <tbody>
            @if(isset($expenses_categories) && count($expenses_categories)>0)
                @foreach($expenses_categories as $expense_category)
                    <tr>
                        <td>
                            {{ $expense_category->local_lang_name }}
                        </td>
                        <td>{!! displayStatus($expense_category->status) !!}</td>
                        <td>
                            @can('delete expenses_categories')
                                {!! html()->form('delete', route('admin.expense-categories.destroy', ['expense_category' => $expense_category->id]))
                            ->class('data-confirm')
                            ->attribute('autocomplete', 'off')
                            ->attribute('data-confirm-message', __('system.fields.are_you_sure'))
                            ->attribute('data-confirm-title', __('system.crud.delete'))
                            ->id('delete-form_' . $expense_category->id)->open() !!}
                            @endif

                            <div class="btn-group btn-group-sm" role="group">
                                @can('edit expenses_categories')
                                    <a role="button" href="{{ route('admin.expense-categories.edit', ['expense_category' => $expense_category->id]) }}" class="btn btn-success">{{ __('system.crud.edit') }}</a>
                                @endcan

                                @can('delete expenses_categories')
                                    <button type="submit" class="btn btn-danger">{{ __('system.crud.delete') }}</button>
                                @endcan
                            </div>

                            @can('delete expenses_categories')
                                {!! html()->closeModelForm() !!}
                            @endcan

                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="3" class="text-center">
                        {{ __('system.crud.data_not_found', ['table' => __('system.packages.title')]) }}
                    </td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>
</div>
