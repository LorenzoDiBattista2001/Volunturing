{extends file="main.tpl"}

{block name="title"}Volunturing - Eventi Programmati{/block}

{block name="head"}
    <link rel="stylesheet" href="{$css_path}/scheduledEvents.css"/>
{/block}

{block name="body"}
  <div class="container my-5 flex-grow-1">
    <div class="row justify-content-center">

      <section class="col-lg-8">

        <h1 class="h1 fw-bold mb-1 text-dark text-center">I nostri Eventi Programmati</h1>
        <p class="text-muted text-center mb-3">Seleziona un evento per scoprirne i dettagli e inviare la tua candidatura</p>

        <div class="row row-cols-1 g-3">
          {foreach $scheduledEvents as $event}
            <div class="col">
              <div class="card h-100 border-0 shadow-sm hover-lift">
                <div class="card-body p-4">
                  <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="badge border {if $event->getFieldOfAction()->value == 'Tutela ambientale'} 
                                                bg-success text-white border-success-subtle
                                              {elseif $event->getFieldOfAction()->value == 'Supporto logistico'} 
                                                bg-info text-dark border-info-subtle
                                              {elseif $event->getFieldOfAction()->value == 'Raccolta fondi'} 
                                                bg-danger text-white border-danger-subtle
                                              {elseif $event->getFieldOfAction()->value == 'Colletta alimentare'} 
                                                bg-warning text-dark border-warning-subtle
                                              {/if}
                                              rounded-pill">
                          {$event->getFieldOfAction()->value}</span>
                    <small class="text-muted"><i class="bi bi-calendar3 me-1"></i> {$event->getDateAndTime()->format('d-m-Y')}</small>
                  </div>
                  <h5 class="card-title fw-bold">{$event->getTitle()}</h5>
                  <p class="card-text text-muted small mb-3">{$event->getPlace()}</p>
                  <div class="d-flex align-items-center">
                        <span class="text-warning fw-bold small">Dettagli &rarr;</span>
                        <a href="/events/detail/{$event->getEventId()}" class="stretched-link"></a>
                  </div>
                </div>
              </div>
            </div>
          {/foreach}     
        </div>
      </section>
    </div>
  </div>
{/block}