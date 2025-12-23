<div class="min-h-screen bg-gray-50 font-sans flex text-left">

    <!-- Sidebar -->
    @include('livewire.babysitter.babysitter-sidebar')

    <!-- Main Content -->
    <div class="ml-64 flex-1 flex flex-col min-h-screen">
        <livewire:shared.avis-page :intervenant-id="$intervenantId" service-name="Babysitting" theme="pink" />
    </div>
</div>