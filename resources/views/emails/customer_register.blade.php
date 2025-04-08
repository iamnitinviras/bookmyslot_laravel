@extends('emails.layout')
@section('body')
    <table class="email_table" cellpadding="0" cellspacing="0">
        <tr>
            <td>
                <table class="email_table" cellpadding="0" cellspacing="0">
                    <tr>
                        <td class="email_table_td">
                            <h2 class="email_table_td_h2">{{trans('system.contact_us.hello')}}, {{$customer_name}}</h2>
                            <p class="email_table_td_p">{{trans('auth.register_main_title')}}</p>
                            <hr class="margin_bottom_20" />
                            <p class="email_table_td_p">{{trans('auth.here_are_login_details')}}</p>
                            <h3 class="comment_h3"><b>{{trans('auth.login_url')}}</b>: <a href="{{ $login_url }}">{{ $login_url }}</a></h3>
                            <h3 class="comment_h3"><b>{{trans('system.fields.email')}}</b>: {{ $email }}</h3>
                            <h3 class="comment_h3"><b>{{trans('system.fields.password')}}</b>: {{ $password }}</h3>
                            <hr class="margin_bottom_20" />
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
@endsection
