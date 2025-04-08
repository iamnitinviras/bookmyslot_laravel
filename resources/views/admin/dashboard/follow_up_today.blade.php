<div class="card">
    <div class="card-header align-items-center d-flex">
        <h4 class="card-title mb-0 flex-grow-1">{{trans('system.fields.follow_up_today')}}</h4>
    </div><!-- end card header -->

    <div class="card-body px-0 pt-2">
        <div class="table-responsive px-3" data-simplebar="init">
            <div class="simplebar-wrapper" style="margin: 0px -16px;">
                <div class="simplebar-height-auto-observer-wrapper">
                    <div class="simplebar-height-auto-observer"></div>
                </div>
                <div class="simplebar-mask">
                    <div class="simplebar-offset" style="right: -16.8px; bottom: 0px;">
                        <div class="simplebar-content-wrapper" style="height: auto; overflow: hidden scroll;">
                            <div class="simplebar-content" style="padding: 0px 16px;">
                                <table class="table align-middle table-nowrap">
                                    <tbody>
                                    @if(isset($follow_up_today) && count($follow_up_today)>0)
                                        @foreach($follow_up_today as $follow_up)
                                            <tr>
                                                <td>
                                                    <div>
                                                        <h5 class="font-size-15">{{$follow_up->name}}</h5>
                                                        <p class="mb-0 badge bg-success"><small>{{ trans('system.fields.'.$follow_up->gender) }}</small></p>
                                                    </div>
                                                </td>

                                                <td>
                                                    <p class="mb-1"><a href="#" class="text-dark">{{$follow_up->email}}</a></p>
                                                    <span class="text-muted">{{$follow_up->phone}}</span>
                                                </td>

                                                <td>
                                                    {{$follow_up->notes}}
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr class="text-center">
                                            <td colspan="3">{{trans('system.fields.no_record_found')}}</td>
                                        </tr>
                                    @endif

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="simplebar-placeholder" style="width: auto; height: 453px;"></div>
            </div>
        </div>
    </div>
    <!-- end card body -->
</div>
