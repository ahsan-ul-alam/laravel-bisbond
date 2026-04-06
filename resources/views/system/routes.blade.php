@extends('bisbond::layouts.app')

@section('title', 'Route Explorer')

@section('content')
<div x-data="{ search: '' }" class="space-y-6">
    <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h3 class="text-xl font-black text-slate-800 uppercase tracking-tight">Package Routes</h3>
            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-1">Directly accessible endpoints</p>
        </div>
        <div class="relative w-full md:w-80">
            <input type="text" x-model="search" placeholder="Filter by URI or Name..." class="w-full bg-slate-50 border-0 rounded-2xl px-5 py-3.5 focus:ring-2 focus:ring-indigo-500 transition-all text-sm font-bold">
            <i class="fas fa-search absolute right-5 top-4 text-slate-300"></i>
        </div>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-100">
                    <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Method</th>
                    <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">URI / Route</th>
                    <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                <template x-for="route in {{ json_encode($routes) }}">
                    <tr x-show="route.uri.toLowerCase().includes(search.toLowerCase()) || (route.name && route.name.toLowerCase().includes(search.toLowerCase()))" 
                        class="hover:bg-slate-50/50 transition-colors group">
                        <td class="px-8 py-6">
                            <span class="px-3 py-1 bg-indigo-50 text-indigo-600 rounded-lg text-[10px] font-black uppercase tracking-tight" x-text="route.method"></span>
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex flex-col">
                                <span class="text-sm font-black text-slate-700" x-text="'/' + route.uri"></span>
                                <span class="text-[10px] font-bold text-slate-400 mt-1 uppercase" x-text="route.name || 'Unnamed Route'"></span>
                            </div>
                        </td>
                        <td class="px-8 py-6 text-right">
                            <button @click="navigator.clipboard.writeText('/' + route.uri); alert('Route Copied!')" class="w-10 h-10 rounded-xl bg-slate-50 text-slate-300 flex items-center justify-center hover:bg-indigo-600 hover:text-white transition-all">
                                <i class="fas fa-copy text-xs"></i>
                            </button>
                        </td>
                    </tr>
                </template>
            </tbody>
        </table>
    </div>
</div>
@endsection
