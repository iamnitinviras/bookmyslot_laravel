@props(['url'])
<tr class="headerTr">
    <td class="header">
        <a href="{{ $url }}" style="display: inline-block;">
            <img src="{{ asset(config('app.logo')) }}" width="260" height="60" class="logo" alt="{{ config('app.name') }}">
        </a>
    </td>
</tr>
