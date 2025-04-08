@extends('emails.layout')
@section('body')
    <table class="email_table" cellpadding="0" cellspacing="0">
        <tr>
            <td>
                <table class="email_table" cellpadding="0" cellspacing="0">
                    <tr>
                        <td class="email_table_td">
                            <h2 class="email_table_td_h2">{{trans('system.contact_us.hello')}}, {{$customer_name}}</h2>
                            <p class="email_table_td_p">{{trans('auth.reset_password.reset_email_content')}}</p>
                            <hr class="margin_bottom_20" />
                            <h3 class="comment_h3"><a href="{{ $url }}" class="button">{{trans('auth.reset_password.reset_pwd_btn')}}</a></h3>
                            <h3 class="comment_h3">{{trans('auth.reset_password.reset_email_line_two')}}</h3>
                            <hr class="margin_bottom_20" />
                            <p class="email_table_td_p">{{trans('auth.reset_password.reset_copy_link')}}</p>
                            <p class="email_table_td_p">{{ $url }}</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
@endsection
