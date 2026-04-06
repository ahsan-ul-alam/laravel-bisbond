<div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center justify-between group">
    <div class="flex items-center">
        <div class="w-12 h-12 rounded-xl flex items-center justify-center text-lg {{ $enabled ? 'bg-green-50 text-green-600' : 'bg-slate-50 text-slate-400' }} mr-4 transition-colors">
            <i class="fas fa-{{ $name === 'formatter' ? 'language' : ($name === 'invoice' ? 'file-invoice' : ($name === 'sms' ? 'sms' : 'credit-card')) }}"></i>
        </div>
        <div>
            <h4 class="text-sm font-black text-slate-800 uppercase tracking-tight">{{ ucfirst($name) }} Module</h4>
            <p class="text-[10px] font-bold {{ $enabled ? 'text-green-500' : 'text-slate-400' }} tracking-widest">{{ $enabled ? 'ACTIVE' : 'DISABLED' }}</p>
        </div>
    </div>
    <div class="flex items-center">
        <span class="flex h-2 w-2 relative">
            <span class="animate-ping absolute inline-flex h-full w-full rounded-full {{ $enabled ? 'bg-green-400 opacity-75' : 'bg-slate-300' }}"></span>
            <span class="relative inline-flex rounded-full h-2 w-2 {{ $enabled ? 'bg-green-500' : 'bg-slate-400' }}"></span>
        </span>
    </div>
</div>
