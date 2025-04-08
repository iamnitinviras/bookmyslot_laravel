 @php($languages = getAllLanguages(true, 'id'))
 @extends('layouts.app')
 @section('title', __('system.languages_data.edit.menu'))
 @section('content')
     <div class="row">

         <div class="col-xl-12 col-sm-12">
             <div class="card">
                 <div class="card-header">

                     <div class="row">
                         <div class="col-md-6 col-xl-6">
                             <h4 class="card-title">{{ __('system.languages_data.edit.menu') }} {{ $language->name }}</h4>
                             <div class="page-title-box pb-0 d-sm-flex">
                                 <div class="page-title-right">
                                     <ol class="breadcrumb m-0">
                                         <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('system.dashboard.menu') }}</a></li>
                                         <li class="breadcrumb-item "><a href="{{ route('admin.languages.index') }}">{{ __('system.languages.menu') }}</a></li>
                                         <li class="breadcrumb-item active">{{ __('system.languages_data.edit.menu') }} {{ $language->name }}</li>
                                     </ol>
                                 </div>
                             </div>
                         </div>

                         <div class="col-md-6 col-xl-6 text-end add-new-btn-parent">
                             <div class="d-flex flex-wrap justify-content-end align-items-center gap-2 mb-3 text-start">
                                 <div>
                                     {!! html()->select('language', $languages, $language->id)
                                    ->class('form-select route-on-change')
                                    ->id('business_type')
                                    ->required()
                                    ->attribute('data-pristine-required-message', __('validation.custom.select_required', ['attribute' => 'route'])) !!}

                                 </div>
                                 <div>
                                     {!! html()->select('file', getAllLanguagesFiles(), request()->query('file'))
                                    ->class('form-select filter-on-change')
                                    ->id('business_type')
                                    ->required()
                                    ->attribute('data-pristine-required-message', __('validation.custom.select_required', ['attribute' => 'file'])) !!}

                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>
                 <div class="card-body position-relative">

                     {!! html()->form('put', route('admin.languages.update', $language->id))
                     ->attribute('files', true)
                     ->id('pristine-valid')
                     ->attribute('autocomplete', 'off')
                     ->open() !!}
                     @include('admin.languages.languages-data.fields')
                     <div class="row">
                         <div class="col-12 mt-3">
                             <div class="position-fixed languagedata-save-btns">
                                 <button class="btn btn-primary" type="submit">{{ __('system.crud.save') }}</button>
                                 <a href="{{ route('admin.languages.index') }}"class="btn btn-secondary">{{ __('system.crud.cancel') }}</a>
                             </div>
                         </div>
                     </div>
                     {!! html()->closeModelForm() !!}
                 </div>
                 <!-- end card -->
             </div>
         </div>
     </div>
 @endsection
 @push('page_scripts')
     <script>
         var url = "{{ route('admin.languages.edit', ['language' => '#lang#']) }}"
         $(document).on('change', '.route-on-change', function() {
             var val = $(this).val();
             url = url.replace("#lang#", val)
             location.href = url;

         })
     </script>
 @endpush
