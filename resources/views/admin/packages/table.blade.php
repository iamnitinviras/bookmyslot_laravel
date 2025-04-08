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
                        @sortablelink('price', __('system.fields.price'), [], ['class' => 'w-100 text-gray'])
                    </div>
                </th>
                <th scope="col">
                    <div class="d-flex justify-content-between">
                        @sortablelink('number_of_months', __('system.fields.number_of_months'), [], ['class' => 'w-100 text-gray'])
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
            @if(isset($packages) && count($packages)>0)
                @foreach($packages as $package)
                    <tr>
                        <td>
                            {{ $package->local_lang_name }}
                        </td>
                        <td>{{$package->price}}</td>
                        <td>{{$package->number_of_months}}</td>
                        <td>{!! displayStatus($package->status) !!}</td>
                        <td>
                            @can('delete packages')
                                {!! html()->form('delete', route('admin.packages.destroy', ['package' => $package->id]))
                            ->class('data-confirm')
                            ->attribute('autocomplete', 'off')
                            ->attribute('data-confirm-message', __('system.fields.are_you_sure'))
                            ->attribute('data-confirm-title', __('system.crud.delete'))
                            ->id('delete-form_' . $package->id)->open() !!}
                            @endif

                            <div class="btn-group btn-group-sm" role="group">
                                @can('edit packages')
                                    <a role="button" href="{{ route('admin.packages.edit', ['package' => $package->id]) }}" class="btn btn-success">{{ __('system.crud.edit') }}</a>
                                @endcan

                                @can('delete packages')
                                    <button type="submit" class="btn btn-danger">{{ __('system.crud.delete') }}</button>
                                @endcan
                            </div>

                            @can('delete packages')
                                {!! html()->closeModelForm() !!}
                            @endcan

                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="5" class="text-center">
                        {{ __('system.crud.data_not_found', ['table' => __('system.packages.title')]) }}
                    </td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>
</div>
