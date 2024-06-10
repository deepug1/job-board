<x-layout>
    @foreach ($Jobs as $job )
    <div>{{ $job->title}}</div>
    @endforeach
</x-layout>
