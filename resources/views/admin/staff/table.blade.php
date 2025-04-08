<div class="row">
    <div class="col-sm-12">
        <table class="table align-middle datatable dt-responsive table-check nowrap dataTable no-footer  table-bordered" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
            <thead>
            <tr role="row">
                <th scope="col">
                    <div class="d-flex justify-content-between w-260px">
                        @sortablelink('first_name', __('system.fields.name'), [], ['class' => 'w-100 text-gray'])
                    </div>
                </th>
                <th scope="col">
                    <div class="d-flex justify-content-between w-260px">
                        @sortablelink('email', __('system.fields.email'), [], ['class' => 'w-100 text-gray'])
                    </div>
                </th>
                <th scope="col">
                    <div class="d-flex justify-content-between w-150px">
                        @sortablelink('phone_number', __('system.fields.phone_number'), [], ['class' => 'w-100 text-gray'])
                    </div>
                </th>
                <th scope="col">
                    <div class="d-flex justify-content-between w-150px">
                        @sortablelink('created_at', __('system.fields.created_at'), [], ['class' => 'w-100 text-gray'])
                    </div>
                </th>
                <th class="h-mw-80px">{{ __('system.crud.action') }}</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($users as $user)
                <tr>
                    <td>

                        @if ($user->profile_url != null)
                            <img data-src="{{ $user->profile_url }}" alt="" class="avatar-sm rounded-circle me-2 image-object-cover lazyload">
                        @else
                            <div class="avatar-sm d-inline-block align-middle me-2">
                                <div class="avatar-title bg-soft-primary text-primary font-size-18 m-0 rounded-circle font-weight-bold">
                                    {{ $user->logo_name }}
                                </div>
                            </div>
                        @endif
                        <span class="text-body">{{ $user->name }}</span>
                    </td>
                    <td>{{ $user->email }}</td>
                    <td>
                        {{ $user->phone_number }}
                    </td>
                    <td>
                        {{ $user->created_at }}
                    </td>
                    <td>
                        @can('delete staff')
                            {!! html()->form('delete', route('admin.staffs.destroy', ['staff' => $user->id]))
                             ->class('data-confirm')
                             ->attribute('autocomplete', 'off')
                             ->attribute('data-confirm-message', __('system.staffs.are_you_sure', ['name' => $user->name]))
                             ->attribute('data-confirm-title', __('system.crud.delete'))
                             ->id('delete-form_' . $user->id)
                             ->open() !!}
                        @endcan

                        <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                            <a role="button" href="{{ route('admin.staffs.show', ['staff' => $user->id]) }}" class="btn btn-secondary">{{ __('system.fields.view') }}</a>
                            @can('edit staff')
                                <a role="button" href="{{ route('admin.staffs.edit', ['staff' => $user->id]) }}" class="btn btn-success">{{ __('system.crud.edit') }}</a>
                            @endcan
                            @can('delete staff')
                                <button type="submit" class="btn btn-danger">{{ __('system.crud.delete') }}</button>
                            @endcan
                        </div>

                        @can('delete staff')
                            {!! html()->closeModelForm() !!}
                        @endcan
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">
                        {{ __('system.crud.data_not_found', ['table' => __('system.staffs.title')]) }}
                    </td>
                </tr>
            @endforelse

            </tbody>
        </table>


    </div>
</div>
<div class="row">
    {{ $users->links() }}
</div>
