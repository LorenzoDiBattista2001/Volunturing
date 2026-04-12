{extends file="main.tpl"}

{block name="title"}Volunturing - Lista Volontari{/block}

{block name="head"}
    <link rel="stylesheet" href="{$css_path}/volunteersList.css"/>
{/block}

{block name="body"}
  <main class="container my-5 flex-grow-1">

      <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end mb-4 gap-3">
        <div>
          <span class="badge bg-success-subtle text-success border border-success-subtle mb-2">LISTA PARTECIPANTI</span>
          <h1 class="h2 fw-bold mb-1">{$event->getTitle()}</h1>
          <p class="text-muted mb-0"><i class="bi bi-calendar-event me-2"></i>Data evento: {$event->getDateAndTime()->format('d-m-Y')}</p>
        </div>
        <div class="d-flex gap-2 no-print">
          <button onclick="window.print()" class="btn btn-outline-dark fw-bold btn-print-action">
            <i class="bi bi-printer me-2"></i>STAMPA LISTA
          </button>
          <a href="/admin/events/select/{$event->getEventId()}" class="btn btn-warning fw-bold text-white">
            <i class="bi bi-arrow-left me-2"></i>TORNA AL DETTAGLIO
          </a>
        </div>
      </div>

      <div class="row g-4">

        <div class="col-12">
            <div class="card border-0 shadow-sm p-3">
                <div class="row text-center g-2">
                    <div class="col-md-4 border-md-end">
                        <div class="small text-muted text-uppercase fw-bold">Totale Iscritti</div>
                        <div class="h4 fw-bold text-success mb-0">{$event->getAcceptedApplicationsNumber()} / {$event->getMaxVolunteerNumber()}</div>
                    </div>
                    <div class="col-md-4 border-md-end">
                        <div class="small text-muted text-uppercase fw-bold">Posti Rimanenti</div>
                        <div class="h4 fw-bold text-brand mb-0">{$event->getEmptySlotsNumber()}</div>
                    </div>
                    <div class="col-md-4">
                        <div class="small text-muted text-uppercase fw-bold">Stato Target</div>
                        <div class="h4 fw-bold text-primary mb-0">{$event->getProgress()}%</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
          <div class="card border-0 shadow-sm overflow-hidden">
            <div class="card-header bg-white p-4 border-0">
              <h5 class="fw-bold mb-0">Elenco Volontari Approvati</h5>
            </div>
            <div class="card-body p-0">
              <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                  <thead class="bg-light text-muted small text-uppercase">
                    <tr>
                      <th class="ps-4 py-3">Volontario</th>
                      <th>Contatti</th>
                      <th class="text-center">Codice Fiscale</th>
                      <th class="pe-4 text-end no-print">Profilo</th>
                    </tr>
                  </thead>
                  <tbody>
                  {foreach $participants as $participant}
                    <tr class="app-row">
                      <td class="ps-4 py-3">
                        <div>
                          <div class="fw-bold">{$participant->getFirstName()} {$participant->getLastName()}</div>
                          <div class="small text-muted text-truncate" style="max-width: 150px;">Et&agrave;: {$participant->calculateAge()}</div>
                        </div>
                      </td>
                      <td>
                        <div class="small"><i class="bi bi-envelope me-2"></i>{$participant->getEmail()}</div>
                        <div class="small"><i class="bi bi-telephone me-2"></i>{$participant->getTelephoneNumber()}</div>
                      </td>
                      <td class="text-center small text-muted">{$participant->getTaxCode()}</td>
                      <td class="pe-4 text-end no-print">
                        <a href="#" class="btn btn-light btn-sm border">
                          <i class="bi bi-eye"></i>
                        </a>
                      </td>
                    </tr>

                  {/foreach}
                  </tbody>
                </table>
              </div>

            </div>
          </div>

          <div class="d-none d-print-block mt-4 small text-muted border-top pt-2">
            Documento generato automaticamente da Volunturing. Lista volontari iscritti per l'evento "{$event->getTitle()}".
          </div>
        </div>
      </div>
    </main>
{/block}