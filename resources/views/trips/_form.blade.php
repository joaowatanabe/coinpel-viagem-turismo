{{--
    Partial form reutilizável para criação e edição de viagens.
    Variáveis esperadas do contexto:
      $trip      - instância de Trip (nova ou existente)
      $vehicles  - coleção de Vehicle para o select
      $drivers   - coleção de Driver para o select
      $action    - URL de destino do form
      $method    - HTTP method ('POST' ou 'PUT')
      $submitLabel - texto do botão de submit
--}}

{{-- Driver data for JS auto-fill (encoded before rendering) --}}
@php
    $driversJson = $drivers->map(fn($d) => [
        'id'           => $d->id,
        'name'         => $d->name,
        'registration' => $d->registration,
    ])->values()->toJson();

    $vehiclesJson = $vehicles->map(fn($v) => [
        'id'       => $v->id,
        'capacity' => $v->capacity,
    ])->values()->toJson();

    $originValue      = old('origin',       $trip->origin       ?? '');
    $destinationValue = old('destination',  $trip->destination  ?? '');
@endphp

{{-- Page header (outside the main form card) --}}
<div class="-mx-6 -mt-6 mb-0">

    {{-- Top bar: Voltar + Rota --}}
    <div class="flex items-center justify-between px-6 py-4 bg-white border-b border-gray-100">
        <a href="{{ route('trips.index') }}"
           class="inline-flex items-center gap-1.5 px-4 py-2 border border-gray-300 rounded-lg text-sm font-semibold text-gray-600 hover:bg-gray-50 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/>
            </svg>
            Voltar
        </a>

        <h1 id="route-heading" class="text-2xl font-semibold text-gray-800 tracking-tight">
            <span id="origin-display">{{ $originValue ?: 'Origem' }}</span>
            <span class="mx-3 text-gray-400">›</span>
            <span id="destination-display">{{ $destinationValue ?: 'Destino' }}</span>
        </h1>

        <div class="w-24"></div>{{-- spacer para centralizar o heading --}}
    </div>
</div>

