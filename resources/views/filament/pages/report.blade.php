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
        <div class="flex space-x-4">
            @foreach ($tabList as $tab)
                <button wire:click="activateButton('{{ $tab }}')"
                    class="{{ $activeTab === $tab ? 'bg-red-500' : 'bg-blue-500' }} hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">{{ ucfirst($tab) }}</button>
            @endforeach
        </div>

        <table class="min-w-full">
            @if ($activeTab === 'Gym Membership' || $activeTab === 'Gym Access')
                <thead class="bg-gray-50">
                    <tr>
                        @foreach ($tableHeaderMembership as $header)
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ $header }}
                            </th>
                        @endforeach
                    </tr>
                </thead>

                <tbody class="bg-white divide-y divide-gray-200">
                    @if ($activeTab === 'Gym Membership')
                        @foreach ($this->getMembershipPlan() as $plan)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $plan['type'] }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">PHP {{ $plan['price'] }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $plan['client_count'] }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">PHP {{ $plan['discount'] }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">PHP {{ $plan['amount'] }}</td>
                            </tr>
                        @endforeach
                    @else
                        @foreach ($this->getAccessPlan() as $plan)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $plan['type'] }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">PHP {{ $plan['price'] }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $plan['client_count'] }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">PHP {{ $plan['discount'] }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">PHP {{ $plan['amount'] }}</td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            @elseif ($activeTab === 'Coaching')
                <thead class="bg-gray-50">
                    <tr>
                        @foreach ($tableHeaderCoaching as $header)
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ $header }}
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($this->getCoachingPlan() as $plan)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $plan['type'] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $plan['1-session'] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $plan['12-session'] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $plan['26-session'] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $plan['30-session'] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $plan['60-session'] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $plan['90-session'] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">PHP {{ $plan['amount'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            @else
                <thead class="bg-gray-50">
                    <tr>
                        @foreach ($tableHeaderSummary as $header)
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ $header }}
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($this->getSummary() as $plan)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $plan['category'] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $plan['total_amount'] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $plan['cash'] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $plan['bank'] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $plan['credit'] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $plan['debit'] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $plan['gcash'] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $plan['paymaya'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            @endif
        </table>
    </div>
</x-filament::page>
