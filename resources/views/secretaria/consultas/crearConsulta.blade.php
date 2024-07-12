<x-app-layout>
    <div class="flex items-center justify-center p-12">
        <!-- Formulario para crear consulta -->
        <div class="mx-auto w-full max-w-[550px]">
            <form action="{{ route('consultas.store', ['citaId' => $cita->id]) }}" method="POST">
                @csrf
                <div class="mb-5">
                    <label for="diagnostico" class="mb-3 block text-base font-medium text-[#07074D]">
                        Diagnóstico
                    </label>
                    <textarea id="diagnostico" name="diagnostico" placeholder="Ingrese su diagnóstico aquí" required class="w-full resize-none rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md">{{ old('diagnostico') }}</textarea>
                </div>
                <div class="mb-5">
                    <label for="receta" class="mb-3 block text-base font-medium text-[#07074D]">
                        Receta
                    </label>
                    <textarea id="receta" name="receta" placeholder="Detalle la receta aquí" class="w-full resize-none rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md">{{ old('receta') }}</textarea>
                </div>
                <div class="mb-5">
                    <label class="mb-3 block text-base font-medium text-[#07074D]">Productos</label>
                    @foreach($productos as $producto)
                    <div class="form-check mb-2">
                        <input type="checkbox" class="form-check-input product-checkbox" id="producto_{{ $producto->id }}" name="productos[]" value="{{ $producto->id }}" data-price="{{ $producto->precio }}">
                        <label class="form-check-label" for="producto_{{ $producto->id }}">{{ $producto->nombre }} - ${{ $producto->precio }}</label>
                    </div>
                    @endforeach
                </div>

                <div class="mb-5">
                    <label class="mb-3 block text-base font-medium text-[#07074D]">Servicios</label>
                    @foreach($servicios as $servicio)
                    <div class="form-check mb-2">
                        <input type="checkbox" class="form-check-input service-checkbox" id="servicio_{{ $servicio->id }}" name="servicios[]" value="{{ $servicio->id }}" data-price="{{ $servicio->precio }}">
                        <label class="form-check-label" for="servicio_{{ $servicio->id }}">{{ $servicio->nombre }} - ${{ $servicio->precio }}</label>
                    </div>
                    @endforeach
                </div>

                <div class="mb-5">
                    <label for="estado" class="mb-3 block text-base font-medium text-[#07074D]">
                        Estado
                    </label>
                    <select id="estado" name="estado" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md">
                        <option value="En proceso" selected>En proceso</option>
                        <option value="Finalizado">Finalizado</option>
                    </select>
                </div>

                <!-- Total a Pagar -->
                <div class="mb-5">
                    <label for="total_pagar" class="mb-3 block text-base font-medium text-[#07074D]">
                        Total a Pagar
                    </label>
                    <input type="number" step="0.01" id="total_pagar" name="total_pagar" value="100" readonly class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                </div>

                <button class="hover:shadow-form rounded-md bg-[#6A64F1] py-3 px-8 text-base font-semibold text-white outline-none">Crear Consulta</button>
            </form>
        </div>
    </div>

    <script>
        document.querySelectorAll('.product-checkbox, .service-checkbox').forEach(item => {
            item.addEventListener('change', function() {
                let total = parseFloat(document.getElementById('total_pagar').value);
                let price = parseFloat(item.dataset.price);

                if (item.checked) {
                    total += price;
                } else {
                    total -= price;
                }

                document.getElementById('total_pagar').value = total.toFixed(2);
            });
        });
    </script>
</x-app-layout>