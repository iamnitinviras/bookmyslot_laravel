<div class="row">
    <div class="col-sm-12">
        <table class="table align-middle datatable dt-responsive table-check nowrap dataTable no-footer  table-bordered"
            id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
            <thead>
                <tr role="row">
                    <th scope="col">
                        <div class="d-flex justify-content-between">
                            @sortablelink('first_name', __('system.fields.name'), [], ['class' => 'w-100 text-gray'])
                        </div>
                    </th>
                    <th scope="col">
                        <div class="d-flex justify-content-between">
                            @sortablelink('email', __('system.fields.email'), [], ['class' => 'w-100 text-gray'])
                        </div>
                    </th>
                    <th scope="col">
                        <div class="d-flex justify-content-between">
                            {{__('system.fields.membership')}}
                        </div>
                    </th>
                    <th scope="col">
                        <div class="d-flex justify-content-between w-150px">
                            @sortablelink('phone_number', __('system.fields.phone_number'), [], ['class' => 'w-100 text-gray'])
                        </div>
                    </th>
                    <th scope="col">
                        <div class="d-flex justify-content-between">
                            @sortablelink('created_at', __('system.fields.member_since'), [], ['class' => 'w-100 text-gray'])
                        </div>
                    </th>
                    <th scope="col">
                        {{ __('auth.sign_in')}}
                    </th>
                    <th class="h-mw-80px">{{ __('system.crud.action') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($vendors as $vendor)
                    @php
                        $plan_title = "";
                        if ($vendor->free_forever == true) {
                            $plan_title = trans('system.vendors.free_forever');
                        } else {

                            $current_plans_id = $vendor->subscriptionData() ? $vendor->subscriptionData()->plan_id : 0;
                            $expiry_date = $vendor->subscriptionData() ? $vendor->subscriptionData()->expiry_date : null;
                            if ($current_plans_id == 0) {
                                $plan_title = trans('system.plans.trial');
                            } else {

                                if (isset($plans) && count($plans) > 0) {
                                    if ($current_plans_id == 0) {
                                        $plan_title = trans('system.plans.trial');
                                    } else {
                                        $plan_title = isset($plans[$current_plans_id]) ? $plans[$current_plans_id] : "";
                                    }
                                }
                            }

                        }
                    @endphp
                    <tr>
                        <td>
                            @if ($vendor->profile_url != null)
                                <img src="{{ $vendor->profile_url }}" alt="{{ $vendor->name }}"
                                    class="avatar-sm rounded-circle me-2 image-object-cover lazyload">
                            @else
                                <div class="avatar-sm d-inline-block align-middle me-2">
                                    <div
                                        class="avatar-title bg-soft-primary text-primary font-size-18 m-0 rounded-circle font-weight-bold">
                                        {{ $vendor->logo_name }}
                                    </div>
                                </div>
                            @endif
                            <span class="text-body">{{ $vendor->name }}</span>
                        </td>
                        <td>
                            @if($vendor->email_verified_at == null)
                                <i class="fas fa-times-circle text-danger"></i>
                            @else
                                <i class="fas fa-check-circle text-success"></i>
                            @endif
                            {{ $vendor->email }}
                        </td>
                        <td>
                            <span class="badge bg-primary p-2">{{ $plan_title }}</span>
                            @if(isset($expiry_date) && $expiry_date != null && ($expiry_date < now()))
                                <span class="badge bg-danger p-2">{{ trans('system.plans.expired') }}</span>
                            @endif
                        </td>
                        <td>{{ $vendor->phone_number }}</td>
                        <td>{{ $vendor->created_at }}</td>
                        <td>
                            <a class="btn btn-outline-primary" title="{{ __('system.vendors.continue_as_vendor') }}"
                                href="{{route('admin.vendors.vendorSignin', ['vendor' => $vendor->id])}}">
                                <i class="fa fa-user-check"></i>
                                {{__('auth.sign_in')}}
                            </a>
                        </td>
                        <td>
                            @if (auth()->user()->user_type == App\Models\User::USER_TYPE_ADMIN)
                                            {!! html()->form('delete', route('admin.vendors.destroy', ['vendor' => $vendor->id]))
                                ->class('data-confirm')
                                ->attribute('autocomplete', 'off')
                                ->attribute('data-confirm-message', __('system.fields.are_you_sure'))
                                ->attribute('data-confirm-title', __('system.crud.delete'))
                                ->id('delete-form_' . $vendor->id)->open() !!}
                            @endif

                            <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                <a role="button" href="{{ route('admin.vendors.show', ['vendor' => $vendor->id]) }}"
                                    class="btn btn-secondary">{{ __('system.crud.manage') }}
                                </a>
                                <a role="button" href="{{ route('admin.vendors.edit', ['vendor' => $vendor->id]) }}"
                                    class="btn btn-success">{{ __('system.crud.edit') }}
                                </a>
                                <button type="submit" class="btn btn-danger">{{ __('system.crud.delete') }}</button>
                            </div>
                            @if (auth()->user()->user_type == App\Models\User::USER_TYPE_ADMIN)
                                {!! html()->closeModelForm() !!}
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">
                            {{ __('system.crud.data_not_found', ['table' => __('system.vendors.title')]) }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="row">
    {{ $vendors->links() }}
</div>
