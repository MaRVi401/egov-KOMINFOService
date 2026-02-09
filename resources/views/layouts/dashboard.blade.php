@extends('layouts.app')

@section('title', 'Final Test')

@section('content')
    <div class="p-4 border-2 border-default border-dashed rounded-base dark:border-default-medium">
        <h2 class="text-2xl font-bold text-heading mb-6">Overview Project Kominfo</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
            <div class="flex flex-col items-center justify-center h-32 rounded-base bg-neutral-secondary-soft border border-default dark:border-default-medium">
               <p class="text-3xl font-bold text-heading">24</p>
               <p class="text-sm text-body uppercase tracking-wider">Layanan Aktif</p>
            </div>
            <div class="flex flex-col items-center justify-center h-32 rounded-base bg-neutral-secondary-soft border border-default dark:border-default-medium">
               <p class="text-3xl font-bold text-heading">3.81</p>
               <p class="text-sm text-body uppercase tracking-wider">Indeks Kepuasan</p>
            </div>
            <div class="flex flex-col items-center justify-center h-32 rounded-base bg-neutral-secondary-soft border border-default dark:border-default-medium">
               <p class="text-3xl font-bold text-heading">100%</p>
               <p class="text-sm text-body uppercase tracking-wider">Uptime Sistem</p>
            </div>
        </div>

        <div class="w-full bg-neutral-primary-medium rounded-base border border-default dark:border-default-medium p-6 h-96 flex items-center justify-center">
            <span class="text-neutral-tertiary-medium italic text-lg text-center">
                Visualisasi Data Document Scanner YOLOv8 & Pathfinding Visualizer akan tampil di sini.
            </span>
        </div>
    </div>
@endsection