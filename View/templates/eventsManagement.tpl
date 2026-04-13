{extends file="main.tpl"}

{block name="title"}Volunturing - Gestione Eventi{/block}

{block name="head"}
    <link rel="stylesheet" href="{$css_path}/eventsManagement.css"/>
{/block}

{block name="body"}
    <div class="container my-5 flex-grow-1">
        <div class="row g-4">
            <aside class="col-lg-3">
                <div class="card border-0 shadow-sm p-3">
                    <h5 class="fw-bold mb-3"><i class="bi bi-filter-left me-2"></i>Filtri</h5>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Area di Intervento</label>
                        <select class="form-select form-select-sm">
                            <option>Tutte le aree</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Periodo</label>
                        <input type="date" class="form-control form-control-sm mb-2">
                        <input type="date" class="form-control form-control-sm">
                    </div>
                    <button class="btn btn-warning btn-sm w-100 fw-bold">Applica</button>
                </div>
            </aside>

            <section class="col-lg-6">

              <div class="d-flex justify-content-center mb-4">
                <a href="/admin/events/add" class="d-flex align-items-center justify-content-center btn btn-primary w-50" id="add"><span class="fw-bold">AGGIUNGI EVENTO</span><i class="bi bi-plus-circle ms-2"></i></a>
              </div>

              <div class="row row-cols-1 g-4">
              {foreach $events as $event}
                  <div class="col">
                    <div class="card h-100 border shadow-sm hover-lift">
                      <div class="card-header d-flex justify-content-center">
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
                      </div>
                      <div class="card-body">
                      <div class="d-flex mb-3 justify-content-between align-items-center">
                        <h5 class="card-title fw-bold text-dark">{$event->getTitle()}</h5>
                          <small class="text-muted fw-semibold">
                            <i class="bi bi-calendar3 me-1"></i>{$event->getDateAndTime()->format('Y-m-d')}</small>
                
                      </div>
                      <div class="d-flex align-items-end mb-2">
                        <a href="/admin/events/select/{$event->getEventId()}" class="btn btn-outline-primary px-3 me-auto btn-sm fw-bold stretched-link"><i class="bi bi-pencil-square me-1"></i>
                          Ispeziona
                        </a>
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