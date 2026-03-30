{extends file="main.tpl"}

{block name="title"}Volunturing - Valuta Candidature{/block}

{block name="head"}
    <link rel="stylesheet" href="{$css_path}/applicationsManagement.css"/>
{/block}

{block name="body"}
    <main class="container my-5 flex-grow-1">
      <div class="row g-4 justify-content-center">
  
        <!-- EVENTS LIST -->
        <section class="col-lg-9">

          <h1 class="h3 fw-bold mb-1 text-dark">Valutazione Candidature</h1>
          <p class="text-muted mb-3">Seleziona un evento di cui esaminare le candidature</p>

          <div class="d-flex flex-column gap-3">

            <!-- EVENT -->
            {foreach $events as $event}
            <div class="card border-0 shadow-sm hover-lift overflow-hidden">
              <div class="row g-0">
                <div class="col-md-5 p-4 border-md-end">
                  <div class="d-flex align-items-center mb-2">
                    <span class="badge border {if $event->getFieldOfAction()->value == 'Tutela ambientale'} 
                                            bg-success-subtle text-success border-success-subtle
                                          {elseif $event->getFieldOfAction()->value == 'Supporto logistico'} 
                                            bg-info-subtle text-info border-info-subtle
                                          {elseif $event->getFieldOfAction()->value == 'Raccolta fondi'} 
                                            bg-danger-subtle text-danger border-danger-subtle
                                          {elseif $event->getFieldOfAction()->value == 'Colletta alimentare'} 
                                            bg-warning-subtle text-warning border-warning-subtle
                                          {/if}
                                          rounded-pill me-2">
                          {$event->getFieldOfAction()->value}</span>
                    <small class="text-muted fw-bold"><i class="bi bi-calendar3 me-1"></i> {$event->getDateAndTime()->format('Y-m-d')}</small>
                  </div>
                  <h5 class="fw-bold mb-1">{$event->getTitle()}</h5>
                  <p class="small text-muted mb-0"><i class="bi bi-geo-alt me-1"></i> {$event->getPlace()}</p>
                </div>
                
                <div class="col-md-5 bg-light-subtle p-4">
                  <div class="row g-2 text-center">
                    <div class="col-4">
                      <div class="h4 fw-bold mb-0 text-warning">{$event->getPendingApplicationsNumber()}</div>
                      <div class="text-uppercase text-muted" style="font-size: 0.65rem; font-weight: 800;">In Attesa</div>
                    </div>
                    <div class="col-4 border-start border-end">
                      <div class="h4 fw-bold mb-0">{$event->getAcceptedApplicationsNumber()}/{$event->getMaxVolunteerNumber()}</div>
                      <div class="text-uppercase text-muted" style="font-size: 0.65rem; font-weight: 800;">Candidature Accettate</div>
                    </div>
                    <div class="col-4">
                      <div class="h4 fw-bold mb-0 text-primary">{$event->getRequestedVolunteerNumber()}</div>
                      <div class="text-uppercase text-muted" style="font-size: 0.65rem; font-weight: 800;">Volontari Attesi</div>
                    </div>
                  </div>

                  <!-- PROGRESS BAR -->
                  <div class="progress mt-3" style="height: 6px;">
                    <div class="progress-bar bg-success" role="progressbar" style="width: {$event->getProgress()}%" aria-valuenow="{$event->getProgress()}" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                </div>

                <div class="col-md-2 d-flex align-items-center justify-content-center p-3">
                  <a href="/admin/applications/process" class="btn btn-warning fw-bold w-100 py-3 shadow-sm">
                    VALUTA <i class="bi bi-chevron-right ms-1"></i>
                  </a>
                </div>
              </div>
            </div>
            {/foreach}

          </div>
        </section>

      </div>
    </main>
{/block}