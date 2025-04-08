@extends('emails.layout')
@section('body')
    <table class="email_table" cellpadding="0" cellspacing="0">
        <tr>
            <td>
                <table class="email_table" cellpadding="0" cellspacing="0">
                    <tr>
                        <td class="email_table_td">
                            <h2 class="email_table_td_h2">{{trans('system.contact_us.hello')}}, {{$vendor_name}}</h2>
                            <p class="email_table_td_p">{{trans('system.frontend.new_comment_details')}}</p>
                            <hr class="margin_bottom_20" />
                            <h3 class="comment_h3"><b>{{trans('system.fields.title')}}</b>: {{ $title }}</h3>
                            <h3 class="comment_h3"><b>{{trans('system.fields.description')}}</b>: {{ $description }}</h3>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
@endsection
