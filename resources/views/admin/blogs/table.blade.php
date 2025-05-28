<div class="row">
    <div class="col-sm-12">
        <table class="table align-middle datatable dt-responsive table-check nowrap dataTable no-footer  table-bordered"
            id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
            <thead>
                <tr role="row">
                    <th scope="col">
                        <div class="d-flex justify-content-between w-260px">
                            @sortablelink('title', __('system.blogs.title'), [], ['class' => 'w-100 text-gray'])
                        </div>
                    </th>
                    <th scope="col">
                        <div class="d-flex justify-content-between w-100px">
                            @sortablelink('category_id', __('system.blog_categories.title'), [], ['class' => 'w-100 text-gray'])
                        </div>
                    </th>

                    <th scope="col">
                        <div class="d-flex justify-content-between">
                            @sortablelink('status', __('system.fields.status'), [], ['class' => 'text-gray'])
                        </div>
                    </th>

                    <th scope="col">
                        <div class="d-flex justify-content-between">
                            @sortablelink('total_views', __('system.blogs.total_views'), [], ['class' => 'text-gray'])
                        </div>
                    </th>
                    <th class="h-mw-80px">{{ __('system.crud.action') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($blogs as $blog)
                            <tr>
                                <td>
                                    <p class="text-body mb-0">{{ $blog->local_title }}</p>
                                    <p class="mb-0 badge bg-success">{{ $blog->read_time }} {{trans('system.blogs.minutes_read')}}
                                    </p>
                                </td>

                                <td>
                                    <span class="text-body">{{ $blog->category->lang_name }}</span>
                                </td>
                                <td>
                                    {!! displayBlogStatus($blog->status) !!}
                                </td>
                                <td>
                                    <span class="text-body">{{ $blog->total_views }}</span>
                                </td>
                                <td>
                                    {!! html()->form('delete', route('admin.blogs.destroy', ['blog' => $blog->id]))
                    ->class('data-confirm')
                    ->attribute('autocomplete', 'off')
                    ->attribute('data-confirm-message', __('system.fields.are_you_sure'))
                    ->attribute('data-confirm-title', __('system.crud.delete'))
                    ->id('delete-form_' . $blog->id)->open() !!}

                                    <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                        <a role="button" href="{{ route('admin.blogs.edit', ['blog' => $blog->id]) }}"
                                            class="btn btn-success">{{ __('system.crud.edit') }}</a>
                                        <button type="submit" class="btn btn-danger">{{ __('system.crud.delete') }}</button>
                                    </div>

                                    {!! html()->closeModelForm() !!}
                                </td>
                            </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">
                            {{ __('system.crud.data_not_found', ['table' => __('system.blogs.title')]) }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