{{-- Form body --}}
<form id="trip-form"
      method="POST"
      action="{{ $action }}"
      class="bg-white -mx-6 px-6 pb-0 min-h-[calc(100vh-8rem)] flex flex-col">
    @csrf
    @if($method === 'PUT')
        @method('PUT')
    @endif

    <div class="flex-1 py-8 space-y-8">

        {{-- Validation errors --}}
        @if ($errors->any())
            <div class="p-4 bg-red-50 border border-red-200 rounded-xl">
                <p class="text-sm font-semibold text-red-700 mb-1">Corrija os erros abaixo:</p>
                <ul class="list-disc list-inside space-y-0.5">
                    @foreach ($errors->all() as $error)
                        <li class="text-sm text-red-600">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Status badge dropdown --}}
        <div class="relative inline-block" id="status-wrapper">
            <div class="flex items-stretch">
                <span id="status-label-display"
                      class="flex items-center px-4 py-1.5 text-sm font-bold text-white rounded-l-lg select-none"
                      style="background-color: {{ match(old('status', $trip->status ?? 'scheduled')) {
                          'in_progress' => '#d97706',
                          'completed'   => '#16a34a',
                          'cancelled'   => '#dc2626',
                          default       => '#2563eb',
                      } }}">
                    {{ \App\Models\Trip::STATUSES[old('status', $trip->status ?? 'scheduled')] ?? 'Agendada' }}
                </span>
                <button type="button"
                        id="status-toggle"
                        class="flex items-center px-2.5 py-1.5 rounded-r-lg text-white transition cursor-pointer"
                        style="background-color: {{ match(old('status', $trip->status ?? 'scheduled')) {
                            'in_progress' => '#b45309',
                            'completed'   => '#15803d',
                            'cancelled'   => '#b91c1c',
                            default       => '#1d4ed8',
                        } }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5"/>
                    </svg>
                </button>
            </div>

            <div id="status-dropdown"
                 class="hidden absolute left-0 top-full mt-1 w-44 bg-white rounded-xl shadow-lg border border-gray-100 py-1.5 z-50">
                @foreach(\App\Models\Trip::STATUSES as $value => $label)
                    <button type="button"
                            data-value="{{ $value }}"
                            data-label="{{ $label }}"
                            data-bg="{{ match($value) { 'in_progress' => '#d97706', 'completed' => '#16a34a', 'cancelled' => '#dc2626', default => '#2563eb' } }}"
                            data-bg-dark="{{ match($value) { 'in_progress' => '#b45309', 'completed' => '#15803d', 'cancelled' => '#b91c1c', default => '#1d4ed8' } }}"
                            class="status-option flex items-center w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition cursor-pointer {{ old('status', $trip->status ?? 'scheduled') === $value ? 'font-semibold' : '' }}">
                        {{ $label }}
                    </button>
                @endforeach
            </div>

            <input type="hidden" id="status-input" name="status"
                   value="{{ old('status', $trip->status ?? 'scheduled') }}">
        </div>

        {{-- Seção: Informações da viagem --}}
        <section>
            <h2 class="text-base font-bold text-gray-800 mb-5">Informações da viagem:</h2>

            <div class="space-y-5">
                {{-- Nome (full width) --}}
                <div>
                    <label for="name" class="block text-sm text-gray-500 mb-1.5">Nome da viagem:</label>
                    <input type="text"
                           id="name"
                           name="name"
                           value="{{ old('name', $trip->name ?? '') }}"
                           placeholder="Ex.: ChocoFest 2026"
                           class="block w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-coinpel-primary focus:border-coinpel-primary transition @error('name') border-red-400 @enderror">
                    @error('name')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Grid 2 colunas --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5">

                    {{-- Regra --}}
                    <div>
                        <label for="rule" class="block text-sm text-gray-500 mb-1.5">Regra:</label>
                        <select id="rule"
                                name="rule"
                                class="block w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-coinpel-primary focus:border-coinpel-primary bg-white transition appearance-none @error('rule') border-red-400 @enderror">
                            <option value="">Selecione...</option>
                            @foreach(['Turismo', 'Faculdade', 'Escolar', 'Fretamento', 'Outros'] as $rule)
                                <option value="{{ $rule }}" {{ old('rule', $trip->rule ?? '') === $rule ? 'selected' : '' }}>
                                    {{ $rule }}
                                </option>
                            @endforeach
                        </select>
                        @error('rule')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Data --}}
                    <div>
                        <label for="date" class="block text-sm text-gray-500 mb-1.5">Data:</label>
                        <input type="date"
                               id="date"
                               name="date"
                               value="{{ old('date', isset($trip->date) ? $trip->date->format('Y-m-d') : '') }}"
                               class="block w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-coinpel-primary focus:border-coinpel-primary transition @error('date') border-red-400 @enderror">
                        @error('date')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Horário de Saída --}}
                    <div>
                        <label for="departure_time" class="block text-sm text-gray-500 mb-1.5">Horário de Saída:</label>
                        <input type="time"
                               id="departure_time"
                               name="departure_time"
                               value="{{ old('departure_time', isset($trip->departure_time) ? substr($trip->departure_time, 0, 5) : '') }}"
                               class="block w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-coinpel-primary focus:border-coinpel-primary transition @error('departure_time') border-red-400 @enderror">
                        @error('departure_time')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Origem --}}
                    <div>
                        <label for="origin" class="block text-sm text-gray-500 mb-1.5">Origem:</label>
                        <input type="text"
                               id="origin"
                               name="origin"
                               value="{{ $originValue }}"
                               placeholder="Ex.: Pelotas"
                               class="block w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-coinpel-primary focus:border-coinpel-primary transition @error('origin') border-red-400 @enderror">
                        @error('origin')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Destino --}}
                    <div>
                        <label for="destination" class="block text-sm text-gray-500 mb-1.5">Destino:</label>
                        <input type="text"
                               id="destination"
                               name="destination"
                               value="{{ $destinationValue }}"
                               placeholder="Ex.: Gramado"
                               class="block w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-coinpel-primary focus:border-coinpel-primary transition @error('destination') border-red-400 @enderror">
                        @error('destination')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Valor da passagem avulsa --}}
                    <div>
                        <label for="ticket_price" class="block text-sm text-gray-500 mb-1.5">Valor da passagem avulsa:</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-3.5 flex items-center text-sm text-gray-400 pointer-events-none">R$</span>
                            <input type="number"
                                   id="ticket_price"
                                   name="ticket_price"
                                   value="{{ old('ticket_price', $trip->ticket_price ?? '') }}"
                                   min="0"
                                   step="0.01"
                                   placeholder="0,00"
                                   class="block w-full pl-9 pr-4 py-2.5 border border-gray-200 rounded-lg text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-coinpel-primary focus:border-coinpel-primary transition @error('ticket_price') border-red-400 @enderror">
                        </div>
                        @error('ticket_price')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                </div>
            </div>
        </section>

        {{-- Divisor --}}
        <div class="border-t border-gray-100"></div>

        {{-- Seção: Dados do veículo --}}
        <section>
            <h2 class="text-base font-bold text-gray-800 mb-5">Dados do veículo:</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5">

                {{-- Veículo --}}
                <div>
                    <label for="vehicle_id" class="block text-sm text-gray-500 mb-1.5">Veículo:</label>
                    <select id="vehicle_id"
                            name="vehicle_id"
                            class="block w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-coinpel-primary focus:border-coinpel-primary bg-white transition appearance-none @error('vehicle_id') border-red-400 @enderror">
                        <option value="">Selecione o veículo...</option>
                        @foreach($vehicles as $vehicle)
                            <option value="{{ $vehicle->id }}"
                                    data-capacity="{{ $vehicle->capacity }}"
                                    {{ old('vehicle_id', $trip->vehicle_id ?? '') == $vehicle->id ? 'selected' : '' }}>
                                {{ $vehicle->prefix }} - {{ $vehicle->model }}
                            </option>
                        @endforeach
                    </select>
                    @error('vehicle_id')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Número de passageiros --}}
                <div>
                    <label for="passenger_count" class="block text-sm text-gray-500 mb-1.5">Número de passageiros:</label>
                    <input type="number"
                           id="passenger_count"
                           name="passenger_count"
                           value="{{ old('passenger_count', $trip->passenger_count ?? '') }}"
                           min="1"
                           placeholder="Sugerido ao escolher o veículo"
                           class="block w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-coinpel-primary focus:border-coinpel-primary transition @error('passenger_count') border-red-400 @enderror">
                    @error('passenger_count')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

            </div>
        </section>

        {{-- Divisor --}}
        <div class="border-t border-gray-100"></div>

        {{-- Seção: Motorista --}}
        <section>
            <h2 class="text-base font-bold text-gray-800 mb-5">Motorista:</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5">

                {{-- Nome do motorista --}}
                <div>
                    <label for="driver_id" class="block text-sm text-gray-500 mb-1.5">Nome:</label>
                    <select id="driver_id"
                            name="driver_id"
                            class="block w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-coinpel-primary focus:border-coinpel-primary bg-white transition appearance-none @error('driver_id') border-red-400 @enderror">
                        <option value="">Selecione o motorista...</option>
                        @foreach($drivers as $driver)
                            <option value="{{ $driver->id }}"
                                    data-registration="{{ $driver->registration }}"
                                    {{ old('driver_id', $trip->driver_id ?? '') == $driver->id ? 'selected' : '' }}>
                                {{ $driver->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('driver_id')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Matrícula (readonly, auto-preenchida via JS) --}}
                <div>
                    <label for="driver_registration" class="block text-sm text-gray-500 mb-1.5">Matrícula</label>
                    <input type="text"
                           id="driver_registration"
                           readonly
                           tabindex="-1"
                           placeholder="Preenchida automaticamente"
                           class="block w-full px-4 py-2.5 border border-gray-100 rounded-lg text-sm text-gray-500 bg-gray-50 cursor-not-allowed">
                </div>

            </div>
        </section>

    </div>

    {{-- Footer com botões fixo no bottom --}}
    <div class="-mx-6 px-6 py-4 bg-white border-t border-gray-100 flex items-center gap-4">
        <button type="submit"
                class="flex-1 max-w-xs py-2.5 bg-coinpel-primary hover:bg-coinpel-primary-dark text-white text-sm font-semibold rounded-lg transition shadow-sm shadow-coinpel-primary/20 cursor-pointer">
            {{ $submitLabel }}
        </button>
        <a href="{{ route('trips.index') }}"
           class="flex-1 max-w-xs py-2.5 text-center border border-gray-300 text-gray-600 text-sm font-semibold rounded-lg hover:bg-gray-50 transition">
            Cancelar
        </a>
    </div>

