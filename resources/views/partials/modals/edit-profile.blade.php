{{-- File: resources/views/partials/modals/edit-profile.blade.php --}}

<div id="editProfileModal" tabindex="-1" aria-hidden="true" class="hidden fixed inset-0 z-50  items-center justify-center w-full h-full overflow-y-auto overflow-x-hidden">
    
    {{-- 1. LAYER BACKDROP BLUR --}}
    <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" onclick="toggleModal('editProfileModal')"></div>

    {{-- 2. MODAL CONTENT --}}
    <div class="relative p-4 w-full max-w-2xl max-h-full z-10">
        <form action="{{ route('profile.update') }}" ...>
                </form>
        </div>
</div>