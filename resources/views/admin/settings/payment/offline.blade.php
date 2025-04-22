@php
    $offline_payment_status = isset($offline->offline_status) ? $offline->offline_status : 'disable';
@endphp

<div class="card">
    <input name="gateway_type" type="hidden" value="offline" />
    <div class="card-header">{{ __('system.payment_setting.Offline_payments') }}</div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12 mb-3">
                <div class="form-group">
                    <label for="instruction">{{ trans('system.payment_setting.instruction') }}*</label>
                    <textarea required name="instructions" id="instruction" cols="30" class="form-control"
                        rows="3">{!! config('offline.instructions') !!}</textarea>
                </div>
            </div>
            <div class="col-md-12 mb-3">
                <div class="form-group">
                    <label for="offline_status">{{ trans('system.payment_setting.status') }}</label>
                    <select id="offline_status" name="offline_status" required class="form-control">
                        <option {{ config('offline.offline_status') == 'enable' ? 'selected' : '' }} value="enable">
                            {{ trans('system.payment_setting.enable') }}
                        </option>
                        <option {{config('offline.offline_status') == 'disable' ? 'selected' : '' }} value="disable">
                            {{ trans('system.payment_setting.disable') }}
                        </option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>
