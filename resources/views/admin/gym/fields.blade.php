@php($lbl_logo = __('system.gym.logo'))
<div class="row">
    <div class="col-md-4 form-group mb-3">
        <label>{{ $lbl_logo }}</label>
        <div class="d-flex  align-items-center ">
            <input type="file" name="logo" id="logo" class="d-none my-preview" accept="image/*"
                data-pristine-accept-message="{{ __('validation.enum', ['attribute' => strtolower($lbl_logo)]) }}"
                data-preview='.preview-image'>
            <label for="logo" class="mb-0">
                <div for="profile-image" class="btn btn-outline-primary waves-effect waves-light my-2 mdi mdi-upload ">
                    {{ $lbl_logo }}
                </div>
            </label>
            <div class='mx-3 '>
                @if (isset($gym) && $gym->logo_url != null)
                    <img src="{{ $gym->logo_url }}" alt="" class="avatar-xl rounded-circle img-thumbnail preview-image">
                @else
                    <div class="preview-image-default">
                        <h1 class="rounded-circle font-size text-white d-inline-block text-bold bg-primary px-4 py-3 ">
                            {{ $gym->logo_name ?? 'B' }}
                        </h1>
                    </div>
                    <img class="avatar-xl rounded-circle img-thumbnail preview-image d-none" style="display: none;" />
                @endif
            </div>
        </div>
        @error('logo')
            <div class="pristine-error text-help">{{ $message }}</div>
        @enderror
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        @php($lbl_name = __('system.gym.name'))
        <div class="mb-3 form-group @error('title') has-danger @enderror">
            <label class="form-label" for="name">{{ $lbl_name }} <span class="text-danger">*</span></label>
            {!! html()->text('title', old('title'))
            ->class('form-control')
            ->id('title')
            ->required()
            ->attribute('autofocus', true)
            ->attribute('placeholder', $lbl_name)
            ->attribute('data-pristine-required-message', __('validation.required', ['attribute' => strtolower($lbl_name)]))
            ->attribute('data-pristine-minlength-message', __('validation.custom.invalid', ['attribute' => strtolower($lbl_name)])) !!}
            @error('title')
                <div class="pristine-error text-help">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-4">
        @php($lbl_phone_number = __('system.fields.phone_number'))
        <div class="mb-3 form-group @error('phone_number') has-danger @enderror">
            <label class="form-label" for="pristine-phone-valid">{{ $lbl_phone_number }} <span
                    class="text-danger">*</span></label>
            {!! html()->text('phone', old('phone'))
            ->class('form-control')
            ->id('pristine-phone-valid')
            ->attribute('placeholder', $lbl_phone_number)
            ->required()
            ->attribute('maxlength', 20)
            ->attribute('onkeypress', 'return NumberValidate(event)')
            ->attribute('data-pristine-required-message', __('validation.required', ['attribute' => strtolower($lbl_phone_number)])) !!}

            @error('phone')
                <div class="pristine-error text-help">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-4">
        <div class="mb-3 form-group  @error('email') has-danger @enderror">
            @php($lbl_email = __('system.fields.email'))
            <label for="email">{{ $lbl_email }}</label>
            {!! html()->email('email', old('email'))
            ->class('form-control')
            ->id('email')
            ->attribute('placeholder', $lbl_email)
            ->attribute('onblur', 'createSlug(this)')
            ->attribute('data-pristine-required-message', __('validation.required', ['attribute' => strtolower($lbl_email)])) !!}
            @error('email')
                <div class="pristine-error text-help">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>
<div class="row mt-3">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <b>{{ __('system.branch.menu') }}</b>
            </div>
            <div class="card-body">
                @include('admin.branch.fields', ['create' => true])
            </div>
        </div>
    </div>
</div>

