{extends file="main.tpl"}

{block name="title"}Volunturing - Dettaglio Candidatura{/block}

{block name="head"}
    <link rel="stylesheet" href="{$css_path}/applicationDetails.css"/>
{/block}

{block name="body"}
    <main class="container my-5 flex-grow-1">

      <div class="row g-4">
        
        <!-- VOLUNTEER'S DATA AND MESSAGE -->
        <div class="col-lg-8">
          <div class="card border-0 shadow-sm p-4 p-md-5 mb-4">
            <h4 class="fw-bold mb-4"><i class="bi bi-person-lines-fill me-2 text-warning"></i>Profilo del Volontario</h4>
            
            <div class="row g-4 mb-5">
              <div class="col-sm-6">
                <div class="info-label">Nome e Cognome</div>
                <div class="info-value">{$candidate->getFirstName()} {$candidate->getLastName()}</div>
              </div>
              <div class="col-sm-6">
                <div class="info-label">Codice Fiscale</div>
                <div class="info-value text-uppercase">{$candidate->getTaxCode()}</div>
              </div>
              <div class="col-sm-6">
                <div class="info-label">Contatti</div>
                <div class="info-value">
                  <div><i class="bi bi-telephone me-2"></i> +{$candidate->getTelephoneNumber()}</div>
                  <div><i class="bi bi-envelope me-2"></i> {$candidate->getEmail()}</div>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="info-label">Et&agrave;</div>
                <div class="info-value">{$candidate->calculateAge()} anni</div>
              </div>
            </div>

            <h5 class="fw-bold mb-3 border-bottom pb-2">Biografia / Descrizione</h5>
            <p class="text-secondary small mb-5">
              {if $candidate->getDescription() == null}
                L'utente non ha condiviso informazioni su di s&egrave;
              {else}
                {$candidate->getDescription()}
              {/if}
            </p>

            <h5 class="fw-bold mb-3 border-bottom pb-2">Messaggio per questo evento</h5>
            <div class="bg-light p-4 rounded-3 border-start border-4 border-warning italic">
              <p class="mb-0 text-dark">
              {if $application->getMessage() == null}
                Nessun messaggio da parte del candidato
              {else}
                {$application->getMessage()}
              {/if}
              </p>
            </div>
          </div>
        </div>

        <!-- ACTIONS -->
        <aside class="col-lg-4">
          <div class="card border-0 shadow-sm p-4 sticky-top" style="top: 100px;">
            <h5 class="fw-bold mb-4">Azione Richiesta</h5>
            
            <form action="/admin/applications/reject/{$event->getEventId()}/{$candidate->getUserId()}" method="POST">
              <div class="mb-4">
                <label for="reasonForRejection" class="form-label small fw-bold text-muted">Motivazione Rifiuto (Opzionale)</label>
                <textarea class="form-control bg-light border-0" id="reasonForRejection" name="reasonForRejection" rows="3" placeholder="Inserisci qui il motivo se decidi di rifiutare..."></textarea>
              </div>

              <div class="d-grid gap-3">
                <a href="/admin/applications/approve/{$event->getEventId()}/{$candidate->getUserId()}" class="btn btn-success py-3 fw-bold shadow-sm">
                  <i class="bi bi-check-circle me-2"></i>APPROVA CANDIDATURA
                </a>
                <button type="submit" class="btn btn-outline-danger py-2 fw-bold">
                  <i class="bi bi-x-circle me-2"></i>RIFIUTA
                </button>
              </div>
            </form>

            <div class="mt-4 pt-4 border-top text-center">
                <p class="small text-muted mb-0">Candidatura riferita a:</p>
                <div class="fw-bold text-dark">{$event->getTitle()}</div>
            </div>
          </div>
        </aside>

      </div>
    </main>
{/block}