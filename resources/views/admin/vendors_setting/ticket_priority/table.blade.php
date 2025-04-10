<div class="row">
    <div class="col-sm-12">
        <table class="table align-middle datatable dt-responsive table-check nowrap dataTable no-footer  table-bordered"
            id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
            <thead>
                <tr role="row">
                    <th scope="col">
                        <div class="d-flex justify-content-between w-260px">
                            @sortablelink('title', __('system.fields.title'), [], ['class' => 'w-100 text-gray'])
                        </div>
                    </th>
                    <th class="h-mw-80px">{{ __('system.crud.action') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($prorities as $prority)
                    <tr>
                        <td>{{ $prority->local_lang_title }}</td>
                        <td>
                            <form
                                action="{{ route('admin.ticket-priorities.destroy', ['ticket_priority' => $prority->id]) }}"
                                method="POST" autocomplete="off" class="data-confirm"
                                data-confirm-message="{{ __('system.fields.are_you_sure') }}"
                                data-confirm-title="{{ __('system.crud.delete') }}" id="delete-form_{{ $prority->id }}">
                                @csrf
                                @method('DELETE')
                                <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                    <a role="button"
                                        href="{{ route('admin.ticket-priorities.edit', ['ticket_priority' => $prority->id]) }}"
                                        class="btn btn-success">{{ __('system.crud.edit') }}</a>
                                    <button type="submit" class="btn btn-danger">{{ __('system.crud.delete') }}</button>
                                </div>
                                {!! html()->closeModelForm() !!}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" class="text-center">
                            {{ __('system.crud.data_not_found', ['table' => __('system.ticket_priority.title')]) }}
                        </td>
                    </tr>
                @endforelse

            </tbody>
        </table>
    </div>
</div>
