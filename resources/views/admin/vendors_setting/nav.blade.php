<div class="row">
    <div class="col-md-12">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link  @if(isset($priority_setting)) active @endif" href="{{ route('admin.ticket-priorities.index') }}">
                    <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                    <span class="d-none d-sm-block">{{ __('system.ticket_priority.title') }}</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link  @if(isset($ticket_type_setting)) active @endif" href="{{ route('admin.ticket-types.index') }}">
                    <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                    <span class="d-none d-sm-block">{{ __('system.ticket_type.title') }}</span>
                </a>
            </li>
        </ul>
    </div>
</div>
