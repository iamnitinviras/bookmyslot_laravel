@extends('emails.layout')
@section('body')
    <table class="email_table" cellpadding="0" cellspacing="0">
        <tr>
            <td>
                <table class="email_table" cellpadding="0" cellspacing="0">
                    <tr>
                        <td class="email_table_td" >
                            <h2 class="email_table_td_h2">{{trans('system.email_messages.hello_admin')}}</h2>
                            <p class="email_table_td_p">{{trans('system.email_messages.testing_email_content')}}</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
@endsection
