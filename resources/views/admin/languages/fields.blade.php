<div class="row">


    <div class=" col-md-4">
        @php($lbl_category_name = __('system.fields.language_name'))

        <div class="mb-3 form-group @error('name') has-danger @enderror ">
            <label class="form-label" for="name">{{ $lbl_category_name }} <span class="text-danger">*</span></label>
            <input type="text" name="name" id="name" class="form-control" placeholder="{{ $lbl_category_name }}"
                required maxlength="50" minlength="2" autocomplete="off"
                data-pristine-required-message="{{ __('validation.required', ['attribute' => strtolower($lbl_category_name)]) }}"
                data-pristine-minlength-message="{{ __('validation.custom.invalid', ['attribute' => strtolower($lbl_category_name)]) }}"
                value="{{ old('name') }}">
            @error('name')
                <div class="pristine-error text-help">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class=" col-md-4">
        @php($lbl_direction = __('system.fields.direction'))

        <div class="mb-3 form-group @error('name') has-danger @enderror ">
            <label class="form-label" for="name">{{ $lbl_direction }} <span class="text-danger">*</span></label>
            <select name="direction" id="direction" class="form-control form-select" required
                data-pristine-required-message="{{ __('validation.required', ['attribute' => strtolower($lbl_direction)]) }}">
                <option value="ltr" {{ old('direction', 'ltr') === 'ltr' ? 'selected' : '' }}>LTR</option>
                <option value="rtl" {{ old('direction') === 'rtl' ? 'selected' : '' }}>RTL</option>
            </select>

            @error('name')
                <div class="pristine-error text-help">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>
