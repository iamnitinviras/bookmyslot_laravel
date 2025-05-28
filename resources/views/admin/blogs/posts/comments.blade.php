@extends('layouts.app')
@section('title', __('system.fields.comments'))
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">

                    <div class="row">
                        <div class="col-md-6 col-xl-6">
                            <h4 class="card-title">{{ __('system.fields.comments') }}</h4>
                            <div class="page-title-box pb-0 d-sm-flex">
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('system.dashboard.menu') }}</a></li>
                                        <li class="breadcrumb-item active">{{ __('system.fields.comments') }}</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <div id="restaurants_list" class="dataTables_wrapper dt-bootstrap4 no-footer table_filter">
                            <div id="data-preview" class='overflow-hidden'>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table class="table align-middle datatable dt-responsive table-check nowrap dataTable no-footer  table-bordered" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
                                            <thead>
                                            <tr role="row">
                                                <th scope="col">
                                                    <div class="d-flex justify-content-between w-100px">
                                                        @sortablelink('name', __('system.fields.name'), [], ['class' => 'w-100 text-gray'])
                                                    </div>
                                                </th>
                                                <th scope="col">
                                                    <div class="d-flex justify-content-between w-100px">
                                                        @sortablelink('email', __('system.fields.email'), [], ['class' => 'w-100 text-gray'])
                                                    </div>
                                                </th>

                                                <th scope="col">
                                                    <div class="d-flex justify-content-between w-260px">
                                                        @sortablelink('comment', __('system.fields.comment'), [], ['class' => 'w-100 text-gray'])
                                                    </div>
                                                </th>
                                                <th class="h-mw-80px">{{ __('system.fields.status') }}</th>
                                                <th class="h-mw-80px">{{ __('system.crud.action') }}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @forelse ($comments as $comment)
                                                <tr>
                                                    <td>{{ $comment->name }}</td>
                                                    <td>{{ $comment->email }}</td>
                                                    <td>
                                                        <p class="text-body mb-0">{{ $comment->comment }}</p>
                                                    </td>
                                                    <td>
                                                        <form id="update_feedback_comment_{{ $comment->id }}" action="{{ route('admin.blogs.comments.update',['comment'=>$comment->id]) }}" method="post">
                                                            @csrf
                                                            <select class="form-control {{displayFeedbackStatus($comment->status)}}" data-id="{{$comment->id}}" onchange="updateCommentApprovalStatus(this)" required name="approval_status">
                                                                @foreach(\App\Models\Blogs::APPROVAL_STATUS as $status)
                                                                    <option value="{{$status}}" @if($comment->status==$status) selected @endif>{{trans('system.plans.'.$status)}}</option>
                                                                @endforeach
                                                            </select>
                                                        </form>
                                                    </td>
                                                    <td>
                                                        {!! html()->form('delete', route('admin.comment.destroy', ['comment' => $comment->id]))
                                                         ->class('data-confirm')
                                                         ->attribute('autocomplete', 'off')
                                                         ->attribute('data-confirm-message', __('system.fields.are_you_sure'))
                                                         ->attribute('data-confirm-title', __('system.crud.delete'))
                                                         ->id('delete-form_' . $comment->id)->open() !!}

                                                        <div class="btn-group btn-group-sm" role="group">
                                                            <button type="submit" class="btn btn-danger">{{ __('system.crud.delete') }}</button>
                                                        </div>

                                                        {!! html()->closeModelForm() !!}
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center">
                                                        {{ __('system.crud.data_not_found', ['table' => __('system.fields.comments')]) }}
                                                    </td>
                                                </tr>
                                            @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
