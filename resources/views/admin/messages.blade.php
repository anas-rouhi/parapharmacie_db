@extends('layouts.admin')

@section('title', 'ParaAdmin | Messages')

@section('content')
<div class="space-y-8">
    <div class="flex justify-between items-center bg-white p-6 rounded-3xl border border-gray-200/60 shadow-sm">
        <div>
            <h2 class="text-2xl md:text-3xl font-black text-gray-800 tracking-tight">Messages des Visiteurs </h2>
            <p class="text-xs text-gray-400 font-semibold mt-1">Gérez les demandes de contact et retours utilisateurs</p>
        </div>
        <span class="bg-purple-50 text-purple-700 text-xs font-black px-4 py-2 rounded-xl border border-purple-200/40 shadow-sm">
            Total: {{ $messages->total() }} الرسائل
        </span>
    </div>

    <div class="bg-white rounded-3xl border border-gray-200/60 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/70 border-b border-gray-100 text-gray-400 uppercase text-[10px] font-black tracking-wider">
                        <th class="p-5">Statut</th>
                        <th class="p-5">Expéditeur</th>
                        <th class="p-5">Message</th>
                        <th class="p-5">Date d'envoi</th>
                        <th class="p-5 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100/70 text-sm font-medium text-gray-600">
                    @forelse($messages as $msg)
                        <tr class="hover:bg-slate-50/50 transition {{ !$msg->is_read ? 'bg-blue-50/10 font-bold' : '' }}">
                            <td class="p-5">
                                @if(!$msg->is_read)
                                    <span class="bg-blue-100 text-blue-700 text-[9px] font-black px-2 py-1 rounded-full uppercase tracking-wider">Nouveau</span>
                                @else
                                    <span class="bg-gray-100 text-gray-400 text-[9px] font-black px-2 py-1 rounded-full uppercase tracking-wider">Lu</span>
                                @endif
                            </td>
                            <td class="p-5">
                                <div class="text-gray-900 font-bold">{{ $msg->nom }}</div>
                                <div class="text-xs text-gray-400 font-semibold">{{ $msg->email }}</div>
                            </td>
                            <td class="p-5 max-w-md">
                                @if($msg->sujet)
                                    <div class="text-xs text-green-600 mb-1 uppercase font-bold">{{ $msg->sujet }}</div>
                                @endif
                                <p class="text-gray-700 font-medium whitespace-pre-line text-xs">{{ $msg->message }}</p>
                            </td>
                            <td class="p-5 text-xs text-gray-400 font-semibold">
                                {{ $msg->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="p-5">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="mailto:{{ $msg->email }}?subject=Re: {{ $msg->sujet ?? 'Contact ParaPharmacie' }}" title="Répondre par Email" class="p-2 bg-green-50 hover:bg-green-100 text-green-600 rounded-xl transition text-center text-xs decoration-none">
                                        💬 Répondre
                                    </a>

                                    @if(!$msg->is_read)
                                        <form action="{{ route('admin.messages.markRead', $msg->id) }}" method="POST" class="inline">
                                            @csrf @method('PUT')
                                            <button type="submit" title="Marquer comme lu" class="p-2 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-xl transition border-none cursor-pointer">
                                                👁️
                                            </button>
                                        </form>
                                    @endif
                                    
                                    <form action="{{ route('admin.messages.delete', $msg->id) }}" method="POST" class="inline" data-confirm="Ce message sera définitivement supprimé." data-confirm-title="Supprimer ce message ?">
                                        @csrf @method('DELETE')
                                        <button type="submit" title="Supprimer" class="p-2 bg-red-50 hover:bg-red-100 text-red-600 rounded-xl transition border-none cursor-pointer">
                                            🗑️
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-10 text-center text-gray-400 font-bold">
                                📥 Aucun message reçu pour le moment.
                            </td>
                        </tr>
                    @endempty
                </tbody>
            </table>
        </div>
        @if($messages->hasPages())
            <div class="p-4 border-t border-gray-100">
                @include('partials.admin-pagination', ['paginator' => $messages])
            </div>
        @endif
    </div>
</div>
@endsection