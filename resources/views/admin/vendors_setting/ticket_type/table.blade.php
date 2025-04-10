<div class="row">
    <div class="col-sm-12">
        <table class="table align-middle datatable dt-responsive table-check nowrap dataTable no-footer  table-bordered"
            id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
            <thead>
                <tr role="row">
                    <th scope="col">
                        <div class="d-flex justify-content-between w-260px">
                            @sortablelink('question', __('system.fields.title'), [], ['class' => 'w-100 text-gray'])
                        </div>
                    </th>
                    <th class="h-mw-80px">{{ __('system.crud.action') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($types as $type)
                    <tr>
                        <td>{{ $type->local_lang_title }}</td>
                        <td>
                            <form action="{{ route('admin.ticket-types.destroy', ['ticket_type' => $type->id]) }}"
                                method="POST" autocomplete="off" class="data-confirm"
                                data-confirm-message="{{ __('system.fields.are_you_sure') }}"
                                data-confirm-title="{{ __('system.crud.delete') }}" id="delete-form_{{ $type->id }}">
                                @csrf
                                @method('DELETE')
                                <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                    <a role="button"
                                        href="{{ route('admin.ticket-types.edit', ['ticket_type' => $type->id]) }}"
                                        class="btn btn-success">{{ __('system.crud.edit') }}</a>
                                    <button type="submit" class="btn btn-danger">{{ __('system.crud.delete') }}</button>
                                </div>
                                {!! html()->closeModelForm() !!}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" class="text-center">
                            {{ __('system.crud.data_not_found', ['table' => __('system.ticket_type.title')]) }}
                        </td>
                    </tr>
                @endforelse

            </tbody>
        </table>
    </div>
</div>
