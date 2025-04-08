
@extends('emails.layout')
@section('body')
    <table class="email_table" cellpadding="0" cellspacing="0">
        <tr>
            <td>
                <table class="email_table" cellpadding="0" cellspacing="0">
                    <tr>
                        <td class="email_table_td">
                            <h2 class="email_table_td_h2">{{trans('system.contact_us.hello')}}, {{$vendor_name}}</h2>
                            <p class="email_table_td_p">A new ticket has been created.</p>
                            <hr class="margin_bottom_20" />
                            <h3 class="comment_h3">You may view and respond to the ticket here {{$ticket_url}}</h3>
                            <hr class="margin_bottom_20" />
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
@endsection
