@extends('bisbond::layouts.app')

@section('title', 'Route Explorer')

@section('content')
<div x-data="{ search: '' }" class="space-y-6">
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h3 class="text-lg font-bold text-gray-800">Application Routes</h3>
            <p class="text-sm text-gray-500">Search and explore registered routes in your application.</p>
        </div>
        <div class="relative">
            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                <i class="fas fa-search"></i>
            </span>
            <input type="text" x-model="search" placeholder="Filter by URI or Name..." class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 w-full md:w-80">
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Method</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">URI</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <template x-for="route in {{ json_encode($routes) }}">
                    <tr x-show="route.uri.toLowerCase().includes(search.toLowerCase()) || (route.name && route.name.toLowerCase().includes(search.toLowerCase()))">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-indigo-100 text-indigo-800" x-text="route.method"></span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900" x-text="route.uri"></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500" x-text="route.name || '-'"></td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <button @click="navigator.clipboard.writeText(route.example); alert('URL copied!')" class="text-indigo-600 hover:text-indigo-900 mr-3">
                                <i class="fas fa-copy"></i>
                            </button>
                            <a :href="route.example" target="_blank" class="text-gray-400 hover:text-gray-600">
                                <i class="fas fa-external-link-alt"></i>
                            </a>
                        </td>
                    </tr>
                </template>
            </tbody>
        </table>
    </div>
</div>
@endsection
