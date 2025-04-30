<div class="card">
    <input name="gateway_type" type="hidden" value="paystack" />
    <div class="card-header">{{ __('system.payment_setting.paystack_payments') }}</div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12 mb-3">
                <div class="form-group">
                    <label class="form-label">{{trans('system.payment_setting.select_app_currency')}}</label>
                    <select name="paystack_currency_code" id="paystack_currency_code" required="required"
                        class="form-control form-select">
                        <option value="">{{trans('system.payment_setting.select_app_currency')}}</option>
                        <option {{ config('paystack.currency') == 'XOF' ? 'selected' : '' }} value="XOF"> Côte d’Ivoire</option>
                        <option {{ config('paystack.currency') == 'GHS' ? 'selected' : '' }} value="GHS"> Ghana</option>
                        <option {{ config('paystack.currency') == 'KES' ? 'selected' : '' }} value="KES"> Kenya</option>
                        <option {{ config('paystack.currency') == 'NGN' ? 'selected' : '' }} value="NGN"> Nigeria</option>
                        <option {{ config('paystack.currency') == 'ZAR' ? 'selected' : '' }} value="ZAR"> South Africa</option>
                    </select>
                </div>
            </div>
            <div class="col-md-12 mb-3">
                <div class="form-group">
                    <label class="form-label">{{ __('system.payment_setting.public_key') }}</label>
                    <input value="{{ config('paystack.public_key') }}" type="text" name="paystack_public_key" required
                        class="form-control" type="text" name="paystack_public_key" required class="form-control"
                        placeholder="{{ trans('system.payment_setting.public_key') }}">
                </div>
            </div>
            <div class="col-md-12 mb-3">
                <div class="form-group">
                    <label class="form-label">{{ trans('system.payment_setting.secret_key') }}</label>
                    <input value="{{ config('paystack.secret') }}" type="text" name="paystack_secret_key" required
                        class="form-control" placeholder="{{ trans('system.payment_setting.secret_key') }}">
                </div>
            </div>
            <div class="col-md-12 mb-3">
                <div class="form-group">
                    <label class="form-label"
                        for="paystack_mode">{{ trans('system.payment_setting.gateway_mode') }}</label>
                    <select id="paystack_mode" name="paystack_mode" required class="form-control">
                        <option {{ config('paystack.mode') == 'test' ? 'selected' : '' }} value="test">
                            {{ trans('system.payment_setting.test') }}
                        </option>
                        <option {{ config('paystack.mode') == 'live' ? 'selected' : '' }} value="live">
                            {{ trans('system.payment_setting.production') }}
                        </option>
                    </select>
                </div>
            </div>
            <div class="col-md-12 mb-3">
                <div class="form-group">
                    <label class="form-label" for="paystack_status">{{ trans('system.payment_setting.status') }}</label>
                    <select id="paystack_status" name="paystack_status" required class="form-control">
                        <option {{ config('paystack.status') == 'enable' ? 'selected' : '' }} value="enable">
                            {{ trans('system.payment_setting.enable') }}
                        </option>
                        <option {{ config('paystack.status') == 'disable' ? 'selected' : '' }} value="disable">
                            {{ trans('system.payment_setting.disable') }}
                        </option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>
