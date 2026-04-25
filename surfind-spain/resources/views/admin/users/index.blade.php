<x-layouts::app :title="__('Usuarios')">
    <div class="flex h-full w-full flex-1 flex-col gap-6 rounded-xl">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-zinc-900 dark:text-white">Usuarios</h1>
                <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">Gestiona usuarios, roles y acceso a la aplicacion.</p>
            </div>

            @can('manage users')
                <flux:button :href="route('admin.users.create')" variant="primary" wire:navigate>
                    Crear usuario
                </flux:button>
            @endcan
        </div>
    </div>
</x-layouts::app>
