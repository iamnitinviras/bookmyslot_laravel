@extends('emails.layout')
@section('body')
    <table class="email_table" cellpadding="0" cellspacing="0">
        <tr>
            <td>
                <table class="email_table" cellpadding="0" cellspacing="0">
                    <tr>
                        <td class="email_table_td">
                            <h2 class="email_table_td_h2">{{trans('system.contact_us.hello')}}, {{$name}}</h2>
                            <p class="email_table_td_p">{{$title}}</p>
                            <hr class="margin_bottom_20" />
                            <h3 class="comment_h3">{{trans('system.tickets.ticket_comment')}}</h3>
                            <p class="email_table_td_p">{!! $ticket_details !!}</p>
                            <p class="email_table_td_p">{{ $url }}</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
@endsection
