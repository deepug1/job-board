<x-layout>
  <x-bc class="mb-4"
    :links="['My Job Applications' => '#']" />

  @forelse ($applications as $application)
    <x-job-card :job="$application->job"></x-job-card>
  @empty
  @endforelse
</x-layout>