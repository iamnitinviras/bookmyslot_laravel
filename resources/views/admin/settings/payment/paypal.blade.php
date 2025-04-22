@php
    $paypal_payment_status = isset($paypal->offline_status) ? $paypal->offline_status : 'disable';
    $paypal_payment_mode = isset($paypal->paypal_mode) ? $paypal->paypal_mode : 'sandbox';
@endphp
<div class="card">
    <input name="gateway_type" type="hidden" value="paypal" />
    <div class="card-header">{{ __('system.payment_setting.paypal_payments') }}</div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12 mb-3">
                <div class="form-group">
                    <select name="paypal_currency_code" id="paypal_currency_code" required="required"
                        class="form-control form-select">
                        <option value=""> Select Currency Code</option>
                        <option value="INR">Indian rupee </option>
                        <option value="AUD">Australian dollar </option>
                        <option value="BRL">Brazilian real </option>
                        <option value="CAD">Canadian dollar </option>
                        <option value="CNY">Chinese Renmenbi </option>
                        <option value="CZK">Czech koruna </option>
                        <option value="DKK">Danish krone </option>
                        <option value="EUR">Euro </option>
                        <option value="HKD">Hong Kong dollar </option>
                        <option value="HUF">Hungarian forint </option>
                        <option value="ILS">Israeli new shekel </option>
                        <option value="JPY">Japanese yen </option>
                        <option value="MYR">Malaysian ringgit </option>
                        <option value="MXN">Mexican peso </option>
                        <option value="TWD">New Taiwan dollar </option>
                        <option value="NZD">New Zealand dollar </option>
                        <option value="NOK">Norwegian krone </option>
                        <option value="PHP">Philippine peso </option>
                        <option value="PLN">Polish złoty </option>
                        <option value="GBP">Pound sterling </option>
                        <option value="RUB">Russian ruble </option>
                        <option value="SGD">Singapore dollar </option>
                        <option value="SEK">Swedish krona </option>
                        <option value="CHF">Swiss franc </option>
                        <option value="THB">Thai baht </option>
                        <option value="USD" selected="selected">United States dollar </option>
                    </select>
                </div>
            </div>

            <div class="col-md-12 mb-3">
                <div class="form-group">
                    <label class="form-label">{{ __('system.payment_setting.client_id_key') }}</label>
                    <input value="{{ isset($paypal->paypal_client_id) ? $paypal->paypal_client_id : '' }}" type="text"
                        name="paypal_client_id" required class="form-control"
                        placeholder="{{ trans('system.payment_setting.client_id_key') }}">
                </div>
            </div>
            <div class="col-md-12 mb-3">
                <div class="form-group">
                    <label class="form-label">{{ trans('system.payment_setting.client_secret_key') }}</label>
                    <input value="{{ isset($paypal->paypal_secret_key) ? $paypal->paypal_secret_key : '' }}" type="text"
                        name="paypal_secret_key" required class="form-control"
                        placeholder="{{ trans('system.payment_setting.client_secret_key') }}">
                </div>
            </div>
            <div class="col-md-12 mb-3">
                <div class="form-group">
                    <label class="form-label"
                        for="paypal_mode">{{ trans('system.payment_setting.gateway_mode') }}</label>
                    <select id="paypal_mode" name="paypal_mode" required class="form-control">
                        <option {{ $paypal_payment_mode == 'sandbox' ? 'selected' : '' }} value="sandbox">
                            {{ trans('system.payment_setting.sandbox') }}
                        </option>
                        <option {{ $paypal_payment_mode == 'production' ? 'selected' : '' }} value="production">
                            {{ trans('system.payment_setting.production') }}
                        </option>
                    </select>
                </div>
            </div>
            <input type="hidden" name="hidden_paypal_mode" value="{{$paypal_payment_mode}}" />
            <div class="col-md-12 mb-3">
                <div class="form-group">
                    <label class="form-label" for="paypal_status">{{ trans('system.payment_setting.status') }}</label>
                    <select id="paypal_status" name="paypal_status" required class="form-control">
                        <option {{ $paypal_payment_status == 'enable' ? 'selected' : '' }} value="enable">
                            {{ trans('system.payment_setting.enable') }}
                        </option>
                        <option {{ $paypal_payment_status == 'disable' ? 'selected' : '' }} value="disable">
                            {{ trans('system.payment_setting.disable') }}
                        </option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>
