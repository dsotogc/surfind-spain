<x-layouts::public :title="$beach->name">
    @php($coverUrl = $beach->coverImage?->url())

    <article class="relative z-10 mx-auto max-w-7xl px-5 pb-16 pt-8 sm:px-8 lg:px-10">
        <div class="mb-6">
            <a href="{{ route('beaches.index') }}" class="inline-flex items-center gap-2 rounded-full border border-[#85C3D4]/45 bg-white/65 px-4 py-2 text-sm font-bold text-[#114857] shadow-sm shadow-[#5097AB]/10 transition hover:bg-white hover:text-[#002833]" wire:navigate>
                <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                </svg>
                Volver a playas
            </a>
        </div>

        <section class="overflow-hidden rounded-[2.5rem] border border-[#85C3D4]/45 bg-white/70 shadow-2xl shadow-[#114857]/10 backdrop-blur">
            <div class="relative h-[22rem] bg-[#85C3D4]/15 md:h-[32rem]">
                @if ($coverUrl)
                    <img src="{{ $coverUrl }}" alt="{{ $beach->coverImage?->alt_text ?? $beach->name }}" class="h-full w-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-[#002833]/80 via-[#002833]/25 to-transparent"></div>
                @else
                    <div class="grid h-full place-items-center text-[#114857]">
                        <div class="text-center">
                            <svg class="mx-auto size-16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 17c3-4 6-4 9 0s6 4 9 0M4 13c2-2 4-2 6 0s4 2 6 0 3-2 4-1M8 7h.01M5 21h14a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2Z" />
                            </svg>
                            <p class="mt-3 text-sm font-bold">Sin portada disponible</p>
                        </div>
                    </div>
                @endif

                <div class="absolute bottom-0 left-0 right-0 p-6 md:p-8">
                    <div class="flex flex-wrap gap-2">
                        <span class="rounded-full bg-white/90 px-3 py-1 text-xs font-bold text-[#114857] shadow-sm backdrop-blur">{{ $beach->location?->name }}</span>

                        @if ($beach->difficulty)
                            <span class="rounded-full bg-[#002833]/85 px-3 py-1 text-xs font-bold text-white shadow-sm backdrop-blur">{{ $difficulties[$beach->difficulty] }}</span>
                        @endif
                    </div>

                    <h1 class="mt-4 max-w-4xl text-4xl font-black tracking-tight text-white md:text-6xl">{{ $beach->name }}</h1>

                    @if ($beach->short_description)
                        <p class="mt-4 max-w-3xl text-base leading-7 text-white/90 md:text-lg">{{ $beach->short_description }}</p>
                    @endif
                </div>
            </div>
        </section>

        <div class="mt-8 grid gap-8 xl:grid-cols-[1fr_360px]">
            <div class="space-y-8">
                <section class="rounded-[2rem] border border-[#85C3D4]/40 bg-white/75 p-6 shadow-xl shadow-[#114857]/5 backdrop-blur md:p-8">
                    <h2 class="text-2xl font-black text-[#002833]">Descripcion</h2>
                    <p class="mt-5 whitespace-pre-line text-base leading-8 text-[#266C80]">{{ $beach->description ?: 'Esta playa aun no tiene una descripcion completa.' }}</p>
                </section>

                <section class="rounded-[2rem] border border-[#85C3D4]/40 bg-white/75 p-6 shadow-xl shadow-[#114857]/5 backdrop-blur md:p-8">
                    <div class="flex flex-col gap-2 md:flex-row md:items-end md:justify-between">
                        <div>
                            <h2 class="text-2xl font-black text-[#002833]">Servicios</h2>
                            <p class="mt-2 text-sm leading-6 text-[#266C80]">Servicios y caracteristicas disponibles en esta playa.</p>
                        </div>
                    </div>

                    <div class="mt-5 flex flex-wrap gap-2">
                        @forelse ($beach->amenities as $amenity)
                            <span class="rounded-full border border-[#85C3D4]/45 bg-[#85C3D4]/12 px-4 py-2 text-sm font-bold text-[#114857]">{{ $amenity->name }}</span>
                        @empty
                            <span class="text-sm font-semibold text-[#5097AB]">Aun no hay servicios indicados.</span>
                        @endforelse
                    </div>
                </section>

                <section class="rounded-[2rem] border border-[#85C3D4]/40 bg-white/75 p-6 shadow-xl shadow-[#114857]/5 backdrop-blur md:p-8">
                    <h2 class="text-2xl font-black text-[#002833]">Galeria</h2>
                    <p class="mt-2 text-sm leading-6 text-[#266C80]">Imagenes asociadas a la playa. La portada aparece marcada desde el panel de administracion.</p>

                    <div class="mt-5 grid gap-4 sm:grid-cols-2">
                        @forelse ($beach->images as $image)
                            @php($imageUrl = $image->url())
                            <div class="group overflow-hidden rounded-3xl border border-[#85C3D4]/40 bg-white shadow-sm shadow-[#5097AB]/10">
                                @if ($imageUrl)
                                    <img src="{{ $imageUrl }}" alt="{{ $image->alt_text ?? $beach->name }}" class="h-52 w-full object-cover transition duration-500 group-hover:scale-105">
                                @else
                                    <div class="grid h-52 place-items-center bg-[#85C3D4]/12 text-sm font-semibold text-[#5097AB]">Sin imagen</div>
                                @endif

                                @if ($image->is_cover)
                                    <div class="px-4 py-3 text-xs font-bold uppercase tracking-[0.22em] text-[#114857]">Portada</div>
                                @endif
                            </div>
                        @empty
                            <p class="text-sm font-semibold text-[#5097AB]">Aun no hay imagenes adicionales.</p>
                        @endforelse
                    </div>
                </section>

                <section id="comentarios" class="rounded-[2rem] border border-dashed border-[#5097AB]/60 bg-white/60 p-6 shadow-xl shadow-[#114857]/5 backdrop-blur md:p-8">
                    <div class="flex flex-col gap-3 md:flex-row md:items-start md:justify-between">
                        <div>
                            <p class="text-sm font-bold uppercase tracking-[0.28em] text-[#5097AB]">Comunidad</p>
                            <h2 class="mt-2 text-2xl font-black text-[#002833]">Comentarios</h2>
                            <p class="mt-3 max-w-2xl text-sm leading-6 text-[#266C80]">Aqui se mostraran los comentarios publicados de esta playa y, mas adelante, el formulario para participar si el usuario ha iniciado sesion.</p>
                        </div>

                        <div class="rounded-full bg-[#002833] px-4 py-2 text-sm font-bold text-white">
                            {{ $beach->published_comments_count }} {{ $beach->published_comments_count === 1 ? 'comentario' : 'comentarios' }}
                        </div>
                    </div>

                    <div class="mt-6 rounded-3xl border border-[#85C3D4]/35 bg-[#F7FBFC]/80 p-5 text-sm leading-6 text-[#266C80]">
                        Proxima fase: listado de comentarios, alta de comentarios para usuarios autenticados y acciones de moderacion mediante permisos.
                    </div>
                </section>
            </div>

            <aside class="space-y-5 xl:sticky xl:top-6 xl:self-start">
                <section class="rounded-[2rem] border border-[#85C3D4]/40 bg-white/75 p-6 shadow-xl shadow-[#114857]/5 backdrop-blur">
                    <h2 class="text-lg font-black text-[#002833]">Datos rapidos</h2>

                    <dl class="mt-5 space-y-4 text-sm">
                        <div>
                            <dt class="font-bold uppercase tracking-[0.2em] text-[#5097AB]">Provincia</dt>
                            <dd class="mt-1 font-semibold text-[#002833]">{{ $beach->location?->name }}</dd>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <dt class="font-bold uppercase tracking-[0.2em] text-[#5097AB]">Latitud</dt>
                                <dd class="mt-1 font-semibold text-[#002833]">{{ $beach->latitude }}</dd>
                            </div>

                            <div>
                                <dt class="font-bold uppercase tracking-[0.2em] text-[#5097AB]">Longitud</dt>
                                <dd class="mt-1 font-semibold text-[#002833]">{{ $beach->longitude }}</dd>
                            </div>
                        </div>

                        <div>
                            <dt class="font-bold uppercase tracking-[0.2em] text-[#5097AB]">Publicada</dt>
                            <dd class="mt-1 font-semibold text-[#002833]">{{ $beach->published_at?->format('d/m/Y') }}</dd>
                        </div>
                    </dl>
                </section>

                <section class="grid grid-cols-2 gap-3">
                    <div class="rounded-3xl border border-[#85C3D4]/40 bg-white/75 p-5 text-center shadow-sm shadow-[#5097AB]/10 backdrop-blur">
                        <div class="text-3xl font-black text-[#114857]">{{ $beach->published_comments_count }}</div>
                        <div class="mt-1 text-xs font-bold uppercase tracking-[0.2em] text-[#5097AB]">Comentarios</div>
                    </div>

                    <div class="rounded-3xl border border-[#85C3D4]/40 bg-white/75 p-5 text-center shadow-sm shadow-[#5097AB]/10 backdrop-blur">
                        <div class="text-3xl font-black text-[#114857]">{{ $beach->favorited_by_users_count }}</div>
                        <div class="mt-1 text-xs font-bold uppercase tracking-[0.2em] text-[#5097AB]">Guardadas</div>
                    </div>
                </section>

                <a href="{{ route('map') }}" class="block rounded-[2rem] bg-[#002833] p-6 text-white shadow-xl shadow-[#114857]/15 transition hover:-translate-y-0.5 hover:bg-[#114857]" wire:navigate>
                    <span class="text-sm font-bold uppercase tracking-[0.28em] text-[#85C3D4]">Mapa</span>
                    <span class="mt-2 block text-xl font-black">Ver ubicacion</span>
                    <span class="mt-3 block text-sm leading-6 text-white/75">Cuando el mapa interactivo este disponible, esta accion llevara directamente a la playa.</span>
                </a>
            </aside>
        </div>
    </article>
</x-layouts::public>
