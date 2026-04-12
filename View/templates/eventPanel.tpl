{extends file="main.tpl"}

{block name="title"}Volunturing - Dettagli Evento{/block}

{block name="head"}
    <link rel="stylesheet" href="{$css_path}/eventPanel.css">
{/block}

{block name="body"}
    <main class="container my-5 flex-grow-1">

      <div class="row g-4">

        <div class="col-lg-8">
          <div class="card border-0 shadow-sm p-4 p-md-5 h-100">
            <div class="d-flex justify-content-between align-items-start mb-4">
              <div>
                <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill mb-2 status-badge">
                  <i class="bi bi-info-circle me-1"></i> {if $isScheduled}EVENTO PROGRAMMATO{else}EVENTO CONCLUSO{/if}
                </span>
                <h1 class="fw-bold text-dark">{$event->getTitle()}</h1>
              </div>
            </div>

            <div class="row mt-4">
              <div class="col-md-6">
                <div class="info-label">Area di Intervento</div>
                <div class="info-value"><i class="bi bi-tag-fill me-2 text-primary"></i>{$event->getFieldOfAction()->value}</div>
                
                <div class="info-label">Data e Ora</div>
                <div class="info-value"><i class="bi bi-calendar3 me-2"></i>{$event->getDateAndTime()->format('d-m-Y')} alle {$event->getDateAndTime()->format('H:i')}</div>
              
              </div>
              <div class="col-md-6">
                <div class="info-label">Responsabile</div>
                <div class="info-value"><i class="bi bi-person-badge me-2"></i>{$event->getCoordinator()}</div>
                
                <div class="info-label">Luogo</div>
                <div class="info-value"><i class="bi bi-geo-alt-fill me-2"></i>{$event->getPlace()}</div>
              </div>
            </div>

            <hr class="my-4 text-secondary opacity-25">

            <h5 class="fw-bold mb-3">Descrizione e Requisiti</h5>
            <p class="text-muted lh-base">
              {$event->getDescription()}
              <br><br>
              <strong>Requisiti:</strong> {if $event->getCandidateRequirements() == null}                                                            
                                            nessuno                                                           
                                          {else}                                                            
                                            {$event->getCandidateRequirements()}                                                            
                                          {/if}
            </p>
          </div>
        </div>

        <div class="col-lg-4">
          <div class="card admin-sidebar-card shadow-sm p-4 mb-4">
            <h5 class="fw-bold mb-4"><i class="bi bi-shield-lock me-2"></i>Pannello Gestione</h5>
            
            <div class="bg-light rounded p-3 mb-4">
              <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="small fw-bold text-muted text-uppercase">{if $isScheduled}Iscritti Attuali{else}Partecipanti{/if}</span>
                <span class="badge bg-dark">{$event->getAcceptedApplicationsNumber()} / {$event->getMaxVolunteerNumber()}</span>
              </div>
              <div class="progress" style="height: 8px;">
                <div class="progress-bar bg-success" role="progressbar" style="width: {$event->getProgress()}%" aria-valuenow="{$event->getProgress()}" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
            </div>

            <div class="d-grid gap-3">

              <a href="#" class="btn btn-outline-primary btn-admin-action">
                <i class="bi bi-people-fill me-2"></i> Visualizza Utenti Iscritti
              </a>

              <hr class="my-2">

              <button class="btn btn-delete btn-admin-action" data-bs-toggle="modal" data-bs-target="#deleteModal">
                <i class="bi bi-trash3-fill me-2"></i> Elimina Evento
              </button>
            </div>
          </div>
          {if $isScheduled}
          <div class="alert alert-warning border-0 shadow-sm small" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            <strong>Nota:</strong> L'eliminazione di un evento programmato invierà automaticamente una notifica email a tutti i candidati.
          </div>
          {/if}
        </div>
      </div>
    </main>

    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
          <div class="modal-header bg-danger text-white">
            <h5 class="modal-title fw-bold" id="deleteModalLabel">Conferma Eliminazione</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form action="/admin/events/delete/{$event->getEventId()}" method="POST" class="needs-validation" novalidate>
            <div class="modal-body p-4">
              <p>Stai per eliminare l'evento {if $isScheduled}programmato{else}concluso{/if} <strong>{$event->getTitle()}</strong>.</p>
              
              {if $isScheduled}
              <div class="mb-3">
                <label for="reasonForDeletion" class="form-label fw-bold">Motivazione dell'annullamento (obbligatoria)</label>
                <textarea class="form-control" id="reasonForDeletion" name="reasonForDeletion" rows="3" required></textarea>
                <div class="form-text text-danger">
                  Confermando l'eliminazione, un'email di notifica contenente la motivazione inserita sarà recapitata a tutti i volontari 
                  attualmente iscritti o con candidature in attesa di valutazione.
                </div>
              </div>
              {/if}

              <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" value="" id="confirmCheck" required>
                <label class="form-check-label small" for="confirmCheck">
                  Comprendo che questa operazione è irreversibile.
                </label>
              </div>
            </div>
            
            <div class="modal-footer bg-light">
              <button type="button" class="btn btn-secondary fw-bold" data-bs-dismiss="modal">Annulla</button>
              <button type="submit" class="btn btn-danger fw-bold">Conferma ed Elimina</button>
            </div>
          </form>
        </div>
      </div>
    </div>
{/block}

{block name="script"}
  <script src="{$js_path}/formFeedback.js"></script>
{/block}