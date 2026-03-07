{extends file="main.tpl"}

{block name="title"}Volunturing - Dettagli Evento{/block}

{block name="head"}
    <link rel="stylesheet" href="public/css/eventDetails.css">
{/block}
{block name="body"}

    <main class="container my-5 flex-grow-1">
      <div class="row justify-content-center">
        <div class="col-lg-10">
          <div class="card border-0 shadow-lg p-4 p-md-5">
            <div class="text-center mb-5">
              {if $event->getFieldOfAction()->value == 'Tutela ambientale'}
                <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3 py-2 mb-3 fw-bold">
                  <i class="bi bi-tree me-2"></i>TUTELA AMBIENTALE
                </span>
              {elseif $event->getFieldOfAction()->value == 'Supporto logistico'}
                <span class="badge bg-info-subtle text-info border border-info-subtle rounded-pill px-3 py-2 mb-3 fw-bold">
                  <i class="bi bi-truck me-2"></i>SUPPORTO LOGISTICO
                </span>
              {elseif $event->getFieldOfAction()->value == 'Raccolta fondi'}
                <span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill px-3 py-2 mb-3 fw-bold">
                  <i class="bi bi-heart-fill me-2"></i>RACCOLTA FONDI
                </span>
              {elseif $event->getFieldOfAction()->value == 'Colletta alimentare'}
                <span class="badge bg-warning-subtle text-warning border border-warning-subtle rounded-pill px-3 py-2 mb-3 fw-bold">
                  <i class="bi bi-fork-knife me-2"></i>COLLETTA ALIMENTARE
                </span>
              {/if}
              <h1 class="display-5 fw-bold text-dark">{$event->getTitle()}</h1>
            </div>

            <div class="row g-5">
             
              <div class="col-md-7">
                <h4 class="fw-bold mb-4 border-bottom pb-2">Informazioni</h4>
                
                <div class="row row-cols-1 mb-3">
                  <div class="col">
                    <div class="info-label d-inline">Luogo: </div>
                    <div class="info-value d-inline"></i>{$event->getPlace()}</div>
                  </div>
                  <div class="col">
                    <div class="info-label d-inline">Responsabile: </div>
                    <div class="info-value d-inline"><i class="bi bi-person-circle me-2"></i>{$event->getCoordinator()}</div>
                  </div>
                  <div class="col">
                    <div class="info-label d-inline">Numero Atteso di Volontari: </div>
                    <div class="info-value d-inline">{$event->getRequestedVolunteerNumber()}<i class="bi bi-people-fill ms-2"></i></div>
                  </div>
                </div>
                <div class="row justify-content-start">
                    <div class="info-label">Requisiti: </div>
                    <div class="info-value"><i class="bi bi-check2-square me-2"></i>
                    {if $event->getCandidateRequirements() == null}                                                            
                      nessuno                                                           
                    {else}                                                            
                      {$event->getCandidateRequirements()}                                                            
                    {/if}</div>
                </div>
              </div>

              <div class="col-md-5">
                <div class="card bg-light border-0 p-4">
                  <div class="row flex-column">
                    <div class="col-sm-6 mb-3">
                    <div class="info-label">Data</div>
                    <div class="info-value"><i class="bi bi-calendar-event me-2"></i>{$event->getDateAndTime()->format('Y-m-d')}</div>
                  </div>
                  <div class="col-sm-6 mb-3">
                    <div class="info-label">Ora</div>
                    <div class="info-value"><i class="bi bi-hourglass me-2"></i>{$event->getDateAndTime()->format('H:i:s')}</div>
                  </div>
                  </div>

                  <hr>

                  <button class="btn btn-submit-application text-white w-100 py-3 fw-bold fs-5 shadow-sm">
                    <i class="bi bi-send-fill me-2"></i>CANDIDATI
                  </button>
                </div>
              </div>
            </div>
            {if $alreadyApplied}
              <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                <strong>ATTENZIONE:</strong> Ti sei gi&agrave; candidato per questo evento!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
            {/if}
            {if $eventFull}
              <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                <strong>CI DISPIACE:</strong> Non ci sono più posti disponibili!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
            {/if}
            <div class="row row-cols-1">
              <div class="mt-5">
                  <h4 class="fw-bold mb-3">Descrizione</h4>
                  <div class="text-secondary lh-lg">
                    <p>
                      Lorem ipsum dolor sit amet consectetur adipisicing elit. Molestiae nemo eos incidunt repudiandae beatae odit dignissimos rerum distinctio tenetur cumque.
                    </p>
                  </div>
                </div>
            </div>

          </div>
        </div>
      </div>
    </main>
{/block}
