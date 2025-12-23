<div class="flex h-screen bg-[#F3F4F6] font-sans overflow-hidden">

    {{-- SIDEBAR --}}
    @livewire('tutoring.components.professeur-sidebar', ['currentPage' => 'tutoring-avis'])

    {{-- CONTENU PRINCIPAL --}}
    <main class="flex-1 overflow-y-auto p-8">
        <livewire:shared.avis-page :intervenant-id="$intervenantId" service-name="Soutien Scolaire" theme="blue" />
    </main>
</div>