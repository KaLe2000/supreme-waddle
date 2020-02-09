@csrf
<div class="field mb-6">
    <label for="title" class="label text-sm mb-2 block">Title</label>

    <div class="control">
        <input
                class="input bg-transparent border border-gray-100 rounded p-2 text-xs w-full text-black"
                type="text" id="title" name="title" value="{{ $project->title }}">
    </div>
</div>
<div class="field mb-6">
    <label for="description">Description</label>

    <div class="control">
<textarea
        class="input bg-transparent border border-gray-100 rounded p-2 text-xs w-full text-black"
        name="description" id="description" cols="30" rows="10">{{ $project->description }}</textarea>
    </div>
</div>
<input class="button" type="submit" value="{{ $button }}">
<a href="{{ $project->path() }}">Cancel</a>

@if ($errors->any())
    <ul class="field mt-6">
       @foreach($errors->all() as $error)
           <li class="text-sm text-black">
               {{ $error }}
           </li>
        @endforeach
    </ul>
@endif