{extends file="main.tpl"}

{block name="title"}Volunturing - Lista Candidature{/block}

{block name="head"}
    <link rel="stylesheet" href="{$css_path}/applicationsList.css"/>
{/block}

{block name="body"}
    <main class="container my-5 flex-grow-1">
    
      <!-- EVENT DETAILS -->
      <div class="d-flex justify-content-center align-items-end mb-4">
        <div>
          <h1 class="h2 fw-bold mb-1">{$event->getTitle()}</h1>
          <p class="text-muted text-center mb-0"><i class="bi bi-calendar-event me-2"></i>Data evento: {$event->getDateAndTime()->format('d-m-Y')}</p>
        </div>
      </div>

      <div class="row justify-content-center mb-5">

        <div class="col-lg-4">
          <div class="card border-0 shadow-sm h-100 p-4">
            <h5 class="fw-bold mb-4">Stato Riempimento</h5>
            
            <div class="mb-4">
              <div class="d-flex justify-content-between mb-2">
                <span class="small fw-bold text-muted">Candidature approvate</span>
                <span class="small fw-bold">{$event->getAcceptedApplicationsNumber()}/{$event->getMaxVolunteerNumber()}</span>
              </div>
              <div class="progress mb-2">
                <div class="progress-bar bg-success" role="progressbar" style="width: {$event->getProgress()}" aria-valuenow="{$event->getAcceptedApplicationsNumber()}" aria-valuemin="0" aria-valuemax="{$event->getMaxVolunteerNumber()}"></div>
              </div>
              <p class="small text-muted">Obiettivo: {$event->getRequestedVolunteerNumber()}</p>
            </div>

            <div class="row g-2">
              <div class="col-6">
                <div class="p-3 bg-light rounded text-center">
                  <div class="h3 fw-bold mb-0">{$event->getPendingApplicationsNumber()}</div>
                  <div class="small text-muted">In Attesa</div>
                </div>
              </div>
              <div class="col-6">
                <div class="p-3 bg-light rounded text-center">
                  <div class="h3 fw-bold mb-0 text-success">{$event->getEmptySlotsNumber()}</div>
                  <div class="small text-muted">Posti Liberi</div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-4">
          <div class="card border-0 shadow-sm h-100 p-4">
            <div class="row row-cols-1 h-100">
              <div class="col border-md-end pe-md-4">
                <h5 class="fw-bold mb-3">Requisiti richiesti</h5>
                <p class="text-secondary lead">{if $event->getCandidateRequirements() == null}                                                           
                                                  nessuno                                                          
                                                {else}                                                            
                                                  {$event->getCandidateRequirements()}                                                            
                                                {/if}</p>
              </div>
              <div class="col mt-auto">
                <div class="alert alert-info border-0 py-2 small">
                  <i class="bi bi-info-circle-fill me-2"></i>Le candidature sono ordinate per data di invio, ed in tale ordine dovrebbero essere valutate.
                </div>
              </div>
              
            </div>
          </div>
        </div>

        <div class="col-lg-8 mt-5">
            <div class="card border-0 shadow-sm overflow-hidden">
                <div class="card-header bg-white p-4 border-0 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0">Candidature da esaminare</h5>
                </div>
        
                <div class="card-body p-0">
                  <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">

                      <thead class="bg-light text-muted small text-uppercase">
                        <tr>
                          <th class="ps-4 py-3">Volontario</th>
                          <th>Inviata il</th>
                          <th class="pe-4 text-end">Azione</th>
                        </tr>
                      </thead>

                      <tbody>
                      {foreach $applications as $application}
                        <tr class="app-row">
                          <td class="ps-4 py-3">
                            <div class="d-flex align-items-center">
                              <div>
                                <div class="fw-bold">{$application->getCandidate()->getFirstName()} {$application->getCandidate()->getLastName()}</div>
                                <div class="small text-muted">Et&agrave;: {$application->getCandidate()->calculateAge()}</div>
                              </div>
                            </div>
                          </td>
                          <td class="small text-muted">{$application->getSubmittedDateTime()->format('d-m-Y')}, {$application->getSubmittedDateTime()->format('H:i')}</td>
                  
                          <td class="pe-4 text-end">
                            <a href="/admin/applications/select/{$application->getEventId()}/{$application->getUserId()}" class="btn btn-warning btn-sm fw-bold px-3">
                              VALUTA <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                          </td>
                        </tr>
                      {/foreach}
                      </tbody>
                    </table>
                  </div>
          
                </div>
              </div>
        </div>
      </div>
    </main>
{/block}