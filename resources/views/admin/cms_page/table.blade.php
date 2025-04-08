<div class="row">
    <div class="col-sm-12">
        <table class="table align-middle datatable dt-responsive table-check nowrap dataTable no-footer  table-bordered" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
            <thead>
                <tr role="row">
                    <th scope="col">
                        <div class="d-flex justify-content-between w-260px">
                            @sortablelink('Title', __('system.cms.title'), [], ['class' => 'w-100 text-gray'])
                        </div>
                    </th>
                    <th class="h-mw-80px">{{ __('system.crud.action') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($cmsPages as $cmsPage)
                    <tr>
                        <td>{{ $cmsPage->local_title }}</td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                <a role="button" href="{{ route('admin.cms-page.edit', ['cms_page' => $cmsPage->id]) }}" class="btn btn-success">{{ __('system.crud.edit') }}</a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" class="text-center">
                            {{ __('system.crud.data_not_found', ['table' => __('system.dashboard.cms')]) }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
