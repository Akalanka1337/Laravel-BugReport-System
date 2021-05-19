@extends("dashboard.layouts.default")
@section('breadcrumbs')
    <li class="breadcrumb-item active"><a href="{{ route("dashboard.admiko_auditable_logs.index") }}">{{trans('global.auditable_title')}}</a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">{{trans('global.page_breadcrumbs_view')}}</li>
@endsection
@section('pageTitle')
    <h1>{{trans('global.auditable_title')}}</h1>
@endsection
@section('pageInfo')
@endsection
@section('backBtn')
    <a href="{{ route("dashboard.admiko_auditable_logs.index") }}"><i
            class="fas fa-angle-left"></i> {{trans('global.page_back_btn')}}</a>
@endsection
@section('content')
    <div class="card formPage viewPage">
        <legend class="action">{{ trans('global.view') }}</legend>
        <div class="card-body">
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">{{trans('global.auditable_time')}}:</label>
                <div class="col-sm-10 my-2">
                    {{$data->created_at}}
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">{{trans('global.auditable_action')}}:</label>
                <div class="col-sm-10 my-2">
                    {{$data->action}}
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">{{trans('global.auditable_user')}}:</label>
                <div class="col-sm-10 my-2">
                    {{$data->user_info->name}} / {{$data->user_info->email}} / ID: {{$data->user_id}}
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">{{trans('global.auditable_model')}}:</label>
                <div class="col-sm-10 my-2">
                    {{$data->model}}
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">{{trans('global.auditable_row_id')}}:</label>
                <div class="col-sm-10 my-2">
                    {{$data->row_id}}
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">{{trans('global.auditable_info')}}:</label>
                <div class="col-sm-10 my-2">
                    {{$data->info}}
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">{{trans('global.auditable_url')}}:</label>
                <div class="col-sm-10 my-2">
                    @if($data->action == 'created')
                        <a href="{{$data->url}}/{{$data->row_id}}/edit" target="_blank">{{$data->url}}/{{$data->row_id}}/edit</a>
                    @elseif($data->action == 'updated')
                        <a href="{{$data->url}}/edit" target="_blank">{{$data->url}}/edit</a>
                    @else
                        {{$data->url}}
                    @endif
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">{{trans('global.auditable_ip')}}:</label>
                <div class="col-sm-10 my-2">
                    {{$data->ip}}
                </div>
            </div>
        </div>
    </div>
@endsection
