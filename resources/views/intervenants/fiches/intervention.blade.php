@extends('layouts.back')
@section('content')

    <div
        class="h-full p-4 justify-self-stretch bg-gray-400 rounded-md row-start-2 col-start-2 flex flex-col items-stretch gap-4">
        
        <div
            class="grid grid-rows-3 grid-cols-[6fr_3fr] items-center rounded-md border-2 border-neutral-700 bg-neutral-100 p-4">
            <h3 class="col-start-1 font-bold text-black">Projet assigné : {{ $projet->libelle }}</h3>
            <h3 class="col-start-1 font-bold text-black">Etape : {{ $etape->libelle }}</h3>
            <h1 class="col-start-1 font-black text-2xl text-black">Intervention : {{ $intervention->libelle }}</h1>

            
            
        </div>
        
        <form method="POST" class="p-4 justify-self-stretch border-neutral-700 bg-neutral-100 rounded-md row-start-2 col-start-2 flex flex-col items-stretch gap-2">
            @csrf
            <label class="font-bold text-black" for="commentaire">Commentaire :</label>
            <textarea name="commentaire" id="commentaire" cols="30" rows="10" class="rounded-md border-2 border-neutral-300 bg-white p-4">{{ $intervention->commentaire }}</textarea>
            <button type="submit"
                        class="text-white ml-auto bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Enregistrer</a>
                    
        </form>
    </div>

    

@endsection
