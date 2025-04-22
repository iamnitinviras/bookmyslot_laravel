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
                    <label class="form-label">{{trans('system.payment_setting.select_app_currency')}}</label>
                    <select name="paypal_currency_code" id="paypal_currency_code" required="required"
                        class="form-control form-select">
                        <option value="">{{trans('system.payment_setting.select_app_currency')}}</option>
                        <option {{ config('paypal.currency') == 'INR' ? 'selected' : '' }} value="INR">Indian rupee </option>
                        <option {{ config('paypal.currency') == 'AUD' ? 'selected' : '' }} value="AUD">Australian dollar </option>
                        <option {{ config('paypal.currency') == 'BRL' ? 'selected' : '' }} value="BRL">Brazilian real </option>
                        <option {{ config('paypal.currency') == 'CAD' ? 'selected' : '' }} value="CAD">Canadian dollar </option>
                        <option {{ config('paypal.currency') == 'CNY' ? 'selected' : '' }} value="CNY">Chinese Renmenbi </option>
                        <option {{ config('paypal.currency') == 'CZK' ? 'selected' : '' }} value="CZK">Czech koruna </option>
                        <option {{ config('paypal.currency') == 'DKK' ? 'selected' : '' }} value="DKK">Danish krone </option>
                        <option {{ config('paypal.currency') == 'EUR' ? 'selected' : '' }} value="EUR">Euro </option>
                        <option {{ config('paypal.currency') == 'HKD' ? 'selected' : '' }} value="HKD">Hong Kong dollar </option>
                        <option {{ config('paypal.currency') == 'HUF' ? 'selected' : '' }} value="HUF">Hungarian forint </option>
                        <option {{ config('paypal.currency') == 'ILS' ? 'selected' : '' }} value="ILS">Israeli new shekel </option>
                        <option {{ config('paypal.currency') == 'JPY' ? 'selected' : '' }} value="JPY">Japanese yen </option>
                        <option {{ config('paypal.currency') == 'MYR' ? 'selected' : '' }} value="MYR">Malaysian ringgit </option>
                        <option {{ config('paypal.currency') == 'MXN' ? 'selected' : '' }} value="MXN">Mexican peso </option>
                        <option {{ config('paypal.currency') == 'TWD' ? 'selected' : '' }} value="TWD">New Taiwan dollar </option>
                        <option {{ config('paypal.currency') == 'NZD' ? 'selected' : '' }} value="NZD">New Zealand dollar </option>
                        <option {{ config('paypal.currency') == 'NOK' ? 'selected' : '' }} value="NOK">Norwegian krone </option>
                        <option {{ config('paypal.currency') == 'PHP' ? 'selected' : '' }} value="PHP">Philippine peso </option>
                        <option {{ config('paypal.currency') == 'PLN' ? 'selected' : '' }} value="PLN">Polish złoty </option>
                        <option {{ config('paypal.currency') == 'GBP' ? 'selected' : '' }} value="GBP">Pound sterling </option>
                        <option {{ config('paypal.currency') == 'RUB' ? 'selected' : '' }} value="RUB">Russian ruble </option>
                        <option {{ config('paypal.currency') == 'SGD' ? 'selected' : '' }} value="SGD">Singapore dollar </option>
                        <option {{ config('paypal.currency') == 'SEK' ? 'selected' : '' }} value="SEK">Swedish krona </option>
                        <option {{ config('paypal.currency') == 'CHF' ? 'selected' : '' }} value="CHF">Swiss franc </option>
                        <option {{ config('paypal.currency') == 'THB' ? 'selected' : '' }} value="THB">Thai baht </option>
                        <option {{ config('paypal.currency') == 'USD' ? 'selected' : '' }} value="USD">United States dollar </option>
                    </select>
                </div>
            </div>

            <div class="col-md-12 mb-3">
                <div class="form-group">
                    <label class="form-label">{{ __('system.payment_setting.client_id_key') }}</label>
                    <input value="{{ config('paypal.client_id') }}" type="text" name="paypal_client_id" required
                        class="form-control" placeholder="{{ trans('system.payment_setting.client_id_key') }}">
                </div>
            </div>
            <div class="col-md-12 mb-3">
                <div class="form-group">
                    <label class="form-label">{{ trans('system.payment_setting.client_secret_key') }}</label>
                    <input value="{{ config('paypal.secret') }}" type="text" name="paypal_secret_key" required
                        class="form-control" placeholder="{{ trans('system.payment_setting.client_secret_key') }}">
                </div>
            </div>
            <div class="col-md-12 mb-3">
                <div class="form-group">
                    <label class="form-label"
                        for="paypal_mode">{{ trans('system.payment_setting.gateway_mode') }}</label>
                    <select id="paypal_mode" name="paypal_mode" required class="form-control">
                        <option {{ config('paypal.mode') == 'sandbox' ? 'selected' : '' }} value="sandbox">
                            {{ trans('system.payment_setting.sandbox') }}
                        </option>
                        <option {{ config('paypal.mode') == 'production' ? 'selected' : '' }} value="production">
                            {{ trans('system.payment_setting.production') }}
                        </option>
                    </select>
                </div>
            </div>
            <input type="hidden" name="hidden_paypal_mode" value="{{config('paypal.mode')}}" />
            <div class="col-md-12 mb-3">
                <div class="form-group">
                    <label class="form-label" for="paypal_status">{{ trans('system.payment_setting.status') }}</label>
                    <select id="paypal_status" name="paypal_status" required class="form-control">
                        <option {{  config('paypal.status') == 'enable' ? 'selected' : '' }} value="enable">
                            {{ trans('system.payment_setting.enable') }}
                        </option>
                        <option {{ config('paypal.status') == 'disable' ? 'selected' : '' }} value="disable">
                            {{ trans('system.payment_setting.disable') }}
                        </option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>
