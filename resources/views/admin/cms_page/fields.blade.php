@csrf
<div>
    <section>
        <div class="row">
            <div class="row">
                <div class="col-lg-6 mb-2">
                    <div class="form-group">
                        <label class="text-label">{{ trans('system.cms.title') }}*</label>
                        <input value="{{ old('title') ? old('title') : (isset($cmsPage) ? $cmsPage->title : '') }}" type="text" name="title" class="form-control" placeholder="{{ trans('system.cms.title') }}" required>
                    </div>
                </div>
                <div class="col-lg-12 mb-2">
                    <div class="form-group">
                        <label class="text-label">{{ trans('system.cms.description') }}*</label>
                        <textarea class="form-control editor" name="description" cols="40" rows="10" required>{{ old('description') ? old('description') : (isset($cmsPage) ? $cmsPage->description : '') }}</textarea>
                    </div>
                </div>
            </div>
            @foreach (getAllCurrentLanguages() as $key => $lang)
                <div class="row mt-5">
                    <div class="col-lg-6 mb-2">
                        @php($lbl_title = __('system.cms.title') . ' ' . $lang)

                        <div class="form-group @error('lang_title.' . $key) has-danger @enderror">
                            <label class="form-label" for="name">{{ $lbl_title }} <span class="text-danger">*</span></label>
                            {!! html()->text("lang_title[$key]")
                        ->class('form-control')
                        ->id('name' . $key)
                        ->attribute('autocomplete', 'off')
                        ->placeholder($lbl_title)
                        ->required()
                        ->attribute('data-pristine-required-message', __('validation.required', ['attribute' => strtolower($lbl_title)]))
                        ->attribute('data-pristine-minlength-message', __('validation.custom.invalid', ['attribute' => strtolower($lbl_title)])) !!}

                            @error('lang_title.' . $key)
                                <div class="pristine-error text-help">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-12 mb-2">
                        @php($lbl_description = __('system.cms.description') . ' ' . $lang)

                        <div class="form-group @error('lang_description.' . $key) has-danger @enderror">
                            <label class="form-label" for="name">{{ $lbl_description }} <span class="text-danger">*</span></label>
                            {!! html()->textarea("lang_description[$key]")
                            ->class('form-control editor')
                            ->id('name' . $key)
                            ->attribute('autocomplete', 'off')
                            ->placeholder($lbl_description)
                            ->required()
                            ->attribute('data-pristine-required-message', __('validation.required', ['attribute' => strtolower($lbl_description)]))
                            ->attribute('data-pristine-minlength-message', __('validation.custom.invalid', ['attribute' => strtolower($lbl_description)])) !!}

                            @error('lang_description.' . $key)
                                <div class="pristine-error text-help">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            @endforeach


            @foreach (getAllCurrentLanguages() as $key => $lang)
                {{-- <div class="col-lg-6 mb-2">
                    @php($lbl_description = __('system.cms.description') . ' ' . $lang)

                    <div class="form-group @error('lang_description.' . $key) has-danger @enderror">
                        <label class="form-label" for="name">{{ $lbl_description }} <span class="text-danger">*</span></label>
                        {!! Form::textarea("lang_description[$key]", null, [
                            'class' => 'form-control editor',
                            'id' => 'name' . $key,
                            'autocomplete' => 'off',
                            'placeholder' => $lbl_description,
                            'required' => 'true',
                            'data-pristine-required-message' => __('validation.required', ['attribute' => strtolower($lbl_description)]),
                            'data-pristine-minlength-message' => __('validation.custom.invalid', ['attribute' => strtolower($lbl_description)]),
                        ]) !!}
                        @error('lang_description.' . $key)
                            <div class="pristine-error text-help">{{ $message }}</div>
                        @enderror
                    </div>
                </div> --}}
            @endforeach

    </section>

</div>

@once
    @push('page_scripts')
        <script src="{{ asset('js/tinymce/tinymce.min.js', config('app.redirect_https')) }}" referrerpolicy="origin"></script>
        <script>
            tinymce.init({
                selector: '.editor',
                plugins: 'preview importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen link template codesample table charmap pagebreak nonbreaking anchor insertdatetime advlist lists wordcount help charmap quickbars',
                editimage_cors_hosts: ['picsum.photos'],
                menubar: 'insert table',
                toolbar: 'undo redo | bold italic underline strikethrough | fontfamily fontsize blocks | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap | fullscreen  preview print | link | ltr rtl ',
                automatic_uploads: true,
                // add custom filepicker only to Image dialog
            });
        </script>
    @endpush
@endonce
