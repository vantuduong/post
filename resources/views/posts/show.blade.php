<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Post detail') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                   <div class="mb-4">
                       <div class="font-bold title">{{ $post->title }}</div>
                       <div class="subtitle">
                           <div class="mr-2">Author: {{ $post->user->name }}</div>
                           <div class="ml-2">Created at: {{ $post->created_at->format('d/m/Y H:i') }}</div>
                       </div>
                   </div>
                   <div>{!! \Illuminate\Support\Str::markdown($post->content) !!} </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
