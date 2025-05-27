<div class="row">
    <div class="col-sm-12 table-responsive">
        <table
            class="table align-middle datatable dt-responsive table-check nowrap dataTable no-footer mt-0 table-bordered"
            id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
            <thead>
                <tr>
                    <th>{{trans('system.fields.name')}}</th>
                    <th>{{trans('system.plans.plan_name')}}</th>
                    <th>{{trans('system.plans.payment_method')}}</th>
                    <th>{{trans('system.plans.start_date')}}</th>
                    <th>{{trans('system.plans.expiry_date')}}</th>
                    <th>{{trans('system.plans.status')}}</th>
                </tr>
            </thead>
            <tbody>
                @if(isset($subscriptions) && count($subscriptions) > 0)
                    @foreach($subscriptions as $subscription)
                        <tr data-url="{{ url('get-rightbar-content') }}" data-id="{{ $subscription->id }}"
                            data-action="subscription-history" @if(request()->action == 'approved') class="app-cursor-pointer"
                            onclick="show_rightbar_section(this)" @endif>
                            <td> @if(isset($subscription->user)) {{$subscription->user->first_name." ".$subscription->user->last_name}} @endif</td>
                            <td> @if(isset($subscription->plan->title)) {{$subscription->plan->local_title}} @else
                            {{ __('system.plans.trial') }} @endif
                            </td>

                            <td>{{ trans('system.payment_setting.' . $subscription->payment_method) }}</td>

                            <td>{{formatDate($subscription->start_date)}}</td>

                            @if(isset($subscription->expiry_date) && $subscription->expiry_date != null)
                                <td>{{formatDate($subscription->expiry_date)}}</td>
                            @else
                                <td data-action="{{$subscription->expiry_date}}">{{ trans('system.plans.lifetime') }}</td>
                            @endif
                            <td>
                                @if($subscription->status == 'approved')
                                    <span class="badge bg-success font-size-12">{{trans('system.plans.approved')}}</span>
                                @elseif($subscription->status == 'rejected')
                                    <span class="badge bg-danger font-size-12">{{trans('system.plans.rejected')}}</span>
                                @elseif($subscription->status == 'pending')
                                    <span class="badge bg-secondary font-size-12">{{trans('system.plans.pending')}}</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="9" class="text-center">
                            {{ __('system.crud.data_not_found', ['table' => __('system.plans.subscriptions')]) }}
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
