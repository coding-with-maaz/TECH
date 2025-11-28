@extends('layouts.app')

@section('title', 'Add Episode - ' . $content->title)

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900 dark:!text-white" style="font-family: 'Poppins', sans-serif; font-weight: 700;">
            Add Episode - {{ $content->title }}
        </h1>
        <p class="text-gray-600 dark:!text-text-secondary mt-1" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
            Create a new episode for this TV show
        </p>
    </div>

    <div class="bg-white dark:!bg-bg-card rounded-lg border border-gray-200 dark:!border-border-secondary p-6">
        <form action="{{ route('admin.episodes.store', $content) }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="episode_number" class="block text-sm font-semibold text-gray-900 dark:!text-white mb-2" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                        Episode Number <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="episode_number" id="episode_number" value="{{ old('episode_number') }}" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-white dark:!bg-bg-card dark:!border-border-primary dark:!text-white focus:ring-2 focus:ring-accent focus:border-transparent"
                           style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                    @error('episode_number')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="flex items-center gap-2 mt-6">
                        <input type="checkbox" name="is_published" id="is_published" value="1" {{ old('is_published', true) ? 'checked' : '' }}
                               class="w-4 h-4 text-accent border-gray-300 rounded focus:ring-accent">
                        <span class="text-sm font-semibold text-gray-900 dark:!text-white" style="font-family: 'Poppins', sans-serif; font-weight: 600;">Published</span>
                    </label>
                    @error('is_published')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-6">
                <label for="title" class="block text-sm font-semibold text-gray-900 dark:!text-white mb-2" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                    Title <span class="text-red-500">*</span>
                </label>
                <input type="text" name="title" id="title" value="{{ old('title') }}" required
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-white dark:!bg-bg-card dark:!border-border-primary dark:!text-white focus:ring-2 focus:ring-accent focus:border-transparent"
                       style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                @error('title')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-6">
                <label for="description" class="block text-sm font-semibold text-gray-900 dark:!text-white mb-2" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                    Description
                </label>
                <textarea name="description" id="description" rows="4"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-white dark:!bg-bg-card dark:!border-border-primary dark:!text-white focus:ring-2 focus:ring-accent focus:border-transparent"
                          style="font-family: 'Poppins', sans-serif; font-weight: 400;">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
                <div>
                    <label for="air_date" class="block text-sm font-semibold text-gray-900 dark:!text-white mb-2" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                        Air Date
                    </label>
                    <input type="date" name="air_date" id="air_date" value="{{ old('air_date') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-white dark:!bg-bg-card dark:!border-border-primary dark:!text-white focus:ring-2 focus:ring-accent focus:border-transparent"
                           style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                    @error('air_date')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="duration" class="block text-sm font-semibold text-gray-900 dark:!text-white mb-2" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                        Duration (minutes)
                    </label>
                    <input type="number" name="duration" id="duration" value="{{ old('duration') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-white dark:!bg-bg-card dark:!border-border-primary dark:!text-white focus:ring-2 focus:ring-accent focus:border-transparent"
                           style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                    @error('duration')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="sort_order" class="block text-sm font-semibold text-gray-900 dark:!text-white mb-2" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                        Sort Order
                    </label>
                    <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', 0) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-white dark:!bg-bg-card dark:!border-border-primary dark:!text-white focus:ring-2 focus:ring-accent focus:border-transparent"
                           style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                    @error('sort_order')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-6">
                <label for="thumbnail_path" class="block text-sm font-semibold text-gray-900 dark:!text-white mb-2" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                    Thumbnail URL/Path
                </label>
                <input type="text" name="thumbnail_path" id="thumbnail_path" value="{{ old('thumbnail_path') }}"
                       placeholder="https://example.com/image.jpg or storage/path/to/image.jpg"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-white dark:!bg-bg-card dark:!border-border-primary dark:!text-white focus:ring-2 focus:ring-accent focus:border-transparent"
                       style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                @error('thumbnail_path')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-8 flex items-center justify-end gap-4">
                <a href="{{ route('admin.episodes.index', $content) }}" class="px-6 py-2 bg-gray-100 hover:bg-gray-200 text-gray-900 rounded-lg transition-colors dark:!bg-bg-card dark:!text-white dark:!hover:bg-bg-card-hover" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2 bg-accent hover:bg-accent-light text-white rounded-lg transition-colors" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                    Create Episode
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

