@extends('emails.layout')
@section('body')
    <!-- New Reply Received - ticket.subject -->
    <table class="email_table" cellpadding="0" cellspacing="0">
        <tr>
            <td>
                <table class="email_table" cellpadding="0" cellspacing="0">
                    <tr>
                        <td class="email_table_td">
                            <h2 class="email_table_td_h2">{{trans('system.contact_us.hello')}}, {{$agent_name}}</h2>
                            <p class="email_table_td_p">The customer has responded to the ticket.</p>
                            <hr class="margin_bottom_20" />
                            <h3 class="comment_h3">
                                {{$ticket_subject}}
                                {{$ticket_description}}
                                {{$ticket_url}}
                            </h3>
                            <hr class="margin_bottom_20" />
                            <p class="email_table_td_p">Regards</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
@endsection
