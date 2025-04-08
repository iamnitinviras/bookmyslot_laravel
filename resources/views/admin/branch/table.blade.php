<div class="row">
    <div class="col-sm-12">
        <table class="table align-middle datatable dt-responsive table-check nowrap dataTable no-footer table-bordered" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
        <thead>
        <tr role="row">
            <th scope="col">
                <div class="d-flex justify-content-between">
                    @sortablelink('title', __('system.branch.title'), [], ['class' => 'w-100 text-gray'])
                </div>
            </th>
            <th scope="col">
                <div class="d-flex justify-content-between">
                    @sortablelink('phone', __('system.fields.phone_number'), [], ['class' => 'w-100 text-gray'])
                </div>
            </th>
            <th scope="col">
                <div class="d-flex justify-content-between">
                    @sortablelink('zip', __('system.fields.zip'), [], ['class' => 'w-100 text-gray'])
                </div>
            </th>
            <th class="w-mw-80px">{{ __('system.crud.action') }}</th>
        </tr>
        </thead>
            <tbody>
            @if(isset($branchs) && count($branchs)>0)
                @foreach($branchs as $branch)
                    <tr>
                        <td>{{ $branch->branch_title }}</td>
                        <td>{{ $branch->branch_phone }}</td>
                        <td>{{ $branch->zip }}</td>
                        <td>
                            @can('delete branch')
                                {!! html()->form('delete', route('admin.branch.destroy', ['branch' => $branch->id]))
                            ->class('data-confirm')
                            ->attribute('autocomplete', 'off')
                            ->attribute('data-confirm-message', __('system.fields.are_you_sure'))
                            ->attribute('data-confirm-title', __('system.crud.delete'))
                            ->id('delete-form_' . $branch->id)->open() !!}
                            @endif

                            <div class="btn-group btn-group-sm" role="group">
                                @can('edit branch')
                                    <a role="button" href="{{ route('admin.branch.edit', ['branch' => $branch->id]) }}" class="btn btn-success">{{ __('system.crud.edit') }}</a>
                                @endcan

                                @if(auth()->user()->branch!=null && auth()->user()->branch->id!=$branch->id)
                                    @can('delete branch')
                                        <button type="submit" class="btn btn-danger">{{ __('system.crud.delete') }}</button>
                                    @endcan
                                @endif
                            </div>

                            @can('delete branch')
                                    {!! html()->closeModelForm() !!}
                            @endif

                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="4" class="text-center">
                        {{ __('system.crud.data_not_found', ['table' => __('system.branch.title')]) }}
                    </td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>
</div>
<div class="row">
    {{ $branchs->links() }}
</div>
