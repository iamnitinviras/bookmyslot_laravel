<div class="row">
    <div class="col-sm-12">
        <table class="table align-middle datatable dt-responsive table-check nowrap dataTable no-footer  table-bordered" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
            <thead>
                <tr role="row">
                    <th scope="col">
                        <div class="d-flex justify-content-between w-260px">
                            @sortablelink('name', __('system.testimonial.name'), [], ['class' => 'w-100 text-gray'])
                        </div>
                    </th>
                    <th scope="col">
                        <div class="d-flex justify-content-between w-150px">
                            @sortablelink('description', __('system.testimonial.description'), [], ['class' => 'w-100 text-gray'])
                        </div>
                    </th>
                    <th class="h-mw-80px">{{ __('system.crud.action') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($testimonials as $testimonial)
                    <tr>
                        <td>{{ $testimonial->name }}</td>
                        <td><a data-url="{{url('get-rightbar-content')}}" data-id="{{$testimonial->testimonial_id}}" data-action="testimonials"  onclick="show_rightbar_section(this)" href="javascript:void(0)">{{ __('system.fields.view') }}</a></td>
                        <td>
                            @if (auth()->user()->user_type == App\Models\User::USER_TYPE_ADMIN)
                                {!! html()->form('delete', route('admin.testimonials.destroy', ['testimonial' => $testimonial->testimonial_id]))
                                ->class('data-confirm')
                                ->attribute('autocomplete', 'off')
                                ->attribute('data-confirm-message', __('system.fields.are_you_sure'))
                                ->attribute('data-confirm-title', __('system.crud.delete'))
                                ->id('delete-form_' . $testimonial->testimonial_id) !!}
                            @endif

                            <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                <a role="button" href="{{ route('admin.testimonials.edit', ['testimonial' => $testimonial->testimonial_id]) }}" class="btn btn-success">{{ __('system.crud.edit') }}</a>
                                <button type="submit" class="btn btn-danger">{{ __('system.crud.delete') }}</button>
                            </div>
                            @if (auth()->user()->user_type == App\Models\User::USER_TYPE_ADMIN)
                                    {!! html()->closeModelForm() !!}
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center">
                            {{ __('system.crud.data_not_found', ['table' => __('system.dashboard.testimonials')]) }}
                        </td>
                    </tr>
                @endforelse

            </tbody>
        </table>
    </div>
</div>
