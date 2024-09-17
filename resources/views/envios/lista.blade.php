<x-app-layout>
   

    <div class="pt-4 pb-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg ">
                <x-jet-authentication-card>
                    <x-slot name="logo">
                        <x-jet-authentication-card-logo />
                        <br><br>
                        <h1><strong>SALUD JUJUY</strong></h1>
                    </x-slot>
            
                    <x-jet-validation-errors class="mb-4" />
                    <h1 class="text-center">LISTA DE ENVIOS</h1>
    
                    
                    
                </x-jet-authentication-card>

                <table class="table-auto w-full">
                    <thead>
                        <tr>
                            <th class="px-4 py-2">Afiliado</th>
                            <th class="px-4 py-2">Prestador</th>
                            <th class="px-4 py-2">Obra Social</th>
                            <th class="px-4 py-2">Periodo</th>
                            <th class="px-4 py-2">Prestación</th>
                            <th class="px-4 py-2">Documentación</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($envios as $envio)
                            <tr>
                                <td class="border px-4 py-2">{{ $envio->AFILIADO }}</td>
                                <td class="border px-4 py-2">{{ $envio->PRESTADOR }}</td>
                                <td class="border px-4 py-2">{{ $envio->OBRASOCIAL }}</td>
                                <td class="border px-4 py-2">{{ $envio->PERIODO }}</td>
                                <td class="border px-4 py-2">{{ $envio->PRESTACION }}</td>
                                <td class="border px-4 py-2"><a href="{{ asset('storage/'.$envio->DOCUMENTACION) }}" target="_blank">Ver documento</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
        </div>
    </div>
</x-app-layout>