{extends file="main.tpl"}

{block name="title"}Volunturing - Dettaglio Candidatura{/block}

{block name="head"}
    <link rel="stylesheet" href="{$css_path}/applicationPanel.css"/>
{/block}

{block name="body"}
    <main class="container my-5 flex-grow-1">
      
      <div class="row g-4">
        
        <div class="col-lg-8">
          <div class="card border-0 shadow-sm p-4 p-md-5 mb-4">
            <div class="d-flex align-items-center mb-4">
              <div class="bg-warning-subtle p-3 rounded-3 me-3">
                <i class="bi bi-calendar-check text-warning fs-3"></i>
              </div>
              <h3 class="fw-bold mb-0">Dettagli Candidatura</h3>
            </div>
            
            <div class="row g-4 mb-5">
              <div class="col-12">
                <div class="info-label">Evento</div>
                <div class="info-value fs-4">{$event->getTitle()}</div>
              </div>
              <div class="col-md-6">
                <div class="info-label">Data e Ora</div>
                <div class="info-value"><i class="bi bi-clock me-2"></i>{$event->getDateAndTime()->format('d-m-Y')} - {$event->getDateAndTime()->format('H:i')}</div>
              </div>
              <div class="col-md-6">
                <div class="info-label">Luogo</div>
                <div class="info-value"><i class="bi bi-geo-alt me-2"></i>{$event->getPlace()}</div>
              </div>
            </div>

            <h5 class="fw-bold mb-3 border-bottom pb-2">Il tuo messaggio motivazionale</h5>
            {if $application->getMessage() == null}                                                            
              <p class="text-muted small italic">Nessun messaggio motivazionale inserito per questa candidatura.</p>                                                           
            {else}                                                            
              <div class="p-4 rounded-3 motivation-box">
                <p class="mb-0 text-dark">
                  "{$application->getMessage()}"
                </p>
              </div>                                                          
            {/if}
          </div>
        </div>

        <aside class="col-lg-4">
          <div class="card border-0 shadow-sm p-4 status-card sticky-top" style="top: 100px;">
            <div class="d-flex justify-content-between align-items-start mb-4">
              <h5 class="fw-bold mb-0">Stato Candidatura</h5>
            </div>

            <div class="mb-4">
              <div class="info-label">Inviata il</div>
              <div class="info-value small">{$application->getSubmittedDateTime()->format('d-m-Y')} alle {$application->getSubmittedDateTime()->format('H:i')}</div>
            </div>

            <div class="mb-4">
                <div class="info-label">Stato Attuale</div>
                <div class="info-value small">{$application->getState()->value}</div>
            </div>

            {if $application->getState()->value == 'Rifiutata'}
            <div class="rejection-box p-3 rounded-3 mb-4">
                <div class="small fw-bold text-danger mb-1 text-uppercase">Motivazione del rifiuto:</div>
                <p class="small mb-0 text-dark italic">"{$application->getReasonForRejection()}"</p>
            </div>
            {/if}

            <div class="d-grid gap-3">
              {if $application->getState()->value != 'Rifiutata' && $application->getState()->value != 'Ritirata'}
              <button class="btn btn-outline-danger py-2 fw-bold btn-withdraw" data-bs-toggle="modal" data-bs-target="#withdrawModal">
                <i class="bi bi-x-circle me-2"></i>RITIRA CANDIDATURA
              </button>
              {/if}
              <a href="/account/personal" class="btn btn-light py-2 small border text-muted">
                Torna all'area personale
              </a>
            </div>

            <div class="mt-4 pt-3 border-top">
                <p class="text-muted" style="font-size: 0.7rem; line-height: 1.2;">
                    <i class="bi bi-info-circle me-1"></i> 
                    Attenzione: il ritiro della candidatura &egrave; un'operazione irreversibile.
                </p>
            </div>
          </div>
        </aside>

      </div>
    </main>

    {if $application->getState()->value != 'Rifiutata' && $application->getState()->value != 'Ritirata'}
    <div class="modal fade" id="withdrawModal" tabindex="-1" aria-labelledby="withdrawModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
          <div class="modal-header bg-danger text-white border-0">
            <h5 class="modal-title fw-bold" id="withdrawModalLabel">Sei sicuro di voler procedere?</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body p-4">
            <div class="text-center mb-4">
                <i class="bi bi-exclamation-triangle text-danger display-4"></i>
            </div>
            <p class="mb-3 text-center">Stai per ritirare la tua candidatura per l'evento <strong>"{$event->getTitle()}"</strong>.</p>
            <div class="alert alert-danger border-0 small">
                <i class="bi bi-shield-exclamation me-2"></i>
                <strong>Attenzione:</strong> Se decidi di proseguire, non potrai più candidarti per questo specifico evento in futuro.
            </div>
          </div>
          <div class="modal-footer border-0 bg-light">
            <button type="button" class="btn btn-secondary fw-bold px-4" data-bs-dismiss="modal">Annulla</button>
            <form action="/applications/withdraw/{$application->getUserId()}/{$application->getEventId()}" method="POST">
                <button type="submit" class="btn btn-danger fw-bold px-4">Conferma Ritiro</button>
            </form>
          </div>
        </div>
      </div>
    </div>
    {/if}
{/block}

{block name="script"}
  <script src="formFeedback.js"></script>
{/block}