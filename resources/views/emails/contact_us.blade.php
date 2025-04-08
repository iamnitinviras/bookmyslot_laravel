@extends('emails.layout')
@section('body')
    <table class="copy_table" cellpadding="0" cellspacing="0">
        <tr>
            <td>
                <table class="email_table" cellpadding="0" cellspacing="0">
                    <tr>
                        <td class="email_table_td">
                            <h2 class="email_table_td_h2">{{trans('system.contact_us.hello')}}</h2>
                            <p class="email_table_td_p">{{trans('system.contact_us.contact_us_content')}}</p>
                            <hr class="margin_bottom_20" />
                            <h3 class="comment_h3"><b>{{trans('system.contact_us.name')}}</b>: {{ $name }}</h3>
                            <h3 class="comment_h3"><b>{{trans('system.contact_us.email')}}</b>: {{ $email }}</h3>
                            <h3 class="comment_h3"><b>{{trans('system.contact_us.message')}}</b>: {{ $user_message }}</h3>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
@endsection
