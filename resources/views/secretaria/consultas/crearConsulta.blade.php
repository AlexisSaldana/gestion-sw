<x-app-layout>
    <div class="flex items-center justify-center p-12">
        <!-- Formulario para crear consulta -->
        <div class="mx-auto w-full max-w-[550px]">
            <form action="{{ route('consultas.store', ['citaId' => $cita->id]) }}" method="POST">
                @csrf

                <!-- Motivo de la Consulta -->
                <div class="mb-8">
                    
                    <label for="motivo" class="mb-3 block text-base font-medium text-[#07074D]">
                        Motivo de la Consulta
                    </label>
                    <textarea id="motivo" name="motivo" placeholder="Ingrese el motivo de la consulta" class="w-full resize-none rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md"></textarea>
                    
                    <label class="mb-3 block text-base font-medium text-[#07074D]">
                        Datos del Paciente
                    </label>

                    <div class="mb-8 grid grid-cols-3 gap-4">
                    <div>
                            <label for="talla" class="block text-base font-medium text-[#07074D]">Talla</label>
                            <input type="text" id="talla" name="talla" placeholder="0 m" class="w-full rounded-md border border-[#e0e0e0] bg-white py-2 px-4 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                        </div>
                        <div>
                            <label for="temperatura" class="block text-base font-medium text-[#07074D]">Temperatura</label>
                            <input type="text" id="temperatura" name="temperatura" placeholder="0 °C" class="w-full rounded-md border border-[#e0e0e0] bg-white py-2 px-4 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                        </div>
                        <div>
                            <label for="saturacion_oxigeno" class="block text-base font-medium text-[#07074D]">Saturación de oxígeno</label>
                            <input type="text" id="saturacion_oxigeno" name="saturacion_oxigeno" placeholder="0 %" class="w-full rounded-md border border-[#e0e0e0] bg-white py-2 px-4 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                        </div>
                        <div>
                            <label for="frecuencia_cardiaca" class="block text-base font-medium text-[#07074D]">Frecuencia cardíaca</label>
                            <input type="text" id="frecuencia_cardiaca" name="frecuencia_cardiaca" placeholder="0 bpm" class="w-full rounded-md border border-[#e0e0e0] bg-white py-2 px-4 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                        </div>
                        <div>
                            <label for="peso" class="block text-base font-medium text-[#07074D]">Peso</label>
                            <input type="text" id="peso" name="peso" placeholder="0 kg" class="w-full rounded-md border border-[#e0e0e0] bg-white py-2 px-4 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                        </div>
                        <div>
                            <label for="tension_arterial" class="block text-base font-medium text-[#07074D]">Tensión arterial</label>
                            <input type="text" id="tension_arterial" name="tension_arterial" placeholder="0/0 (mm/Hg)" class="w-full rounded-md border border-[#e0e0e0] bg-white py-2 px-4 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                        </div>
                    </div>

                    <div class="mb-8">
                        <label for="padecimiento" class="mb-3 block text-base font-medium text-[#07074D]">
                            Nota de Padecimiento
                        </label>
                        <textarea id="padecimiento" name="padecimiento" placeholder="Ingrese el padecimiento del paciente" class="w-full resize-none rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md"></textarea>
                    </div>
                </div>

                <div class="mb-8">
                    <label for="enfermera_id" class="mb-3 block text-base font-medium text-[#07074D]">
                        Enfermera que atendió
                    </label>
                    <select id="enfermera_id" name="enfermera_id" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md">
                        <option value="">Seleccione una enfermera</option>
                        @foreach($enfermeras as $enfermera)
                            <option value="{{ $enfermera->id }}" {{ isset($enfermera_id) && $enfermera_id == $enfermera->id ? 'selected' : '' }}>
                                {{ $enfermera->nombres . ' ' . $enfermera->apepat . ' (' . $enfermera->email . ')'}}
                            </option>                        
                        @endforeach 
                    </select>

                </div>

                <div class="mb-8">
                    <label class="mb-3 block text-base font-medium text-[#07074D]">Productos</label>
                    <div id="productos-container">
                        <!-- Aquí se añadirán los productos dinámicamente -->
                    </div>
                    <button type="button" id="add-product" class="mb-3 mt-2 text-base font-medium text-blue-500">+ Añadir Producto</button>
                </div>

                <div class="mb-8">
                    <label class="mb-3 block text-base font-medium text-[#07074D]">Servicios</label>
                    <div id="servicios-container">
                        <!-- Aquí se añadirán los servicios dinámicamente -->
                    </div>
                    <button type="button" id="add-service" class="mb-3 mt-2 text-base font-medium text-blue-500">+ Añadir Servicio</button>
                </div>

                <div class="mb-8">
                    <label for="estado" class="mb-3 block text-base font-medium text-[#07074D]">
                        Estado
                    </label>
                    <select id="estado" name="estado" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md">
                        <option value="En proceso" selected>En proceso</option>
                        <option value="Finalizado">Finalizado</option>
                    </select>
                </div>

                <!-- Total a Pagar -->
                <div class="mb-8">
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
        document.getElementById('add-product').addEventListener('click', function() {
            let container = document.getElementById('productos-container');
            let index = container.children.length;

            let productSelect = `
                <div class="form-group mb-2" id="product-${index}">
                    <select name="productos[]" class="w-full rounded-md border border-[#e0e0e0] bg-white py-2 px-4 mb-2">
                        @foreach($productos as $producto)
                            <option value="{{ $producto->id }}" data-price="{{ $producto->precio }}">{{ $producto->nombre }} - ${{ $producto->precio }}</option>
                        @endforeach
                    </select>
                    <input type="number" name="cantidades_productos[]" min="1" value="1" class="w-full rounded-md border border-[#e0e0e0] bg-white py-2 px-4 mb-2" placeholder="Cantidad">
                    <button type="button" class="remove-product text-red-500" onclick="removeProduct(${index})">Eliminar</button>
                </div>
            `;

            container.insertAdjacentHTML('beforeend', productSelect);
        });

        document.getElementById('add-service').addEventListener('click', function() {
            let container = document.getElementById('servicios-container');
            let index = container.children.length;

            let serviceSelect = `
                <div class="form-group mb-2" id="service-${index}">
                    <select name="servicios[]" class="w-full rounded-md border border-[#e0e0e0] bg-white py-2 px-4 mb-2">
                        @foreach($servicios as $servicio)
                            <option value="{{ $servicio->id }}" data-price="{{ $servicio->precio }}">{{ $servicio->nombre }} - ${{ $servicio->precio }}</option>
                        @endforeach
                    </select>
                    <button type="button" class="remove-service text-red-500" onclick="removeService(${index})">Eliminar</button>
                </div>
            `;

            container.insertAdjacentHTML('beforeend', serviceSelect);
        });

        function removeProduct(index) {
            document.getElementById('product-' + index).remove();
        }

        function removeService(index) {
            document.getElementById('service-' + index).remove();
        }

        document.addEventListener('change', function() {
            let total = 100; // Precio inicial de la consulta
            document.querySelectorAll('select[name="productos[]"]').forEach(item => {
                total += parseFloat(item.selectedOptions[0].dataset.price) * parseFloat(item.closest('.form-group').querySelector('input[name="cantidades_productos[]"]').value);
            });
            document.querySelectorAll('select[name="servicios[]"]').forEach(item => {
                total += parseFloat(item.selectedOptions[0].dataset.price);
            });
            document.getElementById('total_pagar').value = total.toFixed(2);
        });
    </script>
</x-app-layout>
