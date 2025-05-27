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
                    <th scope="col">
                        {{__('system.plans.amount')}}
                    </th>
                    <th>{{trans('system.plans.status')}}</th>
                </tr>
            </thead>
            <tbody>
                @if(isset($subscriptions) && count($subscriptions) > 0)
                    @foreach($subscriptions as $subscription)
                        <tr>
                            <td> @if(isset($subscription->user))
                            {{$subscription->user->first_name . " " . $subscription->user->last_name}} @endif
                            </td>
                            <td> @if(isset($subscription->plan->title)) <span
                            class="badge bg-info p-1">{{$subscription->plan->local_title}}</span> @else
                                    {{ __('system.plans.trial') }} @endif
                            </td>

                            <td><span
                                    class="badge bg-primary p-1">{{ trans('system.payment_setting.' . $subscription->payment_method) }}</span>
                            </td>

                            <td>{{formatDate($subscription->start_date)}}</td>

                            @if(isset($subscription->expiry_date) && $subscription->expiry_date != null)
                                <td>{{formatDate($subscription->expiry_date)}}</td>
                            @else
                                <td data-action="{{$subscription->expiry_date}}">{{ trans('system.plans.lifetime') }}</td>
                            @endif
                            <td>
                                @if(isset($subscription->amount))
                                    {{ displayCurrency($subscription->amount) }}
                                @else
                                    {{ displayCurrency(0) }}
                                @endif
                                <span class="badge bg-warning p-1">{{ __('system.plans.' . $subscription->type) }}</span>
                            </td>
                            <td>
                                @if(isset($subscription->expiry_date) && $subscription->expiry_date != null && $subscription->expiry_date < date('Y-m-d H:i:s'))
                                    <span class="badge bg-danger">{{ trans('system.plans.expired') }}</span>
                                @else
                                    @if($subscription->status == 'approved')
                                        <span class="badge bg-success font-size-12">{{trans('system.plans.approved')}}</span>
                                    @elseif($subscription->status == 'rejected')
                                        <span class="badge bg-danger font-size-12">{{trans('system.plans.rejected')}}</span>
                                    @elseif($subscription->status == 'pending')
                                        <span class="badge bg-secondary font-size-12">{{trans('system.plans.pending')}}</span>
                                    @endif
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
