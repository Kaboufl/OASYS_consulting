@extends('layouts.back')
@section('content')
<div class="h-full p-4 justify-self-stretch bg-gray-400 rounded-md row-start-2 col-start-2 flex flex-col items-stretch gap-4">
    <div class="grid grid-rows-3 grid-cols-[6fr_3fr] items-center rounded-md border-2 border-neutral-700 bg-neutral-100 p-4">
        <h1 class="col-start-1 font-black text-2xl text-black">Intervenant : {{ $intervenant->prenom }} {{ $intervenant->nom }}</h1>
        <h3 class="col-start-1 font-black text-black">{{ $intervenant->prestataire ? 'Prestataire externe (taux horaire : '.$intervenant->prestataire->taux_horaire.'€)' : 'Salarié' }}</h3>
        <h4 class="col-start-1 font-medium text-black">Adresse mail : {{ $intervenant->email }}</h4>
    </div>

    @if($intervenant->intervention)
        C'est un salarié non-chef de projet
    @endif
    
    @dump($intervenant)
</div>

@endsection