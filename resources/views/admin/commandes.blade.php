@extends('layouts.admin')

@section('title', 'ParaAdmin | Suivi des Commandes')

@section('content')
    <div class="flex justify-between items-center mb-10">
        <div class="flex items-center gap-3">
            <h2 class="text-3xl font-black text-gray-800 tracking-tight">Suivi des Commandes</h2>
            <span class="bg-blue-50 text-blue-700 text-xs font-black px-3 py-1 rounded-full uppercase tracking-wider border border-blue-100">Ventes</span>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-500 text-white p-4 rounded-xl mb-6 font-semibold shadow-md">
            ✅ {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-3xl shadow-sm border border-gray-200/60 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50/80 border-b border-gray-100">
                    <tr>
                        <th class="p-5 text-xs font-bold text-gray-400 uppercase tracking-wider">Réf</th>
                        <th class="p-5 text-xs font-bold text-gray-400 uppercase tracking-wider">Client</th>
                        <th class="p-5 text-xs font-bold text-gray-400 uppercase tracking-wider">Téléphone</th>
                        <th class="p-5 text-xs font-bold text-gray-400 uppercase tracking-wider">Adresse</th>
                        <th class="p-5 text-xs font-bold text-gray-400 uppercase tracking-wider">Total</th>
                        <th class="p-5 text-xs font-bold text-gray-400 uppercase tracking-wider text-center" style="width: 280px;">Statut</th>
                        <th class="p-5 text-xs font-bold text-gray-400 uppercase tracking-wider text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($commandes as $cmd)
                        <tr class="hover:bg-gray-50/40 transition">
                            <td class="p-5 font-mono text-sm text-green-600 font-bold">#{{ $cmd->id }}</td>
                            <td class="p-5">
                                <div class="font-bold text-gray-800 text-sm">{{ $cmd->nom_complet }}</div>
                                <span class="inline-block text-[9px] font-black px-1.5 py-0.5 rounded uppercase mt-1 {{ $cmd->user_id ? 'bg-green-50 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                                    {{ $cmd->user_id ? 'Membre' : 'Invité' }}
                                </span>
                            </td>
                            <td class="p-5 text-gray-600 font-semibold text-sm">{{ $cmd->telephone }}</td>
                            <td class="p-5 text-gray-500 text-sm max-w-xs truncate" title="{{ $cmd->adresse }}">{{ $cmd->adresse }}</td>
                            <td class="p-5 font-black text-gray-900 text-sm">{{ number_format($cmd->total, 2) }} DH</td>
                            
                            <td class="p-5">
                                @php
                                    $progress = ['en_attente' => 15, 'valide' => 55, 'livre' => 100, 'annule' => 100];
                                    $p = $progress[$cmd->status] ?? 15;
                                    $barColor = $cmd->status == 'en_attente' ? 'bg-orange-400' : ($cmd->status == 'annule' ? 'bg-red-500' : 'bg-green-500');
                                @endphp
                                <div class="flex flex-col gap-2 mx-auto" style="max-w: 240px;">
                                    <div class="w-full bg-gray-100 rounded-full h-2 overflow-hidden">
                                        <div class="{{ $barColor }} h-2 rounded-full transition-all duration-500" style="width: {{ $p }}%"></div>
                                    </div>
                                    <div class="flex justify-between items-center px-1 gap-1">
                                        @foreach(['en_attente' => 'ATTENTE', 'valide' => 'VALIDÉ', 'livre' => 'LIVRÉ', 'annule' => 'X'] as $statusKey => $statusLabel)
                                            <form action="{{ route('admin.commandes.update', $cmd->id) }}" method="POST" class="inline">
                                                @csrf @method('PUT')
                                                <input type="hidden" name="status" value="{{ $statusKey }}">
                                                <button type="submit" class="text-[10px] font-extrabold tracking-wider transition duration-150 {{ $cmd->status == $statusKey ? 'text-green-600 font-black scale-105' : 'text-gray-400 hover:text-gray-600' }}">{{ $statusLabel }}</button>
                                            </form>
                                        @endforeach
                                    </div>
                                </div>
                            </td>
                            
                            <td class="p-5 text-center">
                                <form action="{{ route('admin.commandes.delete', $cmd->id) }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer cette commande ?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-white bg-red-50 hover:bg-red-500 p-2 rounded-xl transition duration-250">
                                        🗑️
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-10 text-center text-gray-400 italic">Aucune commande trouvée.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection