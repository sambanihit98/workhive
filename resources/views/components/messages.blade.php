<div
    x-data="{
        message: @js(session('notify.message') ?? ''),
        status: @js(session('notify.status') ?? ''),
        show: @js(session()->has('notify')),
        statusClasses: {
            Success: ['bg-green-100 border-green-500 text-green-900', 'text-green-500'],
            Danger: ['bg-red-100 border-red-500 text-red-900', 'text-red-500'],
            Warning: ['bg-yellow-100 border-yellow-500 text-yellow-900', 'text-yellow-500'],
            Info: ['bg-blue-100 border-blue-500 text-blue-900', 'text-blue-500'],
            Secondary: ['bg-gray-100 border-gray-500 text-gray-900', 'text-gray-500']
        }
    }"
    x-init="if (show) { setTimeout(() => show = false, 5000) }"
    x-on:notify.window="
        message = $event.detail.message;
        status = $event.detail.status;
        show = true;
        setTimeout(() => show = false, 5000)
    "
    x-show="show"
    x-transition:leave="transition-opacity duration-500"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    x-cloak
    class="fixed bottom-0 right-0 z-20 m-2 border-t-4 rounded-b px-4 py-5 shadow-md"
    :class="statusClasses[status]?.[0] ?? statusClasses['Success'][0]"
    role="alert"
>
    <div class="flex">
        <div class="py-1">
            <svg class="fill-current h-6 w-6 mr-4" :class="(statusClasses[status]?.[1] ?? statusClasses['Success'][1])" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                <path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/>
            </svg>
        </div>
        <div>
            <p class="font-bold">Alert Message</p>
            <p class="text-sm" x-text="message"></p>
        </div>
    </div>
</div>
