<div class="row">
    <div class="col-sm-12">
        <table class="table align-middle datatable dt-responsive table-check nowrap dataTable no-footer  table-bordered" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
            <thead>
                <tr role="row">
                    <th scope="col">
                        <div class="d-flex justify-content-between w-100px">
                            @sortablelink('name', __('system.contact_us.name'), [], ['class' => 'w-100 text-gray'])
                        </div>
                    </th>
                    <th scope="col">
                        <div class="d-flex justify-content-between w-100px">
                            @sortablelink('email', __('system.contact_us.email'), [], ['class' => 'w-100 text-gray'])
                        </div>
                    </th>
                    <th scope="col">
                       {{__('system.contact_us.message')}}
                    </th>
                    <th class="h-mw-80px">{{ __('system.crud.action') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($contactUsEmails as $contactUsEmail)
                    <tr>
                        <td>{{ $contactUsEmail->name }}</td>
                        <td>{{ $contactUsEmail->email }}</td>
                        <td><a data-url="{{url('get-rightbar-content')}}" data-id="{{$contactUsEmail->id}}" data-action="contact-us"  onclick="show_rightbar_section(this)" href="javascript:void(0)">{{ __('system.fields.view') }}</a></td>
                        <td>
                            {{ Form::open(['route' => ['admin.contact-request.destroy', ['contact_request' => $contactUsEmail->id]], 'autocomplete' => 'off', 'class' => 'data-confirm', 'data-confirm-message' => __('system.contact_us.are_you_sure'), 'data-confirm-title' => __('system.crud.delete'), 'id' => 'delete-form_' . $contactUsEmail->id, 'method' => 'delete']) }}
                                <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                    <button type="submit" class="btn btn-danger">{{ __('system.crud.delete') }}</button>
                                </div>
                            {{ Form::close() }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">
                            {{ __('system.crud.data_not_found', ['table' => __('system.dashboard.contact_us')]) }}
                        </td>
                    </tr>
                @endforelse

            </tbody>
        </table>
    </div>
</div>
