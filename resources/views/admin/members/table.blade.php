<div class="row">
    <div class="col-sm-12">
        <table class="table align-middle datatable dt-responsive table-check nowrap dataTable no-footer  table-bordered" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
            <thead>
            <tr role="row">
                <th scope="col">
                    <div class="d-flex justify-content-between w-60px">
                        @sortablelink('gym_customer_id', __('system.members.id'), [], ['class' => 'w-100 text-gray'])
                    </div>
                </th>
                <th scope="col">
                    <div class="d-flex justify-content-between w-150px">
                        @sortablelink('name', __('system.fields.name'), [], ['class' => 'w-100 text-gray'])
                    </div>
                </th>

                <th scope="col">
                    <div class="d-flex justify-content-between w-100px">
                        @sortablelink('phone_number', __('system.fields.phone_number'), [], ['class' => 'w-100 text-gray'])
                    </div>
                </th>
                <th scope="col">
                    <div class="d-flex justify-content-between w-80px">
                        @sortablelink('join_date', __('system.members.join_date'), [], ['class' => 'w-100 text-gray'])
                    </div>
                </th>
                <th scope="col">
                    <div class="d-flex justify-content-between w-100px">
                        @sortablelink('package_end_date', __('system.members.package_end_date'), [], ['class' => 'w-100 text-gray'])
                    </div>
                </th>
                <th class="h-mw-80px">{{ __('system.fields.created_by') }}</th>
                <th class="h-mw-80px">{{ __('system.crud.action') }}</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($members as $member)
                <tr>
                    <td>{{ $member->gym_customer_id }}</td>
                    <td>
                        <p class="mb-0 font-size-12">{{ $member->name }}</p>
                        <p class="mb-0 badge bg-success"><small>{{$member->package->local_lang_name}}</small></p>
                    </td>
                    <td>{{ $member->phone_number }}</td>
                    <td>{{ $member->join_date }}</td>
                    <td>{{ $member->package_end_date }}</td>
                    <td>{{ $member->users->first_name }} {{ $member->users->last_name }}</td>
                    <td>
                        @can('delete members')
                            {!! html()->form('delete', route('admin.members.destroy', ['member' => $member->id]))
                             ->class('data-confirm')
                             ->attribute('autocomplete', 'off')
                             ->attribute('data-confirm-message', __('system.fields.are_you_sure'))
                             ->attribute('data-confirm-title', __('system.crud.delete'))
                             ->id('delete-form_' . $member->id)
                             ->open() !!}
                        @endcan

                        <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                            @can('edit members')
                                <a role="button" href="{{ route('admin.members.edit', ['member' => $member->id]) }}" class="btn btn-success">{{ __('system.crud.edit') }}</a>
                            @endcan
                            @can('delete members')
                                <button type="submit" class="btn btn-danger">{{ __('system.crud.delete') }}</button>
                            @endcan
                        </div>

                        @can('delete members')
                            {!! html()->closeModelForm() !!}
                        @endcan
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">
                        {{ __('system.crud.data_not_found', ['table' => __('system.members.menu')]) }}
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="row">
    {{ $members->links() }}
</div>
