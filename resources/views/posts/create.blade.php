<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $post ? __('Edit Post') : __('Update Post') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Session Status -->
                    <x-auth-session-status class="mb-4" :status="session('status')"/>

                    <!-- Validation Errors -->
                    <x-auth-validation-errors class="mb-4" :errors="$errors"/>

                    <form method="POST" action="{{ $post ? route('posts.update', $post->id) :route('posts.store') }}" id="createPostForm">
                        @csrf
                        @if($post)
                            @method('PUT')
                        @endif
                        <div>
                            <x-label for="title" :value="__('Title')"/>

                            <x-input id="title" class="block mt-1 w-full" type="text" name="title"
                                     :value="old('title') ?? optional($post)->title" autofocus/>
                        </div>

                        <div class="mt-4">
                            <div class="flex flex-col space-y-2">
                                <x-label for="editor" :value="__('Content')"/>
                                <div id="editor" class="markdown-editor mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                    <div>{!! \Illuminate\Support\Str::markdown(old('content') ?? (optional($post)->content) ?? '') !!}</div>
                                </div>
                                <input type="hidden" name="content" id="content" value="{{ old('content') ?? optional($post)->content }}">
                            </div>
                        </div>

                        <div class="mt-4">
                            <x-label for="schedule_publish" :value="__('Schedule publish')"/>

                            <x-input id="schedule_publish" class="block mt-1 w-full" type="datetime-local" name="schedule_publish"
                                     :value="old('schedule_publish')?? (optional($post)->schedule_publish ? \Carbon\Carbon::parse($post->schedule_publish)->toDateTimeLocalString() : '')" />
                        </div>
                        <div class="flex items-center justify-end mt-4">
                            <x-link href="{{ route('posts.index') }}">Cancel</x-link>

                            <x-button class="ml-3">
                                {{ __('Save') }}
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
