<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Mulish:wght@400;700&display=swap" rel="stylesheet">
    <title>{{config('app.name')}}</title>
    <link rel="stylesheet" href="{{ asset('assets/css/email.css') }}" />
    @include('email_css')
</head>
<body class="email_body">
<table class="email_body_table" border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td class="email_body_table_td">
            <a href="{{url('')}}" title="{{config('app.name')}}">
                <img src="{{URL::asset(config('app.logo'))}}" class="email_body_table_td_img">
            </a>
        </td>
    </tr>
    <tr>
        <td class="yield_parent">
            @yield('body')
        </td>
    </tr>
    <tr>
        <td class="padding_20">
            <table class="copy_table" cellpadding="0" cellspacing="0">
                <tr>
                    <td class="text_center">
                        <p class="footer_p">{{trans('system.email_messages.email_bottom_content')}} {{config('app.name')}}.© {{date('Y')}}</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
