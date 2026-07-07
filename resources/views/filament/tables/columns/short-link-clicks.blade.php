@php
    /** @var \App\Models\ShortLink $record */
    $record = $getRecord();
@endphp

<div
    class="flex items-center gap-2 text-sm"
    x-data="{
        loading: true,
        value: null,
        error: false,
        loadingText: @js(__('short_links.clicks.loading')),
        async load() {
            const url = @js(route('api.short-links.stats', ['shortLink' => $record->getKey()]));

            try {
                const res = await fetch(url, {
                    method: 'GET',
                    headers: { 'X-Requested-With': 'XMLHttpRequest' },
                    credentials: 'same-origin',
                });

                if (!res.ok) throw new Error('bad_status');

                const data = await res.json();
                this.value = data?.total_clicks ?? 0;
            } catch (e) {
                this.error = true;
            } finally {
                this.loading = false;
            }
        },
        enqueue() {
            window.__shortLinkStatsQueue ??= { running: false, jobs: [] };
            window.__shortLinkStatsQueue.jobs.push(() => this.load());
            this.runQueue();
        },
        async runQueue() {
            const q = window.__shortLinkStatsQueue;
            if (!q || q.running) return;
            q.running = true;
            while (q.jobs.length) {
                const job = q.jobs.shift();
                try { await job(); } catch (e) {}
            }
            q.running = false;
        },
    }"
    x-init="enqueue()"
>
    <template x-if="loading">
        <span class="inline-flex items-center gap-2 text-gray-500">
            <svg class="h-4 w-4 animate-spin text-gray-400" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 0 1 8-8v4a4 4 0 0 0-4 4H4z"></path>
            </svg>
            <span x-text="loadingText"></span>
        </span>
    </template>

    <template x-if="!loading && error">
        <span class="text-gray-500">—</span>
    </template>

    <template x-if="!loading && !error">
        <span class="font-medium text-gray-900" x-text="value"></span>
    </template>
</div>

