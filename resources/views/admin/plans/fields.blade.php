@csrf
<div>
    <section>
        <div class="row">
            <div class="col-lg-4 mb-2">
                <div class="form-group">
                    <label class="text-label">{{ trans('system.plans.name') }}*</label>
                    <input value="{{ old('title') ? old('title') : (isset($plan) ? $plan->title : '') }}" type="text"
                        name="title" class="form-control" placeholder="{{ trans('system.plans.name') }}" required>
                </div>
            </div>
            @foreach (getAllCurrentLanguages() as $key => $lang)
            <div class="col-lg-4 mb-2">
                @php($lbl_plan_title = __('system.plans.name') . ' ' . $lang)
                <div class="form-group @error('lang_plan_title.' . $key) has-danger @enderror">
                    <label class="form-label" for="name">{{ $lbl_plan_title }} <span
                            class="text-danger">*</span></label>
                    <input type="text" name="lang_plan_title[{{ $key }}]" id="name{{ $key }}" class="form-control"
                        autocomplete="off" placeholder="{{ $lbl_plan_title }}" required
                        data-pristine-required-message="{{ __('validation.required', ['attribute' => strtolower($lbl_plan_title)]) }}"
                        data-pristine-minlength-message="{{ __('validation.custom.invalid', ['attribute' => strtolower($lbl_plan_title)]) }}"
                        value="{{ old("lang_plan_title.$key") }}">
                    @error('lang_plan_title.' . $key)
                        <div class="pristine-error text-help">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            @endforeach

            <div class="col-lg-4 mb-2">
                <div class="form-group">
                    <label class="text-label">{{ trans('system.plans.recurring_type') }}*</label>
                    <select
                        data-pristine-required-message="{{__('validation.required', ['attribute' => strtolower(trans('system.plans.recurring_type'))])}}"
                        name="recurring_type" class="form-control" required>
                        <option value="">{{trans('system.plans.recurring_type')}}</option>
                        <option {{ isset($plan) && $plan->type == 'onetime' ? 'selected' : '' }} value="onetime">
                            {{ trans('system.plans.onetime') }}
                        </option>
                        <option {{ isset($plan) && $plan->type == 'day' ? 'selected' : '' }} value="day">
                            {{ trans('system.plans.day') }}
                        </option>
                        <option {{ isset($plan) && $plan->type == 'weekly' ? 'selected' : '' }} value="weekly">
                            {{ trans('system.plans.weekly') }}
                        </option>
                        <option {{ isset($plan) && $plan->type == 'onetime' ? 'selected' : '' }} value="onetime">
                            {{ trans('system.plans.onetime') }}
                        </option>
                        <option {{ isset($plan) && $plan->type == 'monthly' ? 'selected' : '' }} value="monthly">
                            {{ trans('system.plans.monthly') }}
                        </option>
                        <option {{ isset($plan) && $plan->type == 'yearly' ? 'selected' : '' }} value="yearly">
                            {{ trans('system.plans.yearly') }}
                        </option>
                    </select>
                </div>
            </div>

            <div class="col-lg-4 mb-2">
                <div class="form-group">
                    <label class="text-label">{{ trans('system.plans.amount') }}*</label>
                    <input
                        data-pristine-required-message="{{__('validation.required', ['attribute' => strtolower(trans('system.plans.amount'))])}}"
                        value="{{ old('amount') ? old('amount') : (isset($plan) ? $plan->amount : '') }}" min="0"
                        step="0.01" type="number" name="amount" class="form-control" placeholder="Ex: 200" required>
                </div>
            </div>

            <div class="col-lg-4 mb-2">
                <label class="text-label">{{ trans('system.plans.member_limit') }}*</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text is-unlimited">
                            <input data-name="member_limit" {{ isset($plan) && $plan->unlimited_member == 'yes' ? 'checked' : '' }} id="is_member_limit" data-target="#member_limit"
                                name="is_unlimited_member" type="checkbox" class="isUnlimited" value="yes">
                            <label for="is_member_limit" class="form-check-label ml-3">
                                {{ trans('system.plans.is_unlimited') }}</label>
                        </div>
                    </div>
                    <input
                        value="{{ old('member_limit') ? old('member_limit') : (isset($plan) ? $plan->member_limit : 0) }}"
                        type="number" name="member_limit" id="member_limit" class="form-control" required min="0">
                </div>
            </div>

            <div class="col-lg-4 mb-2">
                <label class="text-label">{{ trans('system.plans.branch_limit') }}*</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text is-unlimited">
                            <input data-name="branch_limit" {{ isset($plan) && $plan->unlimited_branch == 'yes' ? 'checked' : '' }} id="is_branch_limit" data-target="#branch_limit"
                                name="is_unlimited_branch" type="checkbox" class="isUnlimited" value="yes">
                            <label for="is_branch_limit" class="form-check-label ml-3">
                                {{ trans('system.plans.is_unlimited') }}</label>
                        </div>
                    </div>
                    <input
                        value="{{ old('branch_limit') ? old('branch_limit') : (isset($plan) ? $plan->branch_limit : 0) }}"
                        type="number" name="branch_limit" id="branch_limit" class="form-control" required min="0">
                </div>
            </div>
            <div class="col-lg-4 mb-2">
                <label class="text-label">{{ trans('system.plans.staff_limit') }}*</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text is-unlimited">
                            <input data-name="staff_limit" {{ isset($plan) && $plan->staff_unlimited == 'yes' ? 'checked' : '' }} name="is_staff_unlimited" id="is_staff_unlimited" type="checkbox"
                                data-target="#staff_limit" class="isUnlimited" value="yes">
                            <label class="form-check-label ml-3" for="is_staff_unlimited">
                                {{ trans('system.plans.is_unlimited') }}
                            </label>
                        </div>
                    </div>
                    <input
                        value="{{ old('staff_limit') ? old('staff_limit') : (isset($plan) ? $plan->staff_limit : 0) }}"
                        type="number" name="staff_limit" id="staff_limit" class="form-control" required min="0">
                </div>
            </div>

            <div class="col-lg-4 mb-2">
                <div class="form-group">
                    <label class="text-label">{{ trans('system.plans.status') }}*</label>
                    <select name="status" class="form-control">
                        <option {{ isset($plan) && $plan->status == 'active' ? 'selected' : '' }} value="active">
                            {{ trans('system.crud.active') }}
                        </option>
                        <option {{ isset($plan) && $plan->status == 'inactive' ? 'selected' : '' }} value="inactive">
                            {{ trans('system.crud.inactive') }}
                        </option>
                    </select>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{ trans('system.plans.vendor_specific_plan') }}</h4>
                        <p class="card-title-desc">{{ trans('system.plans.select_vendor_specific_plan') }}</p>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <label class="text-label">{{ trans('system.vendors.select_vendor') }}</label>
                                <select name="user_id" class="form-control" id="user_id">
                                    <option value="">{{trans('system.vendors.select_vendor')}}</option>
                                    @if (isset($vendors) && count($vendors) > 0)
                                        @foreach ($vendors as $vendor)
                                            <option {{ old('user_id', $plan->user_id ?? '') == $vendor->id ? 'selected' : '' }}
                                                value="{{ $vendor->id }}">
                                                {{ $vendor->first_name }} {{ $vendor->last_name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@once
    @push('page_scripts')
        <script>
            $(document).ready(function () {
                $('.isUnlimited').click(function () {
                    console.log('hello');
                    let setter = false;
                    if ($(this).is(':checked')) {
                        setter = true;
                    }
                    $($(this).data('target')).attr('readonly', setter);
                });

                $('.isUnlimited:checked').each(function (key, element) {
                    $($(element).data('target')).attr('readonly', true);
                });
            });
        </script>
    @endpush
@endonce
