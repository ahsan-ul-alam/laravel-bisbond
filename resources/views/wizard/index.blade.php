@extends('bisbond::layouts.app')

@section('title', 'Installation Wizard')

@section('content')
<div x-data="wizard()" class="max-w-4xl mx-auto py-8">
    <!-- Progress Stepper -->
    <div class="mb-8 flex justify-between">
        <template x-for="s in steps">
            <div class="flex flex-col items-center">
                <div :class="{'bg-indigo-600 text-white': step >= s.id, 'bg-gray-200 text-gray-500': step < s.id}" 
                     class="w-10 h-10 rounded-full flex items-center justify-center font-bold mb-2 transition-colors duration-300">
                    <span x-text="s.id"></span>
                </div>
                <span class="text-xs font-semibold text-gray-500 uppercase" x-text="s.name"></span>
            </div>
        </template>
    </div>

    <div class="bg-white rounded-xl shadow-lg p-8">
        <!-- Step 1: General Info -->
        <div x-show="step === 1" x-transition>
            <h2 class="text-2xl font-bold mb-6">General Information</h2>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Business Name</label>
                    <input type="text" x-model="formData.business_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-2 px-3 border">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Phone Number</label>
                    <input type="text" x-model="formData.phone" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-2 px-3 border">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Currency</label>
                    <select x-model="formData.currency" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-2 px-3 border">
                        <option value="BDT">BDT (৳)</option>
                        <option value="USD">USD ($)</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Step 2: Invoice Setup -->
        <div x-show="step === 2" x-transition>
            <h2 class="text-2xl font-bold mb-6">Invoice Setup</h2>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Invoice Prefix</label>
                    <input type="text" x-model="formData.invoice_prefix" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-2 px-3 border" placeholder="INV-">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Invoice Footer</label>
                    <textarea x-model="formData.invoice_footer" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-2 px-3 border"></textarea>
                </div>
            </div>
        </div>

        <!-- Step 3: SMS Setup -->
        <div x-show="step === 3" x-transition>
            <h2 class="text-2xl font-bold mb-6">SMS Gateway</h2>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">SMS Provider</label>
                    <select x-model="formData.sms_provider" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-2 px-3 border">
                        <option value="infobip">Infobip</option>
                        <option value="twilio">Twilio</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">API Key</label>
                    <input type="password" x-model="formData.sms_api_key" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-2 px-3 border">
                </div>
            </div>
        </div>

        <!-- Step 4: Finish -->
        <div x-show="step === 4" x-transition>
            <div class="text-center py-12">
                <div class="mb-4 text-6xl text-green-500">
                    <i class="fas fa-check-circle"></i>
                </div>
                <h2 class="text-3xl font-bold mb-2">All Set!</h2>
                <p class="text-gray-600 mb-8">Your system is now configured and ready to use.</p>
                <button @click="finish()" class="bg-indigo-600 text-white px-8 py-3 rounded-lg font-bold hover:bg-indigo-700 transition">
                    Go to Dashboard
                </button>
            </div>
        </div>

        <!-- Navigation Buttons -->
        <div class="mt-10 flex justify-between" x-show="step < 4">
            <button @click="step--" :disabled="step === 1" class="px-6 py-2 border rounded-lg font-medium hover:bg-gray-50 disabled:opacity-50">
                Back
            </button>
            <button @click="nextStep()" class="px-6 py-2 bg-indigo-600 text-white rounded-lg font-medium hover:bg-indigo-700">
                <span x-text="step === 3 ? 'Finish' : 'Next Step'"></span>
            </button>
        </div>
    </div>
</div>

<script>
function wizard() {
    return {
        step: 1,
        steps: [
            { id: 1, name: 'General' },
            { id: 2, name: 'Invoice' },
            { id: 3, name: 'SMS' },
            { id: 4, name: 'Finish' }
        ],
        formData: {
            business_name: '',
            phone: '',
            currency: 'BDT',
            invoice_prefix: 'INV-',
            invoice_footer: 'Thank you!',
            invoice_logo: '',
            sms_provider: 'infobip',
            sms_api_key: '',
            sms_sender_id: ''
        },
        nextStep() {
            // Save current step data
            fetch('{{ route("bisbond.wizard.store") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    step: this.step,
                    ...this.formData
                })
            }).then(() => {
                this.step++;
            });
        },
        finish() {
            fetch('{{ route("bisbond.wizard.store") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    step: 'finish'
                })
            }).then(() => {
                window.location.href = '{{ route("bisbond.dashboard") }}';
            });
        }
    }
}
</script>
@endsection
