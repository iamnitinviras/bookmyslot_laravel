<div class="row">
    <div class="col-sm-12">
        <table class="table align-middle datatable dt-responsive table-check nowrap dataTable no-footer  table-bordered" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
            <thead>
                <tr role="row">
                    <th scope="col">
                        {{__('system.fields.name')}}
                    </th>
                    <th scope="col">
                        {{__('system.plans.amount')}}
                    </th>
                </tr>
            </thead>
            <tbody>
                @php($total_amount=0)
                @if(isset($reports) && count($reports)>0)
                    @foreach($reports as $report)
                        @php($total_amount+=$report->total_amount)
                        <tr>
                            <td>@if(isset($report->user->name)) {{ $report->user->name }} @endif</td>
                            <td>{{ displayCurrency($report->total_amount) }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td><b>{{__('system.fields.total')}}</b></td>
                        <td>{{ displayCurrency($total_amount) }}</td>
                    </tr>
                @else
                <tr>
                    <td colspan="3" class="text-center">
                        {{ __('system.crud.data_not_found', ['table' => __('system.dashboard.report')]) }}
                    </td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
