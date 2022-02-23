<x-app-layout>
    <x-slot name="header">
        <h2 class="">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

	<div class="row">
		<div class="col-12">
			<div class="">
				@can('user')
					Usuario Comum
				@elsecan('admin')
					Administrador Logado
				@endcan
			</div>
		</div>
	</div>
</x-app-layout>
