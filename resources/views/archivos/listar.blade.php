<x-app-layout>
    
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <a href="{{ route('envio.index') }}">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('AGREGAR') }}
                </h2>
            </a>
            <form method="POST" action="{{ route('archivo.exportar') }}">
                @csrf
                <input type="hidden" name="prestador" value="{{ request('prestador') }}">
                <input type="hidden" name="prestacion" value="{{ request('prestacion') }}">
                <input type="hidden" name="afiliado" value="{{ request('afiliado') }}">
                <input type="hidden" name="periodo" value="{{ request('periodo') }}">
                <input type="hidden" name="obrasocial" value="{{ request('obrasocial') }}">
                <input type="hidden" name="usuario" value="{{ request('usuario') }}">
                <x-jet-button class="ml-2">
                    {{ __('EXPORTAR') }}
                </x-jet-button>
            </form>
        </div>
        
    </x-slot>

    <div class="pt-4 pb-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <h1 class="text-center"><strong>Formulario de Filtro</strong></h1>
                <div class="container">
                    <form method="POST" role="search" action="{{ route('archivo.filtro') }}">
                        @csrf
                        <div class="form-group row">
                            <!-- Primera fila -->
                            <div class="col-md-4">
                                <label for="prestador" class="col-form-label">PRESTADOR</label>
                                <input type="text" class="form-control" name="prestador" id="prestador" placeholder="" value="{{ request('prestador') }}">
                            </div>
                            <div class="col-md-4">
                                <label for="prestacion" class="col-form-label">Nº PRESTACION</label>
                                <input type="text" class="form-control" name="prestacion" id="prestacion" placeholder="" value="{{ request('prestacion') }}">
                            </div>
                            <div class="col-md-4">
                                <label for="afiliado" class="col-form-label">AFILIADO</label>
                                <input type="text" class="form-control" name="afiliado" id="afiliado" placeholder="" value="{{ request('afiliado') }}">
                            </div>
                        </div>
                    
                        <div class="form-group row">
                            <!-- Segunda fila -->
                            <div class="col-md-4">
                                <label for="periodo" class="col-form-label">PERIODO</label>
                                <input type="text" class="form-control" name="periodo" id="periodo" placeholder="" value="{{ request('periodo') }}">
                            </div>
                            <div class="col-md-4">
                                <label for="obrasocial" class="col-form-label">OBRA SOCIAL</label>
                                <input type="text" class="form-control" name="obrasocial" id="obrasocial" placeholder="" value="{{ request('obrasocial') }}">
                            </div>
                            
                            <div class="col-md-4">
                                <label for="usuario" class="col-form-label">USUARIO</label>
                                @if(Auth::user()->rol_usuario != 3)
                                    <input type="text" class="form-control" name="usuario" id="usuario" placeholder="" value="{{ request('usuario') }}">
                                @else
                                    <input type="text" class="form-control" name="usuario" id="usuario" placeholder="" disabled>
                                @endif
                                
                            </div>
                        </div>

                        
                        <div class="form-group row">
                            <div class="col-md-4">
                                <!--
                                <label for="obrasocial" class="col-form-label">ESTADO</label>
                                <select class="form-control" name="estado">
                                    <option value="">Seleccione un estado</option>
                                    <option value="Activo" {{ request('estado') == 'Activo' ? 'selected' : '' }}>Activo</option>
                                    <option value="Caducado" {{ request('estado') == 'Caducado' ? 'selected' : '' }}>Caducado</option>
                                </select>
                                -->
                            </div>
                            <div class="col-md-4">
                                
                            </div>
                            <div class="col-md-4 text-center">
                                <label for="obrasocial" class="col-form-label"> </label>
                                <x-jet-button>
                                    {{ __('Buscar') }}
                                </x-jet-button>
                            </div>
                            
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="pt-4 pb-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                <h1 class="text-center"><strong>LISTA DE ARCHIVOS</strong> </h1>

                <br><br>
                
                <div style="overflow-x: auto;">
                    <table class="table-auto w-full text-center">
                        <thead>
                            <tr>
                                <th class="px-4 py-2">USUARIO</th>
                                <th class="px-4 py-2">AFILIADO</th>
                                <th class="px-4 py-2">PRESTADOR</th>
                                <th class="px-4 py-2">OBRA SOCIAL</th>
                                <th class="px-4 py-2">PERIODO</th>
                                <th class="px-4 py-2">Nª PRESTACION</th>
                                <th class="px-4 py-2">FECHA DE CARGA</th>
                                <th class="px-4 py-2">ESTADO</th>
                                <th class="px-4 py-2">DOCUMENTACION</th>
                                <th class="px-4 py-2">COMPORBANTE</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                        
                            @foreach ($lista as $item)
                                
                                <tr>
                                    <td class="border px-4 py-2">{{ $item->USUARIO}}</td>
                                    <td class="border px-4 py-2">{{ $item->AFILIADO }}</td>
                                    <td class="border px-4 py-2">{{ $item->PRESTADOR }}</td>
                                    <td class="border px-4 py-2">{{ $item->OBRASOCIAL }}</td>
                                    <td class="border px-4 py-2">{{ $item->PERIODO }}</td>
                                    <td class="border px-4 py-2">{{ $item->PRESTACION }}</td>
                                    <td class="border px-4 py-2">{{ $item->FECHACREACION }}</td>
                                    @if (request('estado')==null)
                                        <td class="border px-4 py-2">
                                            @if (\Carbon\Carbon::parse($item->FECHACREACION)->diffInHours(now()) >= 24)
                                                <span class="text-red-500">Caducado</span>
                                            @else
                                                <span class="text-green-500">Activo</span>
                                            @endif
                                        </td> 
                                    @else
                                        <td class="border px-4 py-2">{{ $item->estado }}</td>
                                    @endif

                                    <td class="border px-4 py-2">
                                        <a href="{{ $item->DOCUMENTACION }}" target="_blank">Ver Documentacion</a>
                                    </td>
                                    <td>
                                        <a href="{{ route('envio.comprobante',['id'=>$item->id]) }}" target="_blank">Ver comprobante</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $lista->links() }}
                </div>
                
            </div>
            
        </div>
    </div>
</x-app-layout>