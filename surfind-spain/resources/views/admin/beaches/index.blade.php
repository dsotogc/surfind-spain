<x-layouts::app :title="__('Playas')">
    <div class="flex h-full w-full flex-1 flex-col gap-6 rounded-xl">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-zinc-900 dark:text-white">Playas</h1>
                <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">Gestiona las playas publicadas en la aplicacion.</p>
            </div>

            @can('create beaches')
                <flux:button :href="route('admin.beaches.create')" variant="primary" wire:navigate>
                    Crear playa
                </flux:button>
            @endcan
        </div>
    </div>
</x-layouts::app>
