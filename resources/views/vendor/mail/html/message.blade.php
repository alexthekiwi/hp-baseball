<x-mail::layout>
{{-- Header --}}
<x-slot:header>
<x-mail::header :url="config('app.url')">
<img src="{{ config('app.url') . '/logo.png' }}" class="logo" alt="Howick Pakuranga Baseball Club" width="197" height="56">
</x-mail::header>
</x-slot:header>

{{-- Body --}}
{{ $slot }}

{{-- Subcopy --}}
@isset($subcopy)
<x-slot:subcopy>
<x-mail::subcopy>
{{ $subcopy }}
</x-mail::subcopy>
</x-slot:subcopy>
@endisset

{{-- Footer --}}
<x-slot:footer>
<x-mail::footer>
<div></div>
<p style="margin: 0;"><a style="color: #58595b;" href="https://hpbaseball.co.nz">hpbaseball.co.nz</a></p>
<p style="margin: 0; color: #58595b;">© Howick Pakuranga Baseball Club {{ date('Y') }}</p>
</x-mail::footer>
</x-slot:footer>
</x-mail::layout>
