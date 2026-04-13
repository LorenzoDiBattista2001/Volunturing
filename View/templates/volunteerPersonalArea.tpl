{extends file="main.tpl"}

{block name="title"}Volunturing - Area Personale{/block}

{block name="head"}
    <link rel="stylesheet" href="{$css_path}/volunteerPersonalArea.css"/>
{/block}

{block name="body"}
<main class="container my-5 flex-grow-1">
      <div class="row justify-content-center">
        
        <div class="col-lg-9">
          <h2 class="h4 fw-bold mb-4">Benvenuto, {$volunteer->getFirstName()} {$volunteer->getLastName()}</h2>

          <div class="row g-3 mb-5">
            <div class="col-sm-6 col-md-3">
              <div class="card h-100 border-0 shadow-sm p-3 hover-lift text-center">
                <div class="action-card-icon bg-warning-subtle mx-auto">
                  <i class="bi bi-search text-warning fs-4"></i>
                </div>
                <h6 class="fw-bold small mb-0">ESPLORA EVENTI</h6>
                <a href="/events/explore" class="stretched-link"></a>
              </div>
            </div>
            <div class="col-sm-6 col-md-3">
              <div class="card h-100 border-0 shadow-sm p-3 hover-lift text-center">
                <div class="action-card-icon bg-danger-subtle mx-auto">
                  <i class="bi bi-heart-fill text-danger fs-4"></i>
                </div>
                <h6 class="fw-bold small mb-0">DONA ORA</h6>
                <a href="/donation/start" class="stretched-link"></a>
              </div>
            </div>
            <div class="col-sm-6 col-md-3">
              <div class="card h-100 border-0 shadow-sm p-3 hover-lift text-center">
                <div class="action-card-icon bg-success-subtle mx-auto">
                  <i class="bi bi-chat-left-dots-fill text-success fs-4"></i>
                </div>
                <h6 class="fw-bold small mb-0">RECENSISCI</h6>
                <a href="#" class="stretched-link"></a>
              </div>
            </div>
            <div class="col-sm-6 col-md-3">
              <div class="card h-100 border-0 shadow-sm p-3 hover-lift text-center">
                <div class="action-card-icon bg-info-subtle mx-auto">
                  <i class="bi bi-person-circle text-info fs-4"></i>
                </div>
                <h6 class="fw-bold small mb-0">GESTISCI ACCOUNT</h6>
                <a href="#" class="stretched-link"></a>
              </div>
            </div>
          </div>

          <div class="card border-0 shadow-sm">
            <div class="card-header bg-white p-4 border-0">
              <h5 class="fw-bold mb-0">Le Tue Candidature</h5>
            </div>
            <div class="card-body border-top border-2 border-warning p-0">
              <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                  <thead class="bg-light text-muted small">
                    <tr>
                      <th class="ps-4 border-0">EVENTO</th>
                      <!-- <th class="border-0">AREA</th> -->
                      <th class="border-0">DATA INVIO</th>
                      <th class="border-0">STATO</th>
                      <th class="pe-4 text-end border-0">AZIONE</th>
                    </tr>
                  </thead>
                  <tbody>
                    {foreach $applications as $application}
                    <tr>
                      <td class="ps-4">
                        <div class="fw-bold">{$application->getEvent()->getTitle()}</div>
                        <div class="small text-muted">{$application->getEvent()->getPlace()}</div>
                      </td>
                      <!-- <td><span class="badge bg-success-subtle text-success">Ambiente</span></td> -->
                      <td>{$application->getSubmittedDateTime()->format('Y-m-d')}</td>
                      <td>
                        <span class="badge rounded-pill bg-warning text-dark px-3 py-2">
                          <i class="bi bi-hourglass-split me-1"></i>{$application->getState()->value}
                        </span>
                      </td>
                      <td class="pe-4 text-end">
                        <a href="/applications/select/{$volunteer->getUserId()}/{$application->getEventId()}" class="btn btn-light btn-sm rounded-circle"><i class="bi bi-hand-index"></i></a>
                      </td>
                    </tr>
                    {/foreach}
                  </tbody>
                </table>
              </div>
            </div>
          </div>

          <!--DONATIONS-->

          <div class="card border-0 shadow-sm mt-4">
            <div class="card-header bg-white p-4 border-0">
              <h5 class="fw-bold mb-0">Le Tue Donazioni</h5>
            </div>
            <div class="card-body border-top border-2 border-danger p-0">
              <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                  <thead class="bg-light text-muted small">
                    <tr>
                      <th class="ps-4 border-0">DATA</th>
                      <th class="border-0">CAUSALE</th>
                      <th class="border-0">IMPORTO</th>
                    </tr>
                  </thead>
                  <tbody>
                    {foreach $donations as $donation}
                    <tr>
                      <td class="ps-4">
                        {$donation->getDate()->format('Y-m-d')}
                      </td>
                      <td>
                        <p>
                          {if $donation->getReason() == null}
                            nessuna
                          {else}
                            {$donation->getReason()}
                          {/if}
                        </p></td>
                      <td>{$donation->getAmount()}</td>
                    </tr>
                    {/foreach}
                  </tbody>
                </table>
              </div>
            </div>
          </div>

          <!--REVIEWS-->

          <div class="card border-0 shadow-sm mt-4">
            <div class="card-header bg-white p-4 border-0">
              <h5 class="fw-bold mb-0">Le Tue Recensioni</h5>
            </div>
            <div class="card-body border-top border-2 border-primary p-0">
              <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                  <thead class="bg-light text-muted small">
                    <tr>
                      <th class="ps-4 border-0">DATA</th>
                      <th class="border-0">TESTO</th>
                      <th class="border-0">VALUTAZIONE</th>
                    </tr>
                  </thead>
                  <tbody>
                    {foreach $reviews as $review}
                    <tr>
                      <td class="ps-4">
                        {$review->getDate()->format('Y-m-d')}
                      </td>
                      <td>
                        <p>
                          {$review->getText()}
                        </p>
                      </td>
                      <td>
                        {$review->getRating()}
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
   