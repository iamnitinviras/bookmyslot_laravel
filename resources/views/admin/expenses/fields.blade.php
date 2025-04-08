<div class="row">
    @php($lbl_category = ucwords(__('system.expenses_categories.title')))
    <div class="col-md-4 form-group">
        <div class="form-group mb-3 @error('category_id') has-danger @enderror">
            <label class="form-label" for="category_id">{{ $lbl_category }} <span class="text-danger">*</span></label>
            <select name="category_id" id="category_id" class="form-control form-select" data-pristine-required
                    data-pristine-required-message="{{ __('validation.required', ['attribute' => strtolower($lbl_category)]) }}">
                <option class="d-none" value="">{{ __('system.crud.select') . ' ' . __('system.expenses_categories.title') }}</option>
                @foreach ($categories as $index => $category)
                    <option value="{{ $category->id }}" {{ old('category_id', $expense->category_id ?? '') == $category->id ? 'selected' : '' }}>{{ $category->local_lang_name }}</option>
                @endforeach
            </select>
            @error('category_id')
            <div class="pristine-error text-help">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        @php($lbl_name = __('system.fields.title'))
        <div
            class="mb-3 form-group @error('title') has-danger @enderror">
            <label class="form-label" for="title">{{ $lbl_name }} <span class="text-danger">*</span></label>
            {!! html()->text('title', old('title'))
                ->class('form-control')
                ->id('title')
                ->autocomplete('off')
                ->autofocus()
                ->required()
                ->attribute('placeholder', $lbl_name)
                ->attribute('maxlength', 150)
                ->attribute('minlength', 2)
                ->attribute('data-pristine-required-message', __('validation.required', ['attribute' => strtolower($lbl_name)]))
                ->attribute('data-pristine-minlength-message', __('validation.custom.invalid', ['attribute' => strtolower($lbl_name)])) !!}
            @error('title')
                <div class="pristine-error text-help">{{ $message }}</div>
            @enderror
            @error('branch_id')
                 <div class="pristine-error text-help">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-4">
        @php($lbl_description = __('system.fields.description'))
        <div class="mb-3 form-group">
            <label class="form-label" for="input-address">{{ $lbl_description }}</label>
            {!! html()->textarea('description', old('description'))
            ->class('form-control')
            ->id('description')
            ->attribute('placeholder', $lbl_description)
            ->attribute('rows', 2) !!}
        </div>
        @error('description')
        <div class="pristine-error text-help">{{ $message }}</div>
        @enderror
    </div>
</div>

@foreach (getAllCurrentLanguages() as $key => $lang)
    <div class="card">
        <div class="card-header">
            <b>{{$lang}}</b>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    @php($lbl_name = __('system.fields.name') . ' ' . $lang)
                    <div
                        class="mb-3 form-group @error('lang_name.' . $key) has-danger @enderror @error('restaurant_ids.' . $key) has-danger @enderror">
                        <label class="form-label" for="name">
                            {{ $lbl_name }}
                            <span class="text-danger">*</span>
                        </label>
                        {!! html()->text("lang_name[$key]")
                            ->class('form-control')
                            ->id('name')
                            ->autocomplete('off')
                            ->attribute('placeholder', $lbl_name)
                            ->required()
                            ->attribute('maxlength', 150)
                            ->attribute('minlength', 2)
                            ->attribute('data-pristine-required-message', __('validation.required', ['attribute' => strtolower($lbl_name)]))
                            ->attribute('data-pristine-minlength-message', __('validation.custom.invalid', ['attribute' => strtolower($lbl_name)])) !!}

                        @error('lang_name.' . $key)
                        <div class="pristine-error text-help">{{ $message }}</div>
                        @enderror
                        @error('restaurant_ids.' . $key)
                        <div class="pristine-error text-help">{{ $message }}</div>
                        @enderror

                    </div>
                </div>
                <div class="col-md-4">
                    @php($lbl_description = __('system.fields.description') . ' ' . $lang)
                    <div
                        class="mb-3 form-group @error('lang_description.' . $key) has-danger @enderror @error('restaurant_ids.' . $key) has-danger @enderror">
                        <label class="form-label" for="name">
                            {{ $lbl_description }}
                        </label>
                        {!! html()->textarea("lang_description[$key]", old("lang_description[$key]"))
                            ->class('form-control')
                            ->id('name')
                            ->attribute('autocomplete', 'off')
                            ->attribute('placeholder', $lbl_description)
                            ->rows(2) !!}

                        @error('lang_description.' . $key)
                        <div class="pristine-error text-help">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>

@endforeach
<div class="row">
    <div class="col-md-4">
        @php($lbl_amount = __('system.expenses.amount'))
        <div class="mb-3 form-group">
            <label class="form-label" for="amount">{{ $lbl_amount }} <span class="text-danger">*</span></label>
            {!! html()->text('amount', old('amount'))
            ->class('form-control')
            ->id('amount')
            ->required()
            ->attribute('placeholder', $lbl_amount)!!}
        </div>
        @error('amount')
        <div class="pristine-error text-help">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-4">
        @php($lbl_date= __('system.expenses.date'))
        <div class="mb-3 form-group">
            <label class="form-label" for="expense_date">{{ $lbl_date }} <span class="text-danger">*</span></label>
            {!! html()->date('expense_date', old('expense_date'))
            ->class('form-control')
            ->id('expense_date')
            ->required()
            ->attribute('placeholder', $lbl_date)!!}
        </div>
        @error('amount')
        <div class="pristine-error text-help">{{ $message }}</div>
        @enderror
    </div>
</div>
<div class="row">
    <div class="w-100"></div>
    <input type="hidden" name="created_by" value="{{ auth()->user()->id }}">
    <input type="hidden" name="branch_id" value="{{ auth()->user()->branch_id }}">
    @if (isset($edit))
        <input type="hidden" name="action" value="edit">
    @endif
</div>
