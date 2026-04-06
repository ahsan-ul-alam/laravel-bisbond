@extends('bisbond::layouts.app')

@section('title', 'System Settings')

@section('content')
<div class="max-w-6xl mx-auto">
    <form action="{{ route('bisbond.settings.update') }}" method="POST">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left: Module Toggles -->
            <div class="space-y-6">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-6 border-b border-gray-100">
                        <h3 class="text-lg font-bold text-gray-800">Modules</h3>
                        <p class="text-sm text-gray-500">Enable or disable system features.</p>
                    </div>
                    <div class="p-6 space-y-6">
                        @foreach($modules as $name => $enabled)
                            <div class="flex items-center justify-between">
                                <div class="flex flex-col">
                                    <span class="text-sm font-bold text-gray-800 capitalize">{{ $name }}</span>
                                    <span class="text-xs text-gray-500">Status: {{ $enabled ? 'Enabled' : 'Disabled' }}</span>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="hidden" name="modules[{{ $name }}]" value="0">
                                    <input type="checkbox" name="modules[{{ $name }}]" value="1" class="sr-only peer" {{ $enabled ? 'checked' : '' }}>
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="bg-indigo-50 p-6 rounded-xl border border-indigo-100">
                    <h4 class="text-indigo-800 font-bold mb-2">Pro Tip</h4>
                    <p class="text-indigo-700 text-xs">Disabling modules will hide them from the dashboard and disable their respective routes.</p>
                </div>
            </div>

            <!-- Right: General Settings -->
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-6 border-b border-gray-100">
                        <h3 class="text-lg font-bold text-gray-800">General Configuration</h3>
                    </div>
                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Business Name</label>
                            <input type="text" name="settings[general.business_name]" value="{{ $settings['general.business_name'] ?? '' }}" class="w-full rounded-lg border-gray-300 border py-2 px-3 focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Support Phone</label>
                            <input type="text" name="settings[general.phone]" value="{{ $settings['general.phone'] ?? '' }}" class="w-full rounded-lg border-gray-300 border py-2 px-3 focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Default Currency</label>
                            <select name="settings[general.currency]" class="w-full rounded-lg border-gray-300 border py-2 px-3 focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="BDT" {{ ($settings['general.currency'] ?? '') === 'BDT' ? 'selected' : '' }}>BDT (৳)</option>
                                <option value="USD" {{ ($settings['general.currency'] ?? '') === 'USD' ? 'selected' : '' }}>USD ($)</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-6 border-b border-gray-100">
                        <h3 class="text-lg font-bold text-gray-800">Invoice & Billing</h3>
                    </div>
                    <div class="p-6 space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Invoice Prefix</label>
                                <input type="text" name="settings[invoice.prefix]" value="{{ $settings['invoice.prefix'] ?? '' }}" class="w-full rounded-lg border-gray-300 border py-2 px-3 focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Invoice Footer Text</label>
                            <textarea name="settings[invoice.footer]" rows="3" class="w-full rounded-lg border-gray-300 border py-2 px-3 focus:ring-indigo-500 focus:border-indigo-500">{{ $settings['invoice.footer'] ?? '' }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="bg-indigo-600 text-white px-8 py-3 rounded-lg font-bold hover:bg-indigo-700 transition shadow-lg shadow-indigo-200">
                        Save Changes
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
