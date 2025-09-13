@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Howick Pakuranga Baseball Club')
<img src="{{ asset('logo.png') }}" class="logo" alt="Howick Pakuranga Baseball Club">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
