<div class="min-h-screen bg-gray-50 font-sans flex text-left">
    <!-- Sidebar -->
    @include('livewire.babysitter.babysitter-sidebar')

    <!-- Main Content -->
    <div class="ml-64 flex-1 flex flex-col min-h-screen">
        <div class="flex-1">
            <livewire:shared.avis-page :intervenant-id="$intervenantId" />
        </div>
    </div>
</div>