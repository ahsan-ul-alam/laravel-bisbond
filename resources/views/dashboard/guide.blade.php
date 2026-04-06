@extends('bisbond::layouts.app')

@section('title', 'Developer Guide')

@section('content')
<div class="max-w-4xl mx-auto space-y-12 pb-20">
    <div class="text-center">
        <h2 class="text-3xl font-black text-slate-900 tracking-tighter uppercase mb-2">Integration Help</h2>
        <p class="text-slate-500 font-bold uppercase tracking-tighter text-xs">How to use the regional toolkit in your app</p>
    </div>

    <!-- Core Helpers -->
    <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-8 border-b border-slate-100 bg-slate-50/30 flex items-center">
            <div class="w-10 h-10 rounded-xl bg-indigo-600 flex items-center justify-center text-white mr-4 shadow-lg shadow-indigo-100">
                <i class="fas fa-code text-sm"></i>
            </div>
            <h3 class="text-lg font-black text-slate-800 uppercase tracking-tight">Toolkit Helpers</h3>
        </div>
        <div class="p-8 space-y-8">
            <div class="space-y-4">
                <p class="text-sm font-bold text-slate-700 uppercase tracking-tight">1. Access Dynamic Settings</p>
                <div class="bg-slate-900 rounded-2xl p-6 text-xs font-mono text-indigo-400 leading-relaxed">
                    <span class="text-slate-500">// Returns value from DB or config fallback</span><br>
                    $bizName = <span class="text-white">bisbond_setting</span>('general.business_name', 'Default Corp');
                </div>
            </div>

            <div class="space-y-4">
                <p class="text-sm font-bold text-slate-700 uppercase tracking-tight">2. Check Module State</p>
                <div class="bg-slate-900 rounded-2xl p-6 text-xs font-mono text-indigo-400 leading-relaxed">
                    <span class="text-white">if</span> (<span class="text-white">bisbond_module</span>('sms')) {<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;<span class="text-slate-500">// Trigger SMS provider logic</span><br>
                    }
                </div>
            </div>
        </div>
    </div>

    <!-- Bangla Formatter -->
    <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-8 border-b border-slate-100 bg-slate-50/30 flex items-center">
            <div class="w-10 h-10 rounded-xl bg-blue-600 flex items-center justify-center text-white mr-4 shadow-lg shadow-blue-100">
                <i class="fas fa-language text-sm"></i>
            </div>
            <h3 class="text-lg font-black text-slate-800 uppercase tracking-tight">Regional Formatting</h3>
        </div>
        <div class="p-8 space-y-4">
            <p class="text-sm font-bold text-slate-700 uppercase tracking-tight">Direct conversion to Bangla:</p>
            <div class="bg-slate-900 rounded-2xl p-6 text-xs font-mono text-indigo-400 space-y-2 leading-relaxed">
                <span class="text-white">use</span> AhsanUlAlam\LaravelBisbond\Support\BanglaFormatter;<br><br>
                <span class="text-slate-500">// Output: ১২৩৪.৫০</span><br>
                $num = <span class="text-white">BanglaFormatter::toBangla</span>(1234.50);<br><br>
                <span class="text-slate-500">// Output: ২৫/০৫/২০২৬</span><br>
                $date = <span class="text-white">BanglaFormatter::toBangla</span>('25/05/2026');
            </div>
        </div>
    </div>

    <!-- CLI Section -->
    <div class="bg-indigo-900 rounded-[2.5rem] shadow-xl p-10 text-white relative overflow-hidden">
        <div class="relative z-10">
            <h3 class="text-xl font-black uppercase tracking-tight mb-4">CLI Maintenance</h3>
            <p class="text-indigo-200 text-sm font-bold leading-relaxed mb-8 max-w-lg">Keep your regional settings synced and clean using these Artisan commands.</p>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-black/20 p-4 rounded-2xl border border-white/10">
                    <p class="text-[10px] font-black text-indigo-400 uppercase mb-2">Install / Reset</p>
                    <code class="text-xs text-white">php artisan bisbond:install</code>
                </div>
                <div class="bg-black/20 p-4 rounded-2xl border border-white/10">
                    <p class="text-[10px] font-black text-indigo-400 uppercase mb-2">Publish Views</p>
                    <code class="text-xs text-white">php artisan vendor:publish --tag=bisbond-views</code>
                </div>
            </div>
        </div>
        <i class="fas fa-terminal absolute -right-6 -bottom-6 text-9xl text-indigo-800 opacity-20"></i>
    </div>
</div>
@endsection
