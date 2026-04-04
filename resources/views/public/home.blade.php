@extends('layouts.app')
@section('title', 'Accueil')

@section('content')
<div style="background:var(--leon-dark); color:white; padding: 5rem 0; text-align:center; border-bottom: 4px solid var(--leon-gold);">
    <div class="container">
        <h1 style="font-family:'Playfair Display', serif; font-size: 3rem; margin-bottom: 1rem;">Bienvenue Chez Léon</h1>
        <p style="font-size: 1.2rem; opacity: 0.8; max-width: 600px; margin: 0 auto 2rem;">Découvrez notre restaurant intelligent où la gastronomie rencontre l'Internet des Objets.</p>
        <div>
            <a href="{{ route('public.tour.index') }}" class="btn" style="background:var(--leon-gold); color:#000; font-weight:bold; padding: 10px 20px; border-radius: 6px; text-decoration:none; margin-right: 10px;">Faire la visite guidée</a>
            <a href="{{ route('public.news.index') }}" class="btn" style="background:transparent; color:#fff; border: 1px solid var(--leon-gold); padding: 10px 20px; border-radius: 6px; text-decoration:none;">Voir le menu</a>
        </div>
    </div>
</div>
@endsection