</form>

@push('scripts')
<script>
(function () {
    const driverSelect      = document.getElementById('driver_id');
    const registrationInput = document.getElementById('driver_registration');
    const vehicleSelect     = document.getElementById('vehicle_id');
    const passengerInput    = document.getElementById('passenger_count');
    const originInput       = document.getElementById('origin');
    const destinationInput  = document.getElementById('destination');
    const originDisplay     = document.getElementById('origin-display');
    const destinationDisplay = document.getElementById('destination-display');

    function syncRouteHeading() {
        originDisplay.textContent      = originInput.value.trim()      || 'Origem';
        destinationDisplay.textContent = destinationInput.value.trim() || 'Destino';
    }

    function syncDriverRegistration() {
        const selected = driverSelect.options[driverSelect.selectedIndex];
        registrationInput.value = selected?.dataset.registration ?? '';
    }

    function syncPassengerCount() {
        if (passengerInput.value !== '') return;
        const selected = vehicleSelect.options[vehicleSelect.selectedIndex];
        if (selected?.dataset.capacity) {
            passengerInput.value = selected.dataset.capacity;
        }
    }

    originInput?.addEventListener('input', syncRouteHeading);
    destinationInput?.addEventListener('input', syncRouteHeading);
    driverSelect?.addEventListener('change', syncDriverRegistration);
    vehicleSelect?.addEventListener('change', syncPassengerCount);

    syncDriverRegistration();
    syncRouteHeading();

    const statusToggle   = document.getElementById('status-toggle');
    const statusDropdown = document.getElementById('status-dropdown');
    const statusInput    = document.getElementById('status-input');
    const statusLabel    = document.getElementById('status-label-display');

    statusToggle?.addEventListener('click', function (e) {
        e.stopPropagation();
        statusDropdown.classList.toggle('hidden');
    });

    document.querySelectorAll('.status-option').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const val   = btn.dataset.value;
            const label = btn.dataset.label;
            const bg    = btn.dataset.bg;
            const bgDark = btn.dataset.bgDark;

            statusInput.value          = val;
            statusLabel.textContent    = label;
            statusLabel.style.backgroundColor  = bg;
            statusToggle.style.backgroundColor = bgDark;

            statusDropdown.classList.add('hidden');
        });
    });

    document.addEventListener('click', function () {
        statusDropdown?.classList.add('hidden');
    });
})();
</script>
@endpush
