@extends('bisbond::layouts.app')

@section('title', 'Invoice Preview')

@section('content')
<div class="max-w-4xl mx-auto py-8">
    <div class="bg-white rounded-xl shadow-2xl overflow-hidden border border-gray-100">
        <!-- Header -->
        <div class="p-8 border-b-2 border-indigo-600 flex justify-between items-start bg-indigo-50/30">
            <div>
                <h1 class="text-3xl font-black text-indigo-900 uppercase tracking-tighter">{{ $invoice['business_name'] }}</h1>
                <p class="text-sm text-gray-500 mt-1 font-medium italic">Professional Business Solutions</p>
            </div>
            <div class="text-right">
                <div class="bg-indigo-600 text-white px-4 py-2 rounded-lg font-bold text-sm inline-block mb-2">INVOICE</div>
                <p class="text-sm font-bold text-gray-800">#{{ $invoice['prefix'] }}{{ $invoice['number'] }}</p>
                <p class="text-xs text-gray-500">Date: {{ $invoice['date'] }}</p>
            </div>
        </div>

        <!-- Body -->
        <div class="p-8">
            <div class="grid grid-cols-2 gap-12 mb-12">
                <div>
                    <h4 class="text-xs font-bold text-indigo-600 uppercase mb-3 tracking-widest">Bill To:</h4>
                    <p class="text-lg font-bold text-gray-900">Premium Client</p>
                    <p class="text-sm text-gray-500 mt-1 leading-relaxed">
                        123 Business Street<br>
                        Dhaka, Bangladesh<br>
                        Phone: +880 1234 567890
                    </p>
                </div>
            </div>

            <table class="w-full mb-12">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Description</th>
                        <th class="px-6 py-4 text-center text-xs font-bold text-gray-600 uppercase tracking-wider">Quantity</th>
                        <th class="px-6 py-4 text-right text-xs font-bold text-gray-600 uppercase tracking-wider">Amount (BN)</th>
                        <th class="px-6 py-4 text-right text-xs font-bold text-gray-600 uppercase tracking-wider">Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <tr>
                        <td class="px-6 py-4">
                            <p class="text-sm font-bold text-gray-900">Software Subscription</p>
                            <p class="text-xs text-gray-500 italic mt-1">Monthly recurring service charge</p>
                        </td>
                        <td class="px-6 py-4 text-center text-sm font-medium text-gray-600">01</td>
                        <td class="px-6 py-4 text-right text-sm font-bold text-indigo-600">{{ $invoice['amount_bn'] }} ৳</td>
                        <td class="px-6 py-4 text-right text-sm font-black text-gray-900">{{ $invoice['currency'] }} {{ number_format($invoice['amount'], 2) }}</td>
                    </tr>
                </tbody>
            </table>

            <!-- Summary -->
            <div class="flex justify-end">
                <div class="w-64 space-y-3">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Subtotal:</span>
                        <span class="font-bold text-gray-900">{{ $invoice['currency'] }} {{ number_format($invoice['amount'], 2) }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Tax (0%):</span>
                        <span class="font-bold text-gray-900">0.00</span>
                    </div>
                    <div class="pt-3 border-t-2 border-indigo-100 flex justify-between items-center">
                        <span class="text-indigo-900 font-black uppercase tracking-tighter">Grand Total:</span>
                        <span class="text-xl font-black text-indigo-600">{{ $invoice['currency'] }} {{ number_format($invoice['amount'], 2) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="p-8 bg-gray-50 border-t border-gray-100 flex justify-between items-center">
            <div class="text-xs text-gray-500 max-w-sm italic">
                <strong>Note:</strong> {{ $invoice['footer'] }}
            </div>
            <div class="flex space-x-2">
                <button class="bg-indigo-600 text-white p-3 rounded-lg hover:bg-indigo-700 shadow-md">
                    <i class="fas fa-print"></i>
                </button>
                <button class="bg-indigo-100 text-indigo-600 p-3 rounded-lg hover:bg-indigo-200">
                    <i class="fas fa-download"></i>
                </button>
            </div>
        </div>
    </div>
    
    <div class="mt-8 text-center text-xs text-gray-400 font-medium">
        Generated by <span class="text-indigo-500 font-bold">Bisbond Premium Toolkit</span> &bull; Production Ready
    </div>
</div>
@endsection
