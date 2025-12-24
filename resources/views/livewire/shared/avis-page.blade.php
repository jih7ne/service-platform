<div class="avis-page {{ $theme ?? 'pink' }}">
    <style>
        /* Theme variables */
        .avis-page { --bg: #f7fafc; --text: #1f2937; --muted: #6b7280; }
        .avis-page.pink { --primary: #d94680; --primary-dark: #b82e6e; --accent: #fde8f0; --accent-text: #862749; --icon: #d94680; --muted-icon: #f7c6d9; }
        .avis-page.blue { --primary: #2B5AA8; --primary-dark: #224A91; --accent: #E1EAF7; --accent-text: #2B5AA8; --icon: #2B5AA8; --muted-icon: #cfe0f6; }

        .avis-page { background: var(--bg); padding: 32px; color: var(--text); font-family: Inter, ui-sans-serif, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial; }

        /* Header */
        .avis-header { margin-bottom: 24px; }
        .avis-header .meta { display: flex; align-items: center; gap: 12px; margin-bottom: 8px; }
        .icon-box { width: 48px; height: 48px; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #fff; background: var(--primary); box-shadow: 0 6px 18px rgba(0,0,0,0.06); }
        .avis-title { font-size: 24px; font-weight: 700; }
        .avis-subtitle { color: var(--muted); font-size: 16px; margin: 0; }

        /* Flash messages */
        .flash { padding: 12px; border-radius: 12px; margin-bottom: 16px; display: flex; align-items: center; gap: 10px; }
        .flash.success { background: #ecfdf5; color: #065f46; border: 1px solid #bbf7d0; }
        .flash.error { background: #fff1f2; color: #7f1d1d; border: 1px solid #fecaca; }

        /* Filters */
        .filters { background: #fff; border-radius: 16px; border: 1px solid #e5e7eb; padding: 18px; margin-bottom: 24px; box-shadow: 0 6px 18px rgba(0,0,0,0.04); }
        .filters .filters-header { display: flex; align-items: center; gap: 12px; margin-bottom: 12px; }
        .filters h2 { margin: 0; font-size: 16px; font-weight: 600; }
        .filters label { display: flex; align-items: center; gap: 8px; font-size: 14px; color: var(--muted); margin-bottom: 8px; }
        .filters select { width: 100%; padding: 10px 12px; border-radius: 12px; border: 1px solid #d1d5db; background: #fff; }

        /* Feedback list */
        .feedback-list { display: block; gap: 16px; }
        .feedback { background: #fff; border-radius: 16px; border: 1px solid #e5e7eb; padding: 22px; box-shadow: 0 6px 12px rgba(0,0,0,0.03); margin-bottom: 16px; }
        .feedback .head { display: flex; align-items: flex-start; justify-content: space-between; gap: 16px; }
        .user { display: flex; gap: 14px; align-items: center; }
        .avatar { width: 64px; height: 64px; border-radius: 12px; object-fit: cover; border: 2px solid #e5e7eb; }
        .avatar-placeholder { width: 64px; height: 64px; border-radius: 12px; display:flex; align-items:center; justify-content:center; font-weight:700; font-size:18px; background: var(--accent); color: var(--accent-text); }
        .user-info h3 { margin: 0; font-size: 18px; font-weight: 700; color: var(--text); }
        .meta-row { display:flex; gap:12px; align-items:center; margin-top:8px; }
        .rating { background: #fffbeb; padding:6px 10px; border-radius:999px; border:1px solid #fbe7c6; display:flex; gap:6px; align-items:center; }
        .date-pill { font-size:13px; color:var(--muted); background:#f9fafb; padding:6px 10px; border-radius:999px; }

        .comment { background:#fafafa; padding:12px; border-radius:12px; border:1px solid #eef2f7; color: #374151; }

        .claim-actions { display:flex; justify-content:flex-end; margin-top:12px; }
        .btn { padding:10px 16px; border-radius: 12px; font-weight:600; display:inline-flex; align-items:center; gap:8px; cursor:pointer; border:0; }
        .btn-primary { background: var(--primary); color: #fff; }
        .btn-primary:hover { background: var(--primary-dark); }
        .btn-muted { background:#f3f4f6; color: #111827; }
        .btn-danger { background: #dc2626; color: #fff; }

        .empty { text-align:center; padding:40px; border-radius:16px; background:#fff; border:1px solid #e5e7eb; }

        /* Modal */
        .claim-modal-backdrop { position:fixed; inset:0; display:flex; align-items:center; justify-content:center; background: rgba(243,244,246,0.7); backdrop-filter: blur(8px); z-index:99999; padding:16px; }
        .claim-modal { width:100%; max-width:520px; border-radius:16px; background:#fff; border:1px solid #f3f4f6; box-shadow:0 20px 60px rgba(2,6,23,0.2); overflow:hidden; }
        .claim-modal .content { padding:24px; }
        .form-row { margin-bottom:12px; }
        .form-row label { display:block; margin-bottom:8px; font-weight:600; color:#374151; }
        .form-row input[type="text"], .form-row textarea, .form-row input[type="file"], .form-row select { width:100%; padding:10px 12px; border-radius:12px; border:1px solid #e5e7eb; background:#fbfbfd; }
        .form-row textarea { min-height:160px; resize:none; }
        .modal-actions { display:flex; justify-content:flex-end; gap:8px; padding-top:12px; border-top:1px solid #f3f4f6; }

        /* Small screens */
        @media (max-width: 640px) {
            .head { flex-direction: column; align-items: flex-start; }
            .claim-actions { justify-content: flex-start; }
        }
    </style>

    <!-- En-tête -->
    <div class="avis-header">
        <div class="meta">
            <div class="icon-box" aria-hidden="true">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#fff" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                </svg>
            </div>
            <h1 class="avis-title">Avis des clients</h1>
        </div>
        <p class="avis-subtitle">Consultez et gérez les feedbacks laissés par vos clients</p>
    </div>

    <!-- Messages flash -->
    @if(session()->has('success'))
        <div class="flash success">
            <svg width="18" height="18" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
            <div>{{ session('success') }}</div>
        </div>
    @endif

    @if(session()->has('error'))
        <div class="flash error">
            <svg width="18" height="18" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
            <div>{{ session('error') }}</div>
        </div>
    @endif

    <!-- Filtres -->
    <div class="filters">
        <div class="filters-header">
            <div class="icon-box" aria-hidden="true" style="background:var(--primary);"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#fff" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg></div>
            <h2>Filtres</h2>
        </div>

        <div>
            <div class="form-row">
                <label><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg> <span style="margin-left:8px;">Date</span></label>
                <select wire:model.live="filterDate">
                    <option value="all">Toutes les dates</option>
                    <option value="recent">Plus récents</option>
                    <option value="old">Plus anciens</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Liste des feedbacks -->
    <div class="feedback-list">
        @if(count($feedbacks) > 0)
            @foreach($feedbacks as $feedback)
                <div class="feedback">
                    <div class="head">
                        <div class="user">
                            @if($feedback->client_photo)
                                <img src="{{ asset('storage/' . $feedback->client_photo) }}" alt="{{ $feedback->client_prenom }}" class="avatar" />
                            @else
                                <div class="avatar-placeholder">{{ strtoupper(substr($feedback->client_prenom, 0, 1)) }}{{ strtoupper(substr($feedback->client_nom, 0, 1)) }}</div>
                            @endif

                            <div class="user-info">
                                <h3>{{ $feedback->client_prenom }} {{ $feedback->client_nom }}</h3>
                                <div class="meta-row">
                                    <div class="rating" style="display:flex; align-items:center; gap:4px;">
                                        @php 
                                            $averageNote = $feedback->moyenne ?? 0; 
                                            $rounded = round($averageNote * 2) / 2; 
                                            $full = floor($rounded); 
                                            $hasHalf = ($rounded - $full) == 0.5; 
                                        @endphp
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $full)
                                                <svg width="14" height="14" viewBox="0 0 20 20" class="fill-current" style="color:#f59e0b"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                                            @elseif($hasHalf && $i == $full + 1)
                                                <svg width="14" height="14" viewBox="0 0 20 20">
                                                    <defs>
                                                        <linearGradient id="half-shared-{{ $feedback->idFeedBack }}-{{ $i }}">
                                                            <stop offset="50%" stop-color="#F59E0B"/>
                                                            <stop offset="50%" stop-color="#E5E7EB"/>
                                                        </linearGradient>
                                                    </defs>
                                                    <path fill="url(#half-shared-{{ $feedback->idFeedBack }}-{{ $i }})" d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                                </svg>
                                            @else
                                                <svg width="14" height="14" viewBox="0 0 20 20" class="fill-current" style="color:#e5e7eb"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                                            @endif
                                        @endfor
                                        <span style="margin-left:8px; font-weight:600; color:#ea580c;">{{ number_format($averageNote, 1) }}/5</span>
                                    </div>
                                    <span class="date-pill">{{ \Carbon\Carbon::parse($feedback->dateCreation)->format('d/m/Y') }}</span>
                                </div>
                            </div>
                        </div>

                        @php $isClaimed = DB::table('reclamantions')->where('idFeedback', $feedback->idFeedBack)->exists(); @endphp
                        @if($isClaimed)
                            <span style="display:inline-flex; align-items:center; gap:6px; padding:6px 10px; border-radius:999px; font-size:12px; background:#fee2e2; color:#991b1b; border:1px solid #fecaca;">Réclamé</span>
                        @endif
                    </div>

                    <div class="comment"><p>{{ $feedback->commentaire }}</p></div>

                    @if(!$isClaimed)
                        <div class="claim-actions">
                            <button wire:click="claimFeedback({{ $feedback->idFeedBack }})" type="button" class="btn btn-primary">Réclamer</button>
                        </div>
                    @else
                        <div class="claim-actions"><span style="color:var(--muted); font-style:italic;">Cet avis a été réclamé</span></div>
                    @endif
                </div>
            @endforeach
        @else
            <div class="empty">
                <div style="width:80px; height:80px; border-radius:999px; background:var(--accent); display:inline-flex; align-items:center; justify-content:center; margin-bottom:12px;"><svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg></div>
                <h3 style="font-size:18px; font-weight:600; margin-bottom:8px;">Aucun avis trouvé</h3>
                <p style="color:var(--muted); font-size:15px;">
                    @if($filterDate !== 'all')
                        Essayez de modifier vos filtres pour voir plus de résultats.
                    @else
                        Vous n'avez pas encore reçu d'avis de la part de vos clients.
                    @endif
                </p>
            </div>
        @endif
    </div>

    <!-- Modal de réclamation -->
    @if($showClaimModal)
    <div class="claim-modal-backdrop" wire:click.self="closeClaimModal">
        <div class="claim-modal" @click.stop>
            <div class="content">
                <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:12px;">
                    <div style="display:flex; gap:12px; align-items:center;">
                        <div style="width:48px; height:48px; border-radius:999px; background:#fee2e2; display:flex; align-items:center; justify-content:center;"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#dc2626"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9"></path></svg></div>
                        <div>
                            <h3 style="font-size:18px; font-weight:700; margin:0;">Réclamer cet avis</h3>
                            <p style="color:var(--muted); margin-top:6px;">Signalez un contenu inapproprié ou injuste</p>
                        </div>
                    </div>
                    <button type="button" wire:click="closeClaimModal" style="width:40px; height:40px; border-radius:999px; background:#f3f4f6; border:0; display:flex; align-items:center; justify-content:center;">✕</button>
                </div>

                <form wire:submit.prevent="submitClaim">
                    <div class="form-row">
                        <label>Sujet de la réclamation</label>
                        <input type="text" wire:model.defer="claimSubject" placeholder="Ex: Commentaire inapproprié, Note injustifiée..." required />
                        @error('claimSubject')<div style="color:#dc2626; font-size:13px; margin-top:6px;">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-row">
                        <label>Description détaillée</label>
                        <textarea wire:model.defer="claimDescription" required></textarea>
                        @error('claimDescription')<div style="color:#dc2626; font-size:13px; margin-top:6px;">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-row">
                        <label>Pièces jointes (optionnel)</label>
                        <input type="file" wire:model.defer="claimProof" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx,.zip" />
                        @error('claimProof')<div style="color:#dc2626; font-size:13px; margin-top:6px;">{{ $message }}</div>@enderror
                        <div style="font-size:12px; color:var(--muted); margin-top:6px;">Formats acceptés : PDF, JPG, PNG, DOC, DOCX, ZIP (max 10MB)</div>
                    </div>

                    <div class="modal-actions">
                        <button type="button" wire:click="closeClaimModal" class="btn btn-muted">Annuler</button>
                        <button type="submit" class="btn btn-danger">Soumettre</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
</div>