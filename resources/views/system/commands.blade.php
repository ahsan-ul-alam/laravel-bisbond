@extends('bisbond::layouts.app')

@section('title', 'Command Explorer')

@section('content')
<div x-data="{ search: '' }" class="space-y-6">
    <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h3 class="text-xl font-black text-slate-800 uppercase tracking-tight">Artisan Console</h3>
            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-1">Package CLI utility tools</p>
        </div>
        <div class="relative w-full md:w-80">
            <input type="text" x-model="search" placeholder="Search commands..." class="w-full bg-slate-50 border-0 rounded-2xl px-5 py-3.5 focus:ring-2 focus:ring-indigo-500 transition-all text-sm font-bold">
            <i class="fas fa-terminal absolute right-5 top-4 text-slate-300"></i>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <template x-for="cmd in {{ json_encode($commands) }}">
            <div x-show="cmd.name.toLowerCase().includes(search.toLowerCase())" 
                 class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100 hover:shadow-xl hover:shadow-slate-200/50 transition-all group relative overflow-hidden">
                <div class="absolute -right-4 -top-4 w-20 h-20 bg-slate-50 rounded-full group-hover:bg-indigo-50 transition-colors"></div>
                
                <div class="relative">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-[10px] font-black text-indigo-500 uppercase tracking-widest">Toolkit Utility</span>
                        <button @click="navigator.clipboard.writeText(cmd.usage); alert('Copied!')" class="text-slate-200 hover:text-indigo-600 transition-colors">
                            <i class="fas fa-copy text-sm"></i>
                        </button>
                    </div>
                    <h4 class="text-lg font-black text-slate-800 font-mono mb-2" x-text="cmd.name"></h4>
                    <p class="text-xs text-slate-500 font-bold leading-relaxed mb-6" x-text="cmd.description"></p>
                    
                    <div class="bg-slate-900 rounded-xl p-4 font-mono text-[11px] text-indigo-400 flex items-center overflow-x-hidden">
                        <span class="mr-2 text-slate-600">$</span>
                        <span x-text="cmd.usage"></span>
                    </div>
                </div>
            </div>
        </template>
    </div>
</div>
@endsection
