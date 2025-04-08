@extends('emails.layout')
@section('body')
    <table class="email_table" cellpadding="0" cellspacing="0">
        <tr>
            <td>
                <table class="email_table" cellpadding="0" cellspacing="0">
                    <tr>
                        <td class="email_table_td">
                            <h2 class="email_table_td_h2">{{trans('system.contact_us.hello')}}, {{$name}}</h2>
                            <p class="email_table_td_p">{{$email_text}}</p>
                            <p class="email_table_td_p">{{$ticket_subject}}</p>
                            <h3 class="comment_h3">{{trans('system.tickets.ticket_comment')}}</h3>
                            <hr class="margin_bottom_20" />
                            <p class="email_table_td_p">{!! $ticket_comment !!}</p>
                            <p class="email_table_td_p"><a href="{{ $url }}">{{ $url }}</a></p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
@endsection
