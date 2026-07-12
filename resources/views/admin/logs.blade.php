@extends('layouts.admin')

@section('title', "ParaAdmin | Journal d'Audit")

@section('content')
    <div class="space-y-8">
        
        <div class="flex justify-between items-center bg-white p-6 rounded-3xl border border-gray-200/60 shadow-sm">
            <div>
                <h2 class="text-2xl md:text-3xl font-black text-gray-800 tracking-tight flex items-center gap-2">
                    <span>🔒</span> Journal d'Audit & Sécurité
                </h2>
                <p class="text-gray-400 text-xs font-medium mt-1">Historique en temps réel des actions effectuées sur le panel.</p>
            </div>
            <span class="bg-red-50 text-red-700 text-[10px] font-black px-3 py-1.5 rounded-full border border-red-200/40 uppercase tracking-wider shadow-sm">
                Secured
            </span>
        </div>

        <div class="bg-white rounded-3xl shadow-sm border border-gray-200/60 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-gray-50/80 border-b border-gray-100">
                        <tr class="text-xs font-bold text-gray-400 uppercase tracking-wider">
                            <th class="p-5">Utilisateur</th>
                            <th class="p-5">Action</th>
                            <th class="p-5">Description</th>
                            <th class="p-5">Adresse IP</th>
                            <th class="p-5">Date & Heure</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm">
                        @forelse($logs as $log)
                            <tr class="hover:bg-gray-50/40 transition">
                                <td class="p-5 font-black text-gray-900">
                                    <div class="flex items-center gap-2">
                                        <span class="text-base">{{ $log->user_name ? '👤' : '🌐' }}</span>
                                        <span>{{ $log->user_name ?? 'Visiteur Public' }}</span>
                                    </div>
                                </td>
                                <td class="p-5">
                                    @php
                                        $styles = [
                                            'Connexion' => 'bg-blue-50 text-blue-700 border border-blue-100',
                                            'Ajout Produit' => 'bg-green-50 text-green-700 border border-green-100',
                                            'Modification Produit' => 'bg-amber-50 text-amber-700 border border-amber-100',
                                            'Suppression Produit' => 'bg-red-50 text-red-700 border border-red-100',
                                            'Déconnexion' => 'bg-gray-100 text-gray-600 border border-gray-200/40'
                                        ];
                                        $badgeStyle = $styles[$log->action] ?? 'bg-gray-50 text-gray-700 border border-gray-200/40';
                                    @endphp
                                    <span class="px-2.5 py-1 rounded-xl text-xs font-black tracking-wide {{ $badgeStyle }}">
                                        {{ $log->action }}
                                    </span>
                                </td>
                                <td class="p-5 text-gray-500 max-w-xs truncate font-medium" title="{{ $log->description }}">
                                    {{ $log->description }}
                                </td>
                                <td class="p-5 font-mono text-xs text-gray-400 font-bold">
                                    <span class="bg-gray-50 px-2 py-1 rounded-lg border border-gray-100">{{ $log->ip_address }}</span>
                                </td>
                                <td class="p-5 text-gray-500 text-xs font-semibold">
                                    {{ $log->created_at->format('d/m/Y H:i:s') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-12 text-center text-gray-400 italic font-medium">
                                    <div class="flex flex-col items-center gap-2">
                                        <span class="text-2xl">🍃</span>
                                        <span>Aucun log enregistré dans le journal d'audit.</span>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="mt-6 flex justify-center">
            @include('partials.admin-pagination', ['paginator' => $logs])
        </div>
    </div>
@endsection