{{-- resources/views/filament/pages/report.blade.php --}}

<x-filament::page>
    <form wire:submit.prevent="submit">
        {{ $this->filtersForm }}
    </form>

    <div>
        @livewire(\App\Filament\Widgets\MemberOverview::class, ['filters' => $this->filters])
        @livewire(\App\Filament\Widgets\SalesOverview::class, ['filters' => $this->filters])
    </div>

    <div>
        {{-- {{ print_r($tabList) }}
            {{ print_r($activeTab) }} --}}
        <div class="flex space-x-4">
            @foreach ($tabList as $tab)
                <button wire:click="activateButton('{{ $tab }}')"
                    class="{{ $activeTab === $tab ? 'bg-red-500' : 'bg-blue-500' }} hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">{{ ucfirst($tab) }}</button>
            @endforeach
        </div>

        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gym
                        Membership</th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No of
                        Clients</th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Discounts
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount
                    </th>
                </tr>
            </thead>

            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($this->getMembershipPlan() as $plan)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $plan['membership_name'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $plan['price'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $plan['client_count'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $plan['discount'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $plan['amount'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-filament::page>
