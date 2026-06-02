@extends('layouts.minimal-admin')

@section('content')
    <div class="admin-container">
        <div style="max-width:1100px;margin:30px auto;padding:0 16px;color:#fff;">
            <h1 style="margin-bottom:12px;">Inscriptions</h1>

            @if(session('success'))
                <div style="background:#1f7a3a;padding:10px 12px;border-radius:10px;margin-bottom:12px;">
                    {{ session('success') }}
                </div>
            @endif

            <form method="get" style="display:flex;gap:10px;flex-wrap:wrap;margin-bottom:14px;">
                <input
                    name="q"
                    value="{{ $q }}"
                    placeholder="Recherche (ref, nom, email)..."
                    style="flex:1;min-width:260px;padding:10px;border-radius:10px;border:1px solid #333;background:#111;color:#fff;"
                >

                <select name="status" style="padding:10px;border-radius:10px;border:1px solid #333;background:#111;color:#fff;">
                    <option value="">Tous</option>
                    <option value="pending" {{ $status === 'pending' ? 'selected' : '' }}>En attente</option>
                    <option value="paid" {{ $status === 'paid' ? 'selected' : '' }}>Payé</option>
                </select>

                <button type="submit" style="padding:10px 14px;border-radius:10px;border:0;background:#c4311f;color:#fff;font-weight:700;">
                    Filtrer
                </button>
            </form>

            <div style="background:#0f0f10;border:1px solid #222;border-radius:14px;overflow:hidden;">
                <table style="width:100%;border-collapse:collapse;">
                    <thead style="background:#151516;">
                    <tr>
                        <th style="text-align:left;padding:12px;">Dossier</th>
                        <th style="text-align:left;padding:12px;">Nom</th>
                        <th style="text-align:left;padding:12px;">Formule</th>
                        <th style="text-align:left;padding:12px;">Statut</th>
                        <th style="text-align:left;padding:12px;">Action</th>
                    </tr>
                    </thead>

                    <tbody>
                    @forelse($enrollments as $e)
                        <tr style="border-top:1px solid #222;">
                            <td style="padding:12px;font-weight:700;">{{ $e->dossier_ref }}</td>
                            <td style="padding:12px;">{{ $e->first_name }} {{ $e->last_name }}</td>
                            <td style="padding:12px;">{{ $e->plan?->name }}</td>
                            <td style="padding:12px;">
                                <span style="padding:4px 10px;border-radius:999px;
                                    background:{{ $e->status === 'paid' ? '#1f7a3a' : '#444' }};
                                    color:#fff;font-weight:700;">
                                    {{ $e->status === 'paid' ? 'Payé' : 'En attente' }}
                                </span>
                            </td>
                            <td style="padding:12px;">
                                <a href="{{ route('admin.enrollments.show', $e) }}"
                                   style="color:#fff;text-decoration:underline;">
                                    Ouvrir
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr style="border-top:1px solid #222;">
                            <td colspan="5" style="padding:14px;color:#aaa;">
                                Aucun dossier trouvé.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <div style="margin-top:12px;">
                {{ $enrollments->links() }}
            </div>
        </div>
    </div>
@endsection
