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
            <i class="fas fa-users font-size-16"></i>
            <span data-key="t-{{ __('system.vendors.menu') }}">{{ __('system.vendors.menu') }}</span>
        </a>
    </li>

    <li>
        <a href="{{ route('admin.plans.index') }}">
            <i class="fas fa-gift font-size-16"></i>
            <span data-key="t-{{ __('system.plans.menu') }}">{{ __('system.plans.menu') }}</span>
        </a>
    </li>
    <li>
        <a href="{{ route('admin.subscriptions') }}">
            <i class="fas fa-credit-card font-size-16"></i>
            <span data-key="t-{{ __('system.plans.subscriptions') }}">{{ __('system.plans.subscriptions') }}</span>
        </a>
    </li>
    <li>
        <a href="{{ route('admin.transactions') }}">
            <i class="fas fa-list-ul font-size-16"></i>
            <span data-key="t-{{ __('system.plans.transactions') }}">{{ __('system.plans.transactions') }}</span>
        </a>
    </li>

    <li>
        <a href="{{ route('admin.report') }}">
            <i class="fas fa-layer-group font-size-16"></i>
            <span data-key="t-{{ __('system.dashboard.report') }}">{{ __('system.dashboard.report') }}</span>
        </a>
    </li>
    <li>
        <a href="javascript: void(0);" class="has-arrow">
           <i class="fas fa-columns font-size-16"></i>
            <span data-key="t-{{ __('system.cms.menu') }}">{{ __('system.cms.menu') }}</span>
        </a>
        <ul class="sub-menu" aria-expanded="false">
            <li>
                <a href="{{ route('admin.testimonials.index') }}" key="t-{{ __('system.testimonial.menu') }}">
                    <i class=" fas fa-chevron-right font-size-16"></i>
                    {{ __('system.testimonial.menu') }}
                </a>
            </li>
            <li>
                <a href="{{ route('admin.faqs.index') }}" key="t-{{ __('system.faq.menu') }}">
                    <i class=" fas fa-chevron-right font-size-16"></i>
                    {{ __('system.faq.menu') }}
                </a>
            </li>
            <li>
                <a href="{{ route('admin.cms-page.index') }}" key="t-{{ __('system.cms.pages') }}">
                    <i class=" fas fa-chevron-right font-size-16"></i>
                    {{ __('system.cms.pages') }}
                </a>
            </li>
        </ul>
    </li>
    {{-- <li>
        <a href="{{ route('admin.testimonials.index') }}">
            <i class="fas fa-quote-left font-size-16"></i>
            <span data-key="t-{{ __('system.testimonial.menu') }}">{{ __('system.testimonial.menu') }}</span>
        </a>
    </li>
    <li>
        <a href="{{ route('admin.faqs.index') }}">
            <i class="fas fa-question font-size-16"></i>
            <span data-key="t-{{ __('system.faq.menu') }}">{{ __('system.faq.menu') }}</span>
        </a>
    </li> --}}
    {{-- <li class="menu-title text-white" data-key="t-pages">System Settings</li> --}}
    {{-- <li>
        <a href="{{ route('admin.cms-page.index') }}">
            <i class="fas fa-pager font-size-16"></i>
            <span data-key="t-{{ __('system.cms.menu') }}">{{ __('system.cms.menu') }}</span>
        </a>
    </li> --}}
    <li>
        <a href="{{ route('admin.contact-request.index') }}">
            <i class="fas fa-envelope font-size-16"></i>
            <span data-key="t-{{ __('system.contact_us.menu') }}">{{ __('system.contact_us.menu') }}</span>
        </a>
    </li>
    <li>
        <a href="{{ route('admin.languages.index') }}">
            <i class="fas  fa-language font-size-16"></i>
            <span data-key="t-{{ __('system.languages.menu') }}">{{ __('system.languages.menu') }}</span>
        </a>
    </li>
    <li>
        <a href="{{ route('admin.environment.setting') }}">
            <i class="fas fa-cog font-size-16"></i>
            <span data-key="t-{{ __('system.environment.menu') }}">{{ __('system.environment.menu') }}</span>
        </a>
    </li>
    @endhasanyrole

    <li>
        <a onclick="event.preventDefault(); document.getElementById('logout-form').click();" href="javacript:void(0)">
            <i class="fas fa-power-off font-size-16"></i>
            <form autocomplete="off" action="{{ route('logout') }}" method="POST" class="d-none data-confirm"
                data-confirm-message="{{ __('system.fields.logout') }}" data-confirm-title=" {{ __('auth.sign_out') }}">
                <button id="logout-form" type="submit"></button>
                @csrf
            </form>
            <span data-key="t-{{ __('auth.sign_out') }}">{{ __('auth.sign_out') }}</span>
        </a>
    </li>
</ul>
