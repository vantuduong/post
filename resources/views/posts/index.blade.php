<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Your posts') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="">
                        <div class="flex">
                            <div class="mr-2">
                                <x-label>Created date</x-label>
                                <x-input name="created_at" type="date" value="{{ request()->input('created_at') }}"></x-input>
                            </div>
                            <div class="mr-2">
                                <x-label>Status</x-label>
                                <select name="status" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <option value="">All</option>
                                    <option value="1" {{ request()->input('status') === '1' ? 'selected' : '' }}>Published</option>
                                    <option value="0" {{ request()->input('status') === '0' ? 'selected' : '' }}>Unpublished</option>
                                </select>
                            </div>
                            <div>
                                <x-label>&nbsp;</x-label>
                                <x-button class="py-3 px-4">Search</x-button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="p-6 bg-white border-b border-gray-200">
                    <x-link href="{{ route('posts.create') }}" class="mb-4">
                        {{ __('Create') }}
                    </x-link>
                    <table class="w-full whitespace-no-wrap ">
                        <thead>
                            <tr class="text-center font-bold">
                                <th class="border px-6 py-4">Title</th>
                                <th class="border px-6 py-4">Author</th>
                                <th class="border px-6 py-4">Status</th>
                                <th class="border px-6 py-4">Schedule Publish</th>
                                <th class="border px-6 py-4 action">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($posts as $post)
                                <tr>
                                    <td class="border px-6 py-4 title-column">
                                        <a href="{{ route('posts.show', $post->id) }}">
                                            {{ $post->title }}
                                        </a>
                                    </td>
                                    <td class="border px-6 py-4">{{ optional($post->user)->name }}</td>
                                    <td class="border px-6 py-4 status-name">{{ $post->status_name }}</td>
                                    <td class="border px-6 py-4">{{ $post->schedule_publish }}</td>
                                    <td class="border px-6 py-4">
                                        <form action="{{ route('posts.destroy', $post->id) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            @can('update-status', $post)
                                                <x-button type="button" class="update-status" data-url="{{ route('posts.update-status', $post->id) }}">
                                                    {{ $post->status ? 'Un Publish' : 'Publish' }}
                                                </x-button>
                                            @endcan
                                            <x-link href="{{ route('posts.edit', $post->id) }}">Edit</x-link>
                                            <x-button class="bg-danger" onclick="return confirm('Are you sure?')">
                                                {{ __('Delete') }}
                                            </x-button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $posts->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $('.update-status').on('click', function () {
            const url = $(this).data('url');
            const row = $(this).parent().parent().parent();
            const self = $(this);

            $.ajax({
                url: url,
                type: 'PUT',
                data: {_token: '{{ csrf_token() }}'},
                success(data) {
                    if (data.data.status) {
                        self.html('Un Publish');
                        $(row).find('.status-name').html('Published');
                    } else {
                        self.html('Publish');
                        $(row).find('.status-name').html('UnPublished');
                    }
                }
            })
        })
    </script>
</x-app-layout>
