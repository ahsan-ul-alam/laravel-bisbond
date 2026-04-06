@extends('bisbond::layouts.app')

@section('title', 'Command Explorer')

@section('content')
<div x-data="{ search: '' }" class="space-y-6">
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h3 class="text-lg font-bold text-gray-800">Artisan Commands</h3>
            <p class="text-sm text-gray-500">Explore and copy bisbond specific commands.</p>
        </div>
        <div class="relative">
            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                <i class="fas fa-search"></i>
            </span>
            <input type="text" x-model="search" placeholder="Search commands..." class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 w-full md:w-80">
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <template x-for="command in {{ json_encode($commands) }}">
            <div x-show="command.name.toLowerCase().includes(search.toLowerCase())" class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow group">
                <div class="flex items-center justify-between mb-3">
                    <span class="px-2 py-1 text-xs font-bold text-indigo-600 bg-indigo-50 rounded uppercase tracking-wider">CLI Command</span>
                    <button @click="navigator.clipboard.writeText(command.usage); alert('Command copied!')" class="text-gray-400 hover:text-indigo-600 transition">
                        <i class="fas fa-copy"></i>
                    </button>
                </div>
                <h4 class="text-lg font-bold text-gray-900 mb-2 font-mono" x-text="command.name"></h4>
                <p class="text-sm text-gray-600 mb-4" x-text="command.description"></p>
                <div class="bg-gray-50 p-3 rounded-lg font-mono text-xs text-indigo-700 flex items-center overflow-x-hidden">
                    <span class="mr-2">$</span>
                    <span x-text="command.usage"></span>
                </div>
            </div>
        </template>
    </div>
</div>
@endsection
