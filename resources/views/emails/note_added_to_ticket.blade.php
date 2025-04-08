@extends('emails.layout')
@section('body')
    <!-- Note Added - [#{{$ticket_id}}] {{$ticket_subject}} -->
    <table class="email_table" cellpadding="0" cellspacing="0">
        <tr>
            <td>
                <table class="email_table" cellpadding="0" cellspacing="0">
                    <tr>
                        <td class="email_table_td">
                            <h2 class="email_table_td_h2">{{trans('system.contact_us.hello')}}, {{$agent_name}}</h2>
                            <p class="email_table_td_p">{comment.commenter.name}} added a note and wants you to have a look.</p>
                            <hr class="margin_bottom_20" />
                            <h3 class="comment_h3">
                                Ticket URL:
                                {{ticket.url}}

                                Subject:
                                {{ticket.subject}}

                                Requester: {{ticket.requester.name}}

                                Note Content:
                                {{comment.body}}
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
