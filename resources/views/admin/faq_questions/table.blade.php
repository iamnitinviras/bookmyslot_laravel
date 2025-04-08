<div class="row">
    <div class="col-sm-12">
        <table class="table align-middle datatable dt-responsive table-check nowrap dataTable no-footer  table-bordered" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
            <thead>
                <tr role="row">
                    <th scope="col">
                        <div class="d-flex justify-content-between w-50px">
                            @sortablelink('id', __('system.crud.id'), [], ['class' => 'w-100 text-gray'])
                        </div>

                    </th>
                    <th scope="col">
                        <div class="d-flex justify-content-between w-260px">
                            @sortablelink('question', __('system.faq.question'), [], ['class' => 'w-100 text-gray'])
                        </div>
                    </th>
                    <th class="h-mw-80px">{{ __('system.crud.action') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($faqQuestions as $faqQuestion)
                    <tr>
                        <th scope="row" class="sorting_1">{{ $faqQuestion->id }}</th>
                        <td>{{ $faqQuestion->local_question }}</td>
                        <td>
                            {!! html()->form('delete', route('admin.faqs.destroy', ['faq' => $faqQuestion->id]))
                            ->class('data-confirm')
                            ->attribute('autocomplete', 'off')
                            ->attribute('data-confirm-message', __('system.fields.are_you_sure'))
                            ->attribute('data-confirm-title', __('system.crud.delete'))
                            ->id('delete-form_' . $faqQuestion->id)->open() !!}

                            <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                <a role="button" href="{{ route('admin.faqs.edit', ['faq' => $faqQuestion->id]) }}" class="btn btn-success">{{ __('system.crud.edit') }}</a>
                                <button type="submit" class="btn btn-danger">{{ __('system.crud.delete') }}</button>
                            </div>
                            {!! html()->closeModelForm() !!}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center">
                            {{ __('system.crud.data_not_found', ['table' => __('system.dashboard.faq')]) }}
                        </td>
                    </tr>
                @endforelse

            </tbody>
        </table>
    </div>
</div>
