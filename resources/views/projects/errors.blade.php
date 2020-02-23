@if ($errors->{ $bag ?? 'default' }->any())
    <ul class="field mt-6">
        @foreach($errors->{ $bag ?? 'default' }->all() as $error)
            <li class="text-sm text-white">
                {{ $error }}
            </li>
        @endforeach
    </ul>
@endif