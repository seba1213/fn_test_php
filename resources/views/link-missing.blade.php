<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ __('errors.link_missing.title') }}</title>

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif
    </head>
    <body class="min-h-screen bg-gray-50 text-gray-900">
        <main class="mx-auto max-w-xl px-6 py-16">
            <h1 class="text-2xl font-semibold">{{ __('errors.link_missing.heading') }}</h1>
            <p class="mt-3 text-sm text-gray-600">
                {{ __('errors.link_missing.body') }}
            </p>
            <div class="mt-6">
                <a href="{{ url('/') }}" class="inline-flex items-center rounded-md bg-gray-900 px-4 py-2 text-sm font-medium text-white hover:bg-gray-800">
                    {{ __('errors.link_missing.home') }}
                </a>
            </div>
        </main>
    </body>
</html>

