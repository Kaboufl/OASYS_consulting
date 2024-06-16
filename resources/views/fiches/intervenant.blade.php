@extends('layouts.back')
@section('content')
<div class="h-full p-4 justify-self-stretch bg-gray-400 rounded-md row-start-2 col-start-2 flex flex-col items-stretch gap-4">
    <div class="grid grid-rows-3 grid-cols-[6fr_3fr] items-center rounded-md border-2 border-neutral-700 bg-neutral-100 p-4">
        <h1 class="col-start-1 font-black text-2xl text-black">{{ $intervenant->prestataire ? 'Prestataire' : 'Salarié' }} : {{ $intervenant->prenom }} {{ $intervenant->nom }}</h1>
        <h3 class="col-start-1 font-black text-black">{{ $intervenant->prestataire ? 'Prestataire externe (taux horaire : '.$intervenant->getPrestataire->taux_horaire.'€)' : 'Salarié' }}</h3>
        <h4 class="col-start-1 font-medium text-black">Adresse mail : {{ $intervenant->email }}</h4>
    </div>

    <div class="grid grid-rows-3 grid-cols-2 items-center rounded-md border-2 border-neutral-700 bg-neutral-100 p-4">
        @if($intervenant->intervention)
            <h1 class="font-semibold text-2xl text-black">Intervention en cours : <span class="font-normal"> {{ $intervenant->intervention->libelle }}</span></h1>
            <h1 class="row-start-2 col-start-1 font-semibold text-lg text-black">Commentaire : <p class="font-light"> {{ $intervenant->intervention->libelle }}</p></h1>
            <h1 class="font-semibold text-xl text-black">Pour l'étape : <a class="underline text-cyan-600 font-normal" href="{{ route('admin.projet.etape.etape', [ 'projet' => session('id_projet'), 'etape' => $intervenant->intervention->etape->id]) }}">{{ $intervenant->intervention->libelle }}</a></h1>
        @elseif($intervenant->chefDe->count())
            Chef de projet
        @endif
    </div>

    {{-- @dump($intervenant) --}}
</div>

@endsection
