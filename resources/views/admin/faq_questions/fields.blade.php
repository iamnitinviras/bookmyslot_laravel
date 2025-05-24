@csrf
<div>
    <section>

        <div class="row">
            <div class="row">
                <div class="col-lg-6 mb-2">
                    <div class="form-group">
                        <label class="text-label">{{ trans('system.faq.question') }}*</label>
                        <input
                            data-pristine-required-message="{{__('validation.required', ['attribute' => strtolower(trans('system.faq.question'))])}}"
                            value="{{ old('question', $faqQuestion->question ?? '')}}" type="text" name="question"
                            class="form-control" placeholder="{{ trans('system.faq.question') }}" required>
                    </div>
                </div>
                <div class="col-lg-6 mb-2">
                    <div class="form-group">
                        <label class="text-label">{{ trans('system.faq.answer') }}*</label>
                        <textarea
                            data-pristine-required-message="{{__('validation.required', ['attribute' => strtolower(trans('system.faq.answer'))])}}"
                            rows="4" type="text" name="answer" class="form-control"
                            placeholder="{{ trans('system.faq.answer') }}"
                            required>{{ old('answer', $faqQuestion->answer ?? "") }}</textarea>
                    </div>
                </div>
            </div>
            @foreach (getAllCurrentLanguages() as $key => $lang)
            <div class="row mt-5">
                <div class="col-lg-6 mb-2">
                    @php($lbl_question = __('system.faq.question') . ' ' . $lang)

                    <div class="form-group @error('lang_question.' . $key) has-danger @enderror">
                        <label class="form-label" for="name">{{ $lbl_question }} <span
                                class="text-danger">*</span></label>
                        <input type="text" name="lang_question[{{ $key }}]" id="name{{ $key }}" class="form-control"
                            autocomplete="off" placeholder="{{ $lbl_question }}" required
                            data-pristine-required-message="{{ __('validation.required', ['attribute' => strtolower($lbl_question)]) }}"
                            data-pristine-minlength-message="{{ __('validation.custom.invalid', ['attribute' => strtolower($lbl_question)]) }}"
                            value="{{ old("lang_question.$key", $faqQuestion->lang_question[$key]??'') }}">
                        @error('lang_question.' . $key)
                            <div class="pristine-error text-help">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-6 mb-2">
                    @php($lbl_answer = __('system.faq.answer') . ' ' . $lang)

                    <div class="form-group @error('lang_answer.' . $key) has-danger @enderror">
                        <label class="form-label" for="name">{{ $lbl_answer }} <span
                                class="text-danger">*</span></label>
                        <textarea name="lang_answer[{{ $key }}]" id="name{{ $key }}" class="form-control"
                            autocomplete="off" placeholder="{{ $lbl_answer }}" required rows="4"
                            data-pristine-required-message="{{ __('validation.required', ['attribute' => strtolower($lbl_answer)]) }}"
                            data-pristine-minlength-message="{{ __('validation.custom.invalid', ['attribute' => strtolower($lbl_answer)]) }}">{{ old("lang_answer.$key", $faqQuestion->lang_answer[$key]??'') }}</textarea>
                        @error('lang_answer.' . $key)
                            <div class="pristine-error text-help">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                @endforeach
    </section>
</div>
