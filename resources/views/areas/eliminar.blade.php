<x-app-layout>
    <x-slot name="header">
        <a href="{{route('area.registrar')}}">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('AGREGAR') }}
            </h2>
        </a>
    </x-slot>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <x-jet-authentication-card-logo />
            <br><br>
            <h1 style="font-size: 20px"><strong>SALUD JUJUY</strong></h1>
        </x-slot>

        <x-jet-validation-errors class="mb-4" />
1
        <div class="text-center">
            <h2>Formulario de Eliminacion de Area</h2>
        </div>

        <form method="POST" action="{{ route('area.borrar',$area) }}">
            @csrf
           
            <div>
                <x-jet-label for="id" value="{{ __('Id Area') }}" />
                <x-jet-input id="id" class="block mt-1 w-full" type="text" name="id" value="{{ $area->id }}" required autofocus autocomplete="id" />
            </div>

            <div>
                <x-jet-label for="cuit" value="{{ __('Numero de C.U.I.T.') }}" />
                <x-jet-input id="cuit" class="block mt-1 w-full" disabled type="text" name="cuit" value="{{ $area->area_cuit }}" required autofocus autocomplete="cuit" />
            </div>

            <div>
                <x-jet-label for="nombre" value="{{ __('Nombre Completo') }}" />
                <x-jet-input id="nombre" class="block mt-1 w-full" disabled type="text" name="nombre" value="{{ $area->area_nombre }}" required autofocus autocomplete="nombre" />
            </div>
            
            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="mt-4">
                    <x-jet-label for="terms">
                        <div class="flex items-center">
                            <x-jet-checkbox name="terms" id="terms"/>

                            <div class="ml-2">
                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                        'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Terms of Service').'</a>',
                                        'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Privacy Policy').'</a>',
                                ]) !!}
                            </div>
                        </div>
                    </x-jet-label>
                </div>
            @endif

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('area.back') }}">
                    {{ __('Cancelar') }}
                </a>

                <x-jet-button class="ml-4">
                    {{ __('Eliminar') }}
                </x-jet-button>
            </div>
        </form>
    </x-jet-authentication-card>
</x-app-layout>