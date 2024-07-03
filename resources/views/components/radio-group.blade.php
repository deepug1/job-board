<div>
    <label for="{{ $name }}" class="mb-1 flex items-center">
        <input type="radio" name="{{ $name }}" value="" id="experience" class="mr-1" @checked(!request('name')) />
        <span class="ml-2">All</span>
    </label>


    @if ($allOption)
    <label for="{{ $name }}" class="mb-1 flex items-center">
        <input type="radio" name="{{ $name }}" value="" @checked(!request($name)) />
        <span class="ml-2">All</span>
    </label>
    @endif

    @foreach ($options as $option)
    <label for="{{ $name }}" class="mb-1 flex items-center">
        <input type="radio" name="{{ $name }}" value="{{ $option }}" id="experience" class="mr-1"
            @checked($option===($value ?? request($name))) />
        <span class="ml-2 text-transform: capitalize">{{ $option }}</span>
    </label>

    @endforeach

    @error($name)
    <div class="mt-1 text-xs text-red-500">
        {{ $message }}
    </div>
    @enderror
</div>