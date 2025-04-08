<div class="row">
    <div class="col-sm-12">
        <table class="table align-middle datatable dt-responsive table-check nowrap dataTable no-footer  table-bordered" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
            <thead>
            <tr role="row">
                <th scope="col">
                    <div class="d-flex justify-content-between w-100px">
                        @sortablelink('name', __('system.fields.name'), [], ['class' => 'w-100 text-gray'])
                    </div>
                </th>
                <th scope="col">
                    <div class="d-flex justify-content-between w-100px">
                        @sortablelink('phone_number', __('system.fields.phone_number'), [], ['class' => 'w-100 text-gray'])
                    </div>
                </th>
                <th scope="col">
                    <div class="d-flex justify-content-between w-100px">
                        @sortablelink('next_follow_up_date', __('system.fields.next_follow_up_date'), [], ['class' => 'w-100 text-gray'])
                    </div>
                </th>

                <th scope="col">
                    <div class="d-flex justify-content-between w-150px">
                        @sortablelink('notes', __('system.fields.notes'), [], ['class' => 'w-100 text-gray'])
                    </div>
                </th>
                <th class="h-mw-80px">{{ __('system.fields.created_by') }}</th>
                <th class="h-mw-80px">{{ __('system.crud.action') }}</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($members as $member)
                <tr>
                    <td>
                        <p class="mb-0 font-size-12">{{ $member->name }}</p>
                        <p class="mb-0 badge bg-success"><small>{{ trans('system.fields.'.$member->gender) }}</small></p>
                    </td>
                    <td>{{ $member->phone }}</td>
                    <td>{{ $member->next_follow_up_date }}</td>
                    <td>{{ $member->notes }}</td>
                    <td>{{ $member->users->first_name }} {{ $member->users->last_name }}</td>
                    <td>
                        @can('delete members_enquiry')
                            {!! html()->form('delete', route('admin.member-enquiry.destroy', ['member_enquiry' => $member->id]))
                             ->class('data-confirm')
                             ->attribute('autocomplete', 'off')
                             ->attribute('data-confirm-message', __('system.fields.are_you_sure'))
                             ->attribute('data-confirm-title', __('system.crud.delete'))
                             ->id('delete-form_' . $member->id)
                             ->open() !!}
                        @endcan

                        <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                            @can('edit members_enquiry')
                                <a role="button" href="{{ route('admin.member-enquiry.edit', ['member_enquiry' => $member->id]) }}" class="btn btn-success">{{ __('system.crud.edit') }}</a>
                            @endcan
                            @can('delete members_enquiry')
                                <button type="submit" class="btn btn-danger">{{ __('system.crud.delete') }}</button>
                            @endcan
                        </div>

                        @can('delete members_enquiry')
                            {!! html()->closeModelForm() !!}
                        @endcan
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">
                        {{ __('system.crud.data_not_found', ['table' => __('system.member_enquiry.title')]) }}
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
