<div class="row">
    <div class="col-md-9">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#lang_english" role="tab">
                                    <span>English</span>
                                </a>
                            </li>
                            @foreach (getAllCurrentLanguages() as $key => $lang)
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#lang_{{$key}}" role="tab">
                                        <span>{{$lang}}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <!-- Tab panes -->
                    <div class="tab-content p-3 text-muted">
                        <div class="tab-pane active" id="lang_english" role="tabpanel">
                            <div class="col-md-12">
                                @php($lbl_name = __('system.fields.title'))
                                <div
                                    class="mb-3 form-group @error('title') has-danger @enderror">
                                    <label class="form-label" for="title">{{ $lbl_name }} <span class="text-danger">*</span></label>
                                    {!! html()->text('title')
                                    ->class('form-control')
                                    ->id('title')
                                    ->attribute('autocomplete', 'off')
                                    ->attribute('placeholder', $lbl_name)
                                    ->attribute('onkeypress','createSlug(this)')
                                    ->attribute('onblur','createSlug(this)')
                                    ->required()
                                    ->attribute('maxlength', 150)
                                    ->attribute('minlength', 2)
                                    ->attribute('data-pristine-required-message', __('validation.required', ['attribute' => strtolower($lbl_name)]))
                                    ->attribute('data-pristine-minlength-message', __('validation.custom.invalid', ['attribute' => strtolower($lbl_name)])) !!}
                                    @error('title')
                                    <div class="pristine-error text-help">{{ $message }}</div>
                                    @enderror

                                </div>
                            </div>
                            <div class="mb-3 form-group  @error('slug') has-danger @enderror">
                                @php($lbl_blog_slug = __('system.fields.slug'))
                                <label for="input-slug">{{ $lbl_blog_slug }} <span class="text-danger">*</span></label>
                                {!! html()->text('slug')
                                ->class('form-control')
                                ->id('input-slug')
                                ->attribute('autocomplete', 'off')
                                ->attribute('placeholder', $lbl_blog_slug)
                                ->attribute('onkeypress','createSlug(this)')
                                ->attribute('onblur','createSlug(this)')
                                ->required()
                                ->minlength(3)
                                ->attribute('data-pristine-required-message', __('validation.required', ['attribute' => strtolower($lbl_blog_slug)]))
                                ->attribute('data-pristine-minlength-message', __('validation.custom.invalid', ['attribute' => strtolower($lbl_blog_slug)])) !!}
                                @error('slug')
                                <div class="pristine-error text-help">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                @php($lbl_food_description = __('system.blogs.description'))
                                <div class="mb-3 form-group @error('description') has-danger @enderror">
                                    <label class="form-label" for="input-address">{{ $lbl_food_description }}</label>
                                    {!! html()->textarea('description')
                                     ->class('form-control editor')
                                     ->id('ckeditor-classic')
                                     ->placeholder($lbl_food_description)
                                     ->rows(5)
                                     ->required()
                                     ->attribute('data-pristine-required-message', __('validation.required', ['attribute' => strtolower($lbl_food_description)]))
                                     ->attribute('data-pristine-minlength-message', __('validation.custom.invalid', ['attribute' => strtolower($lbl_food_description)])) !!}
                                </div>
                                @error('description')
                                <div class="pristine-error text-help">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        @foreach (getAllCurrentLanguages() as $key => $lang)
                            <div class="tab-pane" id="lang_{{$key}}" role="tabpanel">
                                <div class="col-md-12">
                                    @php($lbl_name = __('system.fields.title'))
                                    <div
                                        class="mb-3 form-group @error('lang_title_'.$key) has-danger @enderror">
                                        <label class="form-label" for="title">{{ $lbl_name }}</label>
                                        {!! html()->text("lang_title[$key]")
                                        ->class('form-control')
                                        ->id('lang_title_'.$key)
                                        ->attribute('autocomplete', 'off')
                                        ->attribute('placeholder', $lbl_name)
                                        ->attribute('maxlength', 150)
                                        ->attribute('minlength', 2)
                                        ->attribute('data-pristine-minlength-message', __('validation.custom.invalid', ['attribute' => strtolower($lbl_name)])) !!}
                                        @error('lang_title_'.$key)
                                        <div class="pristine-error text-help">{{ $message }}</div>
                                        @enderror

                                    </div>
                                </div>
                                <div class="col-md-12">
                                    @php($lbl_food_description = __('system.blogs.description'))
                                    <div class="mb-3 form-group @error('lang_description'.$key) has-danger @enderror">
                                        <label class="form-label" for="input-address">{{ $lbl_food_description }}</label>
                                        {!! html()->textarea("lang_description[$key]")
                                         ->class('form-control editor')
                                         ->id('ckeditor-classic')
                                         ->placeholder($lbl_food_description)
                                         ->rows(5)
                                         ->attribute('data-pristine-minlength-message', __('validation.custom.invalid', ['attribute' => strtolower($lbl_food_description)])) !!}
                                    </div>
                                    @error('lang_description'.$key)
                                    <div class="pristine-error text-help">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @if (isset($edit))
                        <input type="hidden" name="action" value="edit">
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    @php($lbl_category = ucwords(__('system.fields.status')))
                    <div class="col-md-12 form-group">
                        <div class="form-group mb-3 @error('status') has-danger @enderror">
                            <label class="form-label" for="blog_status">{{ $lbl_category }} <span class="text-danger">*</span></label>
                            <select name="status" id="blog_status" class="form-control form-select">
                                <option value="">{{ __('system.crud.select') . ' ' . $lbl_category }}</option>
                                <option value="published" @if(old('status',$blog->status??'published')=='published') selected @endif>{{trans('system.fields.published')}}</option>
                                <option value="unpublished" @if(old('status',$blog->status??'unpublished')=='unpublished') selected @endif>{{trans('system.fields.unpublished')}}</option>
                            </select>
                            @error('status')
                            <div class="pristine-error text-help">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    @php($lbl_category = ucwords(__('system.blog_categories.title')))
                    <div class="col-md-12 form-group">
                        <div class="form-group mb-3 @error('category_id') has-danger @enderror">
                            <label class="form-label" for="category_id">{{ $lbl_category }} <span class="text-danger">*</span></label>
                            <select name="category_id" id="category_id" class="form-control form-select" data-pristine-required
                                    data-pristine-required-message="{{ __('validation.required', ['attribute' => strtolower($lbl_category)]) }}">
                                <option class="d-none" value="">{{ __('system.crud.select') . ' ' . __('system.blog_categories.title') }}</option>
                                @foreach ($categories as $index => $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $blog->category_id ?? '') == $category->id ? 'selected' : '' }}>{{ $category->category_name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                            <div class="pristine-error text-help">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>


                    <div class="col-md-12">
                        @php($lbl_read_time = __('system.blogs.read_time'))
                        <div
                            class="mb-3 form-group @error('read_time') has-danger @enderror">
                            <label class="form-label" for="read_time">{{ $lbl_read_time }} <span class="text-danger">*</span></label>
                            {!! html()->number('read_time')
                            ->class('form-control')
                            ->id('read_time')
                            ->attribute('autocomplete', 'off')
                            ->attribute('placeholder', $lbl_read_time)
                            ->required()
                            ->attribute('maxlength', 60)
                            ->attribute('minlength', 1)
                            ->attribute('data-pristine-required-message', __('validation.required', ['attribute' => strtolower($lbl_read_time)]))
                            ->attribute('data-pristine-minlength-message', __('validation.custom.invalid', ['attribute' => strtolower($lbl_read_time)])) !!}
                            @error('read_time')
                            <div class="pristine-error text-help">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-12 form-group">
                        @php($lbl_image = __('system.fields.image'))
                        <div class="form-group">
                            <label class="form-label" for="seo_description">{{ $lbl_image }} <span class="text-danger">*</span></label>
                            @if (isset($blog) && $blog->image_url != null)
                                <img src="{{ $blog->image_url }}" class="img-thumbnail preview-image w-100">
                            @else
                                <img src="{{ asset('assets/admin/images/placeholder.png') }}" class="img-thumbnail preview-image  w-100">
                            @endif

                            <div class="d-flex align-items-center">
                                <input @if (isset($blog) && $blog->image_url != null) @else required @endif type="file" name="image" id="image" class="d-none my-preview" accept="image/*"
                                       data-pristine-accept-message="{{ __('validation.enum', ['attribute' => strtolower($lbl_image)]) }}"
                                       data-preview='.preview-image'>
                                <label for="image" class="mb-0 w-100">
                                    <div for="profile-image" class="btn btn-outline-primary waves-effect waves-light my-2 mdi mdi-upload w-100">
                                        <span class="d-none d-lg-inline">{{ $lbl_image }}</span>
                                    </div>
                                </label>
                            </div>
                            @error('image')
                            <div class="pristine-error text-help">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    @php($lbl_seo_keywords = ucwords(__('system.environment.seo_keyword')))
                    <div class="form-group col-md-12 mb-3 @error('seo_keyword') has-danger @enderror">
                        <label class="form-label" for="seo_keyword">{{ $lbl_seo_keywords }} </label>
                        <textarea name="seo_keyword" id="seo_keyword" cols="10" rows="2" class="form-control"
                                  placeholder="{{ $lbl_seo_keywords }}">{{ old('seo_keyword', $blog->seo_keyword ?? '') }}</textarea>
                        @error('seo_keyword')
                        <div class="pristine-error text-help">{{ $message }}</div>
                        @enderror
                    </div>

                    @php($lbl_seo_description = ucwords(__('system.environment.seo_description')))
                    <div class="form-group col-md-12 mb-3 @error('seo_description') has-danger @enderror">
                        <label class="form-label" for="seo_description">{{ $lbl_seo_description }} </label>
                        <textarea name="seo_description" id="seo_description" cols="10" rows="4" class="form-control"
                                  placeholder="{{ $lbl_seo_description }}">{{ old('seo_description', $blog->seo_description ?? '') }}</textarea>
                        @error('seo_description')
                        <div class="pristine-error text-help">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
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
