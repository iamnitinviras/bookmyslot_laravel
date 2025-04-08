<ul class="metismenu list-unstyled" id="side-menu">
    <li>
        <a href="{{ route('home') }}" class="{{ Request::is('home') ? 'active' : '' }}">
            <i class="fas fa-home"></i>
            <span data-key="t-dashboard">{{ __('system.dashboard.menu') }}</span>
        </a>
    </li>
    @hasanyrole('Super-Admin')
        <li>
            <a href="{{ route('admin.vendors.index') }}" class="{{ Request::is('admin/vendors*') ? 'active' : '' }}">
                <i class="fas fa-users font-size-18"></i>
                <span data-key="t-{{ __('system.vendors.menu') }}">{{ __('system.vendors.menu') }}</span>
            </a>
        </li>
    @endhasanyrole

    @hasanyrole('staff|vendor')
    @can('show staff')
        <li>
            <a href="{{ route('admin.agents.index') }}" class="{{ Request::is('admin/agents*') ? 'active' : '' }}">
                <i class="fas fa-users font-size-18"></i>
                <span data-key="t-{{ __('system.staffs.title') }}">{{ __('system.staffs.menu') }}</span>
            </a>
        </li>
    @endcan
    @can('show branch')
        <li>
            <a href="{{ route('admin.branch.index') }}" class="{{ Request::is('admin/branch*') ? 'active' : '' }}">
                <i class="fas fa-clipboard font-size-18"></i>
                <span data-key="t-{{ __('system.branch.menu') }}">{{ __('system.branch.menu') }}</span>
            </a>
        </li>
    @endcan
    @can('show packages')
        <li>
            <a href="{{ route('admin.packages.index') }}">
                <i class="fas fa-list-alt font-size-18"></i>
                <span data-key="t-{{ __('system.packages.menu') }}">{{ __('system.packages.menu') }}</span>
            </a>
        </li>
    @endcan

    @can('show questions')
        <li>
            <a href="{{ route('admin.questions.index') }}">
                <i class="fas fa-road font-size-18"></i>
                <span data-key="t-{{ __('system.questions.menu') }}">{{ __('system.questions.menu') }}</span>
            </a>
        </li>
    @endcan



    @if((auth()->user()->product!= null) && auth()->user()->product->allow_faqs==true)
        @can('show product_faqs')
            <li>
                <a href="{{ route('admin.product-faqs.index') }}">
                    <i class="fas fa-question-circle font-size-18"></i>
                    <span data-key="t-{{ __('system.product_faqs.menu') }}">{{ __('system.product_faqs.menu') }}</span>
                </a>
            </li>
        @endcan
    @endif

    @if((auth()->user()->product!= null) && auth()->user()->product->allow_changelog==true)
        @can('show changelogs')
            <li>
                <a href="{{ route('admin.changelogs.index') }}">
                    <i class="fas fa-comment-alt font-size-18"></i>
                    <span data-key="t-{{ __('system.changelogs.menu') }}">{{ __('system.changelogs.menu') }}</span>
                </a>
            </li>
        @endcan
    @endif
    @if((auth()->user()->product!= null) && auth()->user()->product->allow_feature_request==true)
        <li>
            <a href="javascript: void(0);" class="has-arrow">
                <i class="fas fa-comment-dots font-size-18"></i>
                <span data-key="t-ecommerce">{{ __('system.feature_requests.menu') }}</span>
            </a>
            <ul class="sub-menu" aria-expanded="false">
                @can('show roadmap')
                    <li><a href="{{ route('admin.roadmaps.index') }}" data-key="t-orders"><i class="fas fa-road font-size-16"></i> {{ __('system.roadmaps.menu') }}</a></li>
                @endcan
                @can('show feedback')
                    <li><a href="{{ route('admin.feedbacks.index') }}" key="t-products"><i class="fas fa-comment-alt font-size-16"></i> {{ __('system.feature_requests.menu') }}</a></li>
                    <li><a href="{{ route('admin.comments.index') }}" data-key="t-product-detail"><i class="fas fa-comment-dots font-size-16"></i> {{ __('system.feature_requests.comments') }}</a></li>
                    <li><a href="{{ route('admin.feedbacks.settings') }}" data-key="t-product-detail"><i class="fas fa-cog font-size-16"></i> {{ __('system.environment.menu') }}</a></li>
                @endcan
            </ul>
        </li>
    @endif

    @if((auth()->user()->product!= null) && auth()->user()->product->allow_support_request==true)
        @can('show tickets')
            <li>
                <a href="{{ route('admin.tickets.index') }}">
                    <i class="fas fa-ticket-alt font-size-18"></i>
                    <span data-key="t-{{ __('system.tickets.menu') }}">{{ __('system.tickets.menu') }}</span>
                </a>
            </li>
        @endcan
        @can('show my_tickets')
            <li>
                <a href="{{ route('admin.tickets.mytickets') }}">
                    <i class="fas fa-ticket-alt font-size-18"></i>
                    <span data-key="t-{{ __('system.tickets.my_tickets') }}">{{ __('system.tickets.my_tickets') }}</span>
                </a>
            </li>
        @endcan
    @endif

    @can('show qrcode')
        @if (auth()->user()->product != null)
            <li>
                <a href="{{ route('admin.create.QR') }}">
                    <i class="fas fa-qrcode font-size-18"></i>
                    <span data-key="t-{{ __('system.qr_code.menu') }}">{{ __('system.qr_code.menu') }}</span>
                </a>
            </li>
        @endif
    @endcan

    @endhasanyrole

    @role('vendor')
    @if (auth()->user()->free_forever == false)
        <li class="@if(in_array(request()->path(),array('subscription/plan'))) mm-active @endif">
            <a href="{{ route('admin.vendor.subscription') }}">
                <i class="fas fa-gift font-size-18"></i>
                <span data-key="t-{{ __('system.plans.menu') }}">{{ __('system.plans.subscription') }}</span>
            </a>
        </li>
    @endif
    <li>
        <a href="{{ route('admin.vendor.support') }}">
            <i class="fas fa-hands-helping font-size-18"></i>
            <span data-key="t-{{ __('system.fields.support') }}">{{ __('system.fields.support') }}</span>
        </a>
    </li>

    @endrole


    @hasanyrole('Super-Admin')
    <li>
        <a href="{{ route('admin.plans.index') }}">
            <i class="fas fa-gift font-size-18"></i>
            <span data-key="t-{{ __('system.plans.menu') }}">{{ __('system.plans.menu') }}</span>
        </a>
    </li>
    <li>
        <a href="{{ route('admin.subscriptions') }}">
            <i class="fas fa-credit-card font-size-18"></i>
            <span data-key="t-{{ __('system.plans.subscriptions') }}">{{ __('system.plans.subscriptions') }}</span>
        </a>
    </li>

    <li>
        <a href="{{ route('admin.report') }}">
            <i class="fas fa-layer-group font-size-18"></i>
            <span data-key="t-{{ __('system.dashboard.report') }}">{{ __('system.dashboard.report') }}</span>
        </a>
    </li>

    <li>
        <a href="{{ route('admin.testimonials.index') }}">
            <i class="fas fa-quote-left font-size-18"></i>
            <span data-key="t-{{ __('system.testimonial.menu') }}">{{ __('system.testimonial.menu') }}</span>
        </a>
    </li>
    <li>
        <a href="{{ route('admin.faqs.index') }}">
            <i class="fas fa-question font-size-18"></i>
            <span data-key="t-{{ __('system.faq.menu') }}">{{ __('system.faq.menu') }}</span>
        </a>
    </li>
    <li>
        <a href="{{ route('admin.cms-page.index') }}">
            <i class="fas fa-pager font-size-18"></i>
            <span data-key="t-{{ __('system.cms.menu') }}">{{ __('system.cms.menu') }}</span>
        </a>
    </li>
    <li>
        <a href="{{ route('admin.contact-request.index') }}">
            <i class="fas fa-envelope font-size-18"></i>
            <span data-key="t-{{ __('system.contact_us.menu') }}">{{ __('system.contact_us.menu') }}</span>
        </a>
    </li>


    <li>
        <a href="{{ route('admin.languages.index') }}">
            <i class="fas  fa-language font-size-18"></i>
            <span data-key="t-{{ __('system.languages.menu') }}">{{ __('system.languages.menu') }}</span>
        </a>
    </li>

    <li>
        <a href="{{ route('admin.environment.setting') }}">
            <i class="fas fa-cog font-size-18"></i>
            <span data-key="t-{{ __('system.environment.menu') }}">{{ __('system.environment.menu') }}</span>
        </a>
    </li>
    @endhasanyrole

    <li>
        <a onclick="event.preventDefault(); document.getElementById('logout-form').click();" href="javacript:void(0)">
            <i class="fas fa-power-off font-size-18"></i>
            <form autocomplete="off" action="{{ route('logout') }}" method="POST" class="d-none data-confirm" data-confirm-message="{{ __('system.fields.logout') }}"
                  data-confirm-title=" {{ __('auth.sign_out') }}">
                <button id="logout-form" type="submit"></button>
                @csrf
            </form>
            <span data-key="t-{{ __('auth.sign_out') }}">{{ __('auth.sign_out') }}</span>
        </a>
    </li>
</ul>
