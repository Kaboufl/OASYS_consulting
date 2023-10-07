@extends('layouts.front')
@section('content')
    <h1>AAAAAAAAA</h1>
    <form action="" method="POST">
        @csrf
        <div>
            <label for="libelle">Libellé</label>
            <input type="text" name="libelle" id="libelle">
        </div>
        <div>
            <label for="statut">Libellé</label>
            <select name="statut" id="statut">
                <option value="ok">OK</option>
            </select>
        </div>
        <div>
            <label for="taux">Taux horaire</label>
            <input type="number" name="taux" id="taux">
        </div>
        <input type="hidden" value="0" name="client">
        <input type="hidden" value="0" name="domaine">
        <input type="hidden" value="0" name="chef">

        <input type="submit" value="Envoyer">

    </form>
@stop