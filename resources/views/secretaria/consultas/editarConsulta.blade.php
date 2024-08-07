<x-app-layout>
    <div class="flex items-center justify-center py-5 px-5">
        <!-- Formulario para editar consulta -->
        <div class="mx-auto w-full max-w-full">
            <form id="consulta-form" action="{{ route('consultas.update', ['id' => $consulta->id]) }}" method="POST">
                @csrf
                @method('PATCH')

                <!-- Motivo de la Consulta -->
                <div class="shadow-xl p-5 rounded-lg bg-white mb-5">
                    <label for="motivo" class="text-xl text-cyan-500 mb-3 font-medium flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                            <path fill-rule="evenodd" d="M7.502 6h7.128A3.375 3.375 0 0 1 18 9.375v9.375a3 3 0 0 0 3-3V6.108c0-1.505-1.125-2.811-2.664-2.94a48.972 48.972 0 0 0-.673-.05A3 3 0 0 0 15 1.5h-1.5a3 3 0 0 0-2.663 1.618c-.225.015-.45.032-.673.05C8.662 3.295 7.554 4.542 7.502 6ZM13.5 3A1.5 1.5 0 0 0 12 4.5h4.5A1.5 1.5 0 0 0 15 3h-1.5Z" clip-rule="evenodd" />
                            <path fill-rule="evenodd" d="M3 9.375C3 8.339 3.84 7.5 4.875 7.5h9.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-9.75A1.875 1.875 0 0 1 3 20.625V9.375ZM6 12a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75H6.75a.75.75 0 0 1-.75-.75V12Zm2.25 0a.75.75 0 0 1 .75-.75h3.75a.75.75 0 0 1 0 1.5H9a.75.75 0 0 1-.75-.75ZM6 15a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75H6.75a.75.75 0 0 1-.75-.75V15Zm2.25 0a.75.75 0 0 1 .75-.75h3.75a.75.75 0 0 1 0 1.5H9a.75.75 0 0 1-.75-.75Z" clip-rule="evenodd" />
                        </svg>
                        Motivo de la Consulta
                    </label>
                    <textarea id="motivo" name="motivo" placeholder="Ingrese el motivo de la consulta" maxlength="200" class="w-full resize-none rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md">{{ $consulta->motivo }}</textarea>
                    <div class="text-right text-sm text-gray-500">
                        <span id="motivo-counter">0</span>/200
                    </div>
                </div>
                
                <!-- Datos del Paciente -->
                <div class="shadow-xl p-5 rounded-lg bg-white mb-5">
                    <label for="datos" class="text-xl text-cyan-500 mb-3 font-medium flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                            <path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695Z" clip-rule="evenodd" />
                        </svg>
                        Datos del Paciente
                    </label>
                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <label for="talla" class="block text-base font-medium text-[#07074D]">Talla</label>
                            <input value="{{ $consulta->talla }}" type="text" id="talla" name="talla" placeholder="0 m" class="w-full rounded-md border border-[#e0e0e0] bg-white py-2 px-4 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                        </div>
                        <div>
                            <label for="temperatura" class="block text-base font-medium text-[#07074D]">Temperatura</label>
                            <input value="{{ $consulta->temperatura }}" type="text" id="temperatura" name="temperatura" placeholder="0 °C" class="w-full rounded-md border border-[#e0e0e0] bg-white py-2 px-4 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                        </div>
                        <div>
                            <label for="saturacion_oxigeno" class="block text-base font-medium text-[#07074D]">Saturación de oxígeno</label>
                            <input value="{{ $consulta->saturacion_oxigeno }}" type="text" id="saturacion_oxigeno" name="saturacion_oxigeno" placeholder="0 %" class="w-full rounded-md border border-[#e0e0e0] bg-white py-2 px-4 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                        </div>
                        <div>
                            <label for="frecuencia_cardiaca" class="block text-base font-medium text-[#07074D]">Frecuencia cardíaca</label>
                            <input value="{{ $consulta->frecuencia_cardiaca }}" type="text" id="frecuencia_cardiaca" name="frecuencia_cardiaca" placeholder="0 bpm" class="w-full rounded-md border border-[#e0e0e0] bg-white py-2 px-4 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                        </div>
                        <div>
                            <label for="peso" class="block text-base font-medium text-[#07074D]">Peso</label>
                            <input value="{{ $consulta->peso }}" type="text" id="peso" name="peso" placeholder="0 kg" class="w-full rounded-md border border-[#e0e0e0] bg-white py-2 px-4 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                        </div>
                        <div>
                            <label for="tension_arterial" class="block text-base font-medium text-[#07074D]">Tensión arterial</label>
                            <input value="{{ $consulta->tension_arterial }}" type="text" id="tension_arterial" name="tension_arterial" placeholder="120/80" class="w-full rounded-md border border-[#e0e0e0] bg-white py-2 px-4 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                        </div>
                    </div>  
                </div>

                <!-- Nota de Padecimiento -->
                <div class="shadow-xl p-5 rounded-lg bg-white mb-5">
                    <label for="padecimiento" class="text-xl text-cyan-500 mb-3 font-medium flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                            <path d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-12.15 12.15a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32L19.513 8.2Z" />
                        </svg>
                        Nota de Padecimiento
                    </label>
                    <textarea id="padecimiento" name="padecimiento" placeholder="Ingrese el padecimiento del paciente" maxlength="200" class="w-full resize-none rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md">{{ $consulta->padecimiento }}</textarea>
                    <div class="text-right text-sm text-gray-500">
                        <span id="padecimiento-counter">0</span>/200
                    </div>
                </div>   

                <!-- Enfermera que atendió -->
                <div class="shadow-xl p-5 rounded-lg bg-white mb-5">
                    <label for="enfermera_id" class="text-xl text-cyan-500 mb-3 font-medium flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                            <path fill-rule="evenodd" d="M4.5 3.75a3 3 0 0 0-3 3v10.5a3 3 0 0 0 3 3h15a3 3 0 0 0 3-3V6.75a3 3 0 0 0-3-3h-15Zm4.125 3a2.25 2.25 0 1 0 0 4.5 2.25 2.25 0 0 0 0-4.5Zm-3.873 8.703a4.126 4.126 0 0 1 7.746 0 .75.75 0 0 1-.351.92 7.47 7.47 0 0 1-3.522.877 7.47 7.47 0 0 1-3.522-.877.75.75 0 0 1-.351-.92ZM15 8.25a.75.75 0 0 0 0 1.5h3.75a.75.75 0 0 0 0-1.5H15ZM14.25 12a.75.75 0 0 1 .75-.75h3.75a.75.75 0 0 1 0 1.5H15a.75.75 0 0 1-.75-.75Zm.75 2.25a.75.75 0 0 0 0 1.5h3.75a.75.75 0 0 0 0-1.5H15Z" clip-rule="evenodd" />
                        </svg>
                        Enfermera que atendió
                    </label>
                    <select id="enfermera_id" name="enfermera_id" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md">
                        <option value="">Seleccione una enfermera</option>
                        @foreach($enfermeras as $enfermera)
                            <option value="{{ $enfermera->id }}" {{ $consulta->enfermera_id == $enfermera->id ? 'selected' : '' }}>
                                {{ $enfermera->nombres . ' ' . $enfermera->apepat . ' (' . $enfermera->email . ')'}}
                            </option>                        
                        @endforeach 
                    </select>
                </div>

                <!-- Productos adquiridos -->
                <div class="shadow-xl p-5 rounded-lg bg-white mb-5">
                    <label class="text-xl text-cyan-500 mb-3 font-medium flex items-center">Productos adquiridos</label>
                    <div id="productos-adquiridos-container">
                        @foreach($consulta->productos as $producto)
                            <div class="form-check mb-2">
                                <label class="form-check-label" data-price="{{ $producto->precio }}" for="producto_adquirido_{{ $producto->id }}">{{ $producto->nombre }} - ${{ $producto->precio }} x {{ $producto->pivot->cantidad }}</label>
                                <input type="hidden" name="productos_existentes[]" value="{{ $producto->id }}">
                                <input type="hidden" name="cantidades_existentes[]" value="{{ $producto->pivot->cantidad }}">
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Productos -->
                <div class="shadow-xl p-5 rounded-lg bg-white mb-5">
                    <label for="productos" class="text-xl text-cyan-500 mb-3 font-medium flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                            <path fill-rule="evenodd" d="M7.5 6v.75H5.513c-.96 0-1.764.724-1.865 1.679l-1.263 12A1.875 1.875 0 0 0 4.25 22.5h15.5a1.875 1.875 0 0 0 1.865-2.071l-1.263-12a1.875 1.875 0 0 0-1.865-1.679H16.5V6a4.5 4.5 0 1 0-9 0ZM12 3a3 3 0 0 0-3 3v.75h6V6a3 3 0 0 0-3-3Zm-3 8.25a3 3 0 1 0 6 0v-.75a.75.75 0 0 1 1.5 0v.75a4.5 4.5 0 1 1-9 0v-.75a.75.75 0 0 1 1.5 0v.75Z" clip-rule="evenodd" />
                        </svg>
                        Productos
                    </label>                        
                    <div id="productos-container">
                        <!-- Aquí se añadirán los productos dinámicamente -->
                    </div>
                    <button type="button" id="add-product" class="mb-3 mt-2 text-base font-medium text-gray-800">+ Añadir Producto</button>
                </div>

                <!-- Servicios adquiridos -->
                <div class="shadow-xl p-5 rounded-lg bg-white mb-5">
                    <label class="text-xl text-cyan-500 mb-3 font-medium flex items-center">Servicios adquiridos</label>
                    <div id="servicios-adquiridos-container">
                        @foreach($consulta->servicios as $servicio)
                            <div class="form-check mb-2">
                                <label class="form-check-label" data-price="{{ $servicio->precio }}" for="servicio_adquirido_{{ $servicio->id }}">{{ $servicio->nombre }} - ${{ $servicio->precio }}</label>
                                <input type="hidden" name="servicios_existentes[]" value="{{ $servicio->id }}">
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Servicios -->
                <div class="shadow-xl p-5 rounded-lg bg-white mb-5">
                    <label for="servicios" class="text-xl text-cyan-500 mb-3 font-medium flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                            <path fill-rule="evenodd" d="M12 6.75a5.25 5.25 0 0 1 6.775-5.025.75.75 0 0 1 .313 1.248l-3.32 3.319c.063.475.276.934.641 1.299.365.365.824.578 1.3.64l3.318-3.319a.75.75 0 0 1 1.248.313 5.25 5.25 0 0 1-5.472 6.756c-1.018-.086-1.87.1-2.309.634L7.344 21.3A3.298 3.298 0 1 1 2.7 16.657l8.684-7.151c.533-.44.72-1.291.634-2.309A5.342 5.342 0 0 1 12 6.75ZM4.117 19.125a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75h-.008a.75.75 0 0 1-.75-.75v-.008Z" clip-rule="evenodd" />
                        </svg>
                        Servicios
                    </label>                        
                    <div id="servicios-container">
                        <!-- Aquí se añadirán los servicios dinámicamente -->
                    </div>
                    <button type="button" id="add-service" class="mb-3 mt-2 text-base font-medium text-gray-800">+ Añadir Servicio</button>
                </div>

                <!-- Estado -->
                <div class="shadow-xl p-5 rounded-lg bg-white mb-5">
                    <label for="estado" class="text-xl text-cyan-500 mb-3 font-medium flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                            <path fill-rule="evenodd" d="M12 6.75a5.25 5.25 0 0 1 6.775-5.025.75.75 0 0 1 .313 1.248l-3.32 3.319c.063.475.276.934.641 1.299.365.365.824.578 1.3.64l3.318-3.319a.75.75 0 0 1 1.248.313 5.25 5.25 0 0 1-5.472 6.756c-1.018-.086-1.87.1-2.309.634L7.344 21.3A3.298 3.298 0 1 1 2.7 16.657l8.684-7.151c.533-.44.72-1.291.634-2.309A5.342 5.342 0 0 1 12 6.75ZM4.117 19.125a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75h-.008a.75.75 0 0 1-.75-.75v-.008Z" clip-rule="evenodd" />
                        </svg>
                        Estado
                    </label>  
                    <select id="estado" name="estado" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md">
                        <option value="En proceso" {{ $consulta->estado == 'En proceso' ? 'selected' : '' }}>En proceso</option>
                        <option value="Finalizado" {{ $consulta->estado == 'Finalizado' ? 'selected' : '' }}>Finalizado</option>
                    </select>
                </div>

                <!-- Total a Pagar -->
                <div class="shadow-xl p-5 rounded-lg bg-white mb-5">
                    <label for="total_pagar" class="text-xl text-cyan-500 mb-3 font-medium flex items-center">
                        Total a Pagar
                    </label>
                    <input type="number" step="0.01" id="total_pagar" name="total_pagar" value="{{ $consulta->total_pagar }}" readonly class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                </div>

                <button class="hover:shadow-form rounded-md bg-[#6A64F1] py-3 px-8 text-base font-semibold text-white outline-none">Actualizar Consulta</button>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const motivoTextarea = document.getElementById('motivo');
            const motivoCounter = document.getElementById('motivo-counter');
            const maxLengthMotivo = motivoTextarea.getAttribute('maxlength');

            motivoTextarea.addEventListener('input', function () {
                const currentLength = motivoTextarea.value.length;
                motivoCounter.textContent = currentLength;

                if (currentLength >= maxLengthMotivo) {
                    motivoCounter.classList.add('text-red-500');
                } else {
                    motivoCounter.classList.remove('text-red-500');
                }
            });

            const padecimientoTextarea = document.getElementById('padecimiento');
            const padecimientoCounter = document.getElementById('padecimiento-counter');
            const maxLengthPadecimiento = padecimientoTextarea.getAttribute('maxlength');

            padecimientoTextarea.addEventListener('input', function () {
                const currentLength = padecimientoTextarea.value.length;
                padecimientoCounter.textContent = currentLength;

                if (currentLength >= maxLengthPadecimiento) {
                    padecimientoCounter.classList.add('text-red-500');
                } else {
                    padecimientoCounter.classList.remove('text-red-500');
                }
            });
        });

        function updateTotal() {
            let total = 100; // Reinicia el total a cero para calcular nuevamente

            // Sumamos el total de productos existentes
            document.querySelectorAll('#productos-adquiridos-container .form-check-label').forEach(label => {
                let cantidad = parseFloat(label.nextElementSibling.nextElementSibling.value);
                let precio = parseFloat(label.dataset.price);
                total += precio * cantidad;
            });

            // Sumamos el total de productos nuevos
            document.querySelectorAll('select[name="productos[]"]').forEach(item => {
                let price = parseFloat(item.selectedOptions[0].dataset.price);
                let quantity = parseFloat(item.closest('.form-group').querySelector('input[name="cantidades_productos[]"]').value);
                total += price * quantity;
            });

            // Sumamos el total de servicios existentes
            document.querySelectorAll('#servicios-adquiridos-container .form-check-label').forEach(label => {
                let precio = parseFloat(label.dataset.price);
                total += precio;
            });

            // Sumamos el total de servicios nuevos
            document.querySelectorAll('select[name="servicios[]"]').forEach(item => {
                let price = parseFloat(item.selectedOptions[0].dataset.price);
                total += price;
            });

            document.getElementById('total_pagar').value = total.toFixed(2);
        }

        document.getElementById('add-product').addEventListener('click', function() {
            let container = document.getElementById('productos-container');
            let index = container.children.length;

            let productSelect = `
                <div class="form-group mb-2" id="product-${index}">
                    <select name="productos[]" class="w-full rounded-md border border-[#e0e0e0] bg-white py-2 px-4 mb-2" onchange="updateTotal()">
                        @foreach($productos as $producto)
                            <option value="{{ $producto->id }}" data-price="{{ $producto->precio }}">{{ $producto->nombre }} - ${{ $producto->precio }}</option>
                        @endforeach
                    </select>
                    <input type="number" name="cantidades_productos[]" min="1" value="1" class="w-full rounded-md border border-[#e0e0e0] bg-white py-2 px-4 mb-2" placeholder="Cantidad" onchange="updateTotal()">
                    <button type="button" class="remove-product text-red-500" onclick="removeProduct(${index})">Eliminar</button>
                </div>
            `;

            container.insertAdjacentHTML('beforeend', productSelect);
            updateTotal();
        });

        document.getElementById('add-service').addEventListener('click', function() {
            let container = document.getElementById('servicios-container');
            let index = container.children.length;

            let serviceSelect = `
                <div class="form-group mb-2" id="service-${index}">
                    <select name="servicios[]" class="w-full rounded-md border border-[#e0e0e0] bg-white py-2 px-4 mb-2" onchange="updateTotal()">
                        @foreach($servicios as $servicio)
                            <option value="{{ $servicio->id }}" data-price="{{ $servicio->precio }}">{{ $servicio->nombre }} - ${{ $servicio->precio }}</option>
                        @endforeach
                    </select>
                    <button type="button" class="remove-service text-red-500" onclick="removeService(${index})">Eliminar</button>
                </div>
            `;

            container.insertAdjacentHTML('beforeend', serviceSelect);
            updateTotal();
        });

        function removeProduct(index) {
            document.getElementById('product-' + index).remove();
            updateTotal();
        }

        function removeService(index) {
            document.getElementById('service-' + index).remove();
            updateTotal();
        }

        window.onload = function() {
            updateTotal();
        }

        document.getElementById('consulta-form').addEventListener('submit', function(event) {
            const talla = document.getElementById('talla').value;
            const motivo = document.getElementById('motivo').value;
            const temperatura = document.getElementById('temperatura').value;
            const saturacionOxigeno = document.getElementById('saturacion_oxigeno').value;
            const frecuenciaCardiaca = document.getElementById('frecuencia_cardiaca').value;
            const peso = document.getElementById('peso').value;
            const tensionArterial = document.getElementById('tension_arterial').value;
            const padecimiento = document.getElementById('padecimiento').value; 

            if (motivo === "") {
                event.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: '¡Error!',
                    text: 'Por favor ingrese el motivo de la consulta.',
                });
                return;
            }

            if (padecimiento === "") {
                event.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: '¡Error!',
                    text: 'Por favor ingrese la nota de padecimiento.',
                });
                return;
            }
            
            if (talla <= 0 || talla > 2.5) {
                event.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: '¡Error!',
                    text: 'Por favor ingrese una talla válida (entre 0 y 2.5 m).',
                });
                return;
            }

            if (temperatura <= 0 || temperatura > 45) {
                event.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: '¡Error!',
                    text: 'Por favor ingrese una temperatura válida (entre 0 y 45 °C).',
                });
                return;
            }

            if (saturacionOxigeno <= 0 || saturacionOxigeno > 100) {
                event.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: '¡Error!',
                    text: 'Por favor ingrese una saturación de oxígeno válida (entre 0% y 100%).',
                });
                return;
            }

            if (frecuenciaCardiaca <= 0 || frecuenciaCardiaca > 220) {
                event.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: '¡Error!',
                    text: 'Por favor ingrese una frecuencia cardíaca válida (entre 0 y 220 bpm).',
                });
                return;
            }

            if (peso <= 0 || peso > 300) {
                event.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: '¡Error!',
                    text: 'Por favor ingrese un peso válido (entre 0 y 300 kg).',
                });
                return;
            }

            if (!/^\d{1,3}\/\d{1,3}$/.test(tensionArterial)) {
                event.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: '¡Error!',
                    text: 'Por favor ingrese una tensión arterial válida (formato 120/80).',
                });
                return;
            }

            if (document.querySelectorAll('select[name="productos[]"]').length > 100) {
                event.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: '¡Error!',
                    text: 'No se pueden añadir más de 100 productos.',
                });
                return;
            }

            Swal.fire({
                icon: 'success',
                title: '¡Consulta creada!',
                text: 'La consulta ha sido creada exitosamente.',
            });
        });
    </script>
</x-app-layout>
