{extends file="main.tpl"}

{block name="title"}Volunturing - Dashboard{/block}

{block name="head"}
    <link rel="stylesheet" href="{$css_path}/adminDashboard.css">
{/block}  

{block name="body"}

    <main class="container my-5 flex-grow-1">
      <div class="row g-4">

        <div class="col-lg-8">
          <h2 class="h4 fw-bold mb-4">Benvenuto, <span class="text-brand">{$firstName} {$lastName}</span></h2>
          <div class="row g-3 mb-4">
            <div class="col-md-4">
              <div class="card border-0 shadow-sm p-3 border-start border-4 border-primary">
                <div class="small text-muted fw-bold">EVENTI PROGRAMMATI</div>
                <div class="h3 fw-bold mb-0">{$scheduledEventsNumber}</div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="card border-0 shadow-sm p-3 border-start border-4 border-warning">
                <div class="small text-muted fw-bold">CANDIDATURE PENDENTI</div>
                <div class="h3 fw-bold mb-0">{$pendingApplicationsNumber}</div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="card border-0 shadow-sm p-3 border-start border-4 border-success">
                <div class="small text-muted fw-bold">UTENTI REGISTRATI</div>
                <div class="h3 fw-bold mb-0">{$usersCount}</div>
              </div>
            </div>
          </div>

          <div class="row g-3">
            <div class="col-md-6">
              <div class="card h-100 border-0 shadow-sm p-4 hover-lift">
                <div class="d-flex align-items-center mb-3">
                  <div class="icon-shape bg-warning-subtle text-warning me-3">
                    <i class="bi bi-calendar-event-fill fs-4"></i>
                  </div>
                  <h5 class="fw-bold mb-0">Gestione Eventi</h5>
                </div>
                <p class="small text-muted">Aggiungi nuovi eventi di volontariato, o eliminane di precedenti</p>
                <a href="/admin/events/manage" class="stretched-link"></a>
              </div>
            </div>
            <div class="col-md-6">
              <div class="card h-100 border-0 shadow-sm p-4 hover-lift">
                <div class="d-flex align-items-center mb-3">
                  <div class="icon-shape bg-success-subtle text-success me-3">
                    <i class="bi bi-check-all fs-4"></i>
                  </div>
                  <h5 class="fw-bold mb-0">Valuta Candidature</h5>
                </div>
                <p class="small text-muted">Esamina le candidature dei volontari e decidi se approvarle o meno</p>
                <a href="/admin/applications/manage" class="stretched-link"></a>
              </div>
            </div>
            <div class="col-md-6">
              <div class="card h-100 border-0 shadow-sm p-4 hover-lift">
                <div class="d-flex align-items-center mb-3">
                  <div class="icon-shape bg-primary-subtle text-primary me-3">
                    <i class="bi bi-people-fill fs-4"></i>
                  </div>
                  <h5 class="fw-bold mb-0">Anagrafica Utenti</h5>
                </div>
                <p class="small text-muted">Gestisci i profili dei volontari, blocca o riabilita gli accessi.</p>
                <a href="/admin/users/manage" class="stretched-link"></a>
              </div>
            </div>
            <div class="col-md-6">
              <div class="card h-100 border-0 shadow-sm p-4 hover-lift">
                <div class="d-flex align-items-center mb-3">
                  <div class="icon-shape bg-danger-subtle text-danger me-3">
                    <i class="bi bi-chat-left-quote-fill fs-4"></i>
                  </div>
                  <h5 class="fw-bold mb-0">Modera Recensioni</h5>
                </div>
                <p class="small text-muted">Monitora i feedback degli utenti e rimuovi contenuti inappropriati.</p>
                <a href="/admin/reviews/manage" class="stretched-link"></a>
              </div>
            </div>
          </div>
        </div>

        <aside class="col-lg-4">
          <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white border-0 pt-4 px-4">
              <h5 class="fw-bold mb-0">Dettagli Profilo</h5>
            </div>
            <div class="card-body p-4">
              <div class="d-flex align-items-center mb-4">
                <div>
                  <div class="fw-bold">{$firstName} {$lastName}</div>
                  <div class="small text-muted">Utente Amministratore</div>
                </div>
              </div>
              
              <div class="mb-4">
                <div class="small text-muted text-uppercase fw-bold ls-1 mb-1">Email di accesso</div>
                <div class="fw-semibold">{$email}</div>
              </div>

              <hr class="my-4">

              <h6 class="fw-bold mb-3"><i class="bi bi-shield-check me-2"></i>Sicurezza</h6>
              <div class="d-grid gap-2">
                <button class="btn btn-outline-warning btn-sm fw-bold py-2" data-bs-toggle="modal" data-bs-target="#passwordModal">
                  <i class="bi bi-key me-2"></i>CAMBIA PASSWORD
                </button>
                <button class="btn btn-outline-secondary btn-sm fw-bold py-2" data-bs-toggle="modal" data-bs-target="#emailModal">
                  <i class="bi bi-envelope-at me-2"></i>MODIFICA EMAIL
                </button>
              </div>
            </div>
          </div>
        </aside>

      </div>
    </main>

    <div class="modal fade" id="passwordModal" tabindex="-1" aria-labelledby="passwordModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
          <div class="modal-header">
            <h5 class="modal-title fw-bold" id="passwordModalLabel">Cambia Password</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form class="needs-validation" novalidate action="/account/changePassword" method="POST">
            <div class="modal-body p-4">
              <div class="mb-3">
                <label class="form-label small fw-bold">Password Attuale</label>
                <input type="password" class="form-control bg-light border-0" required name="currentPassword">
              </div>
              <div class="mb-3">
                <label class="form-label small fw-bold">Nuova Password</label>
                <input type="password" class="form-control bg-light border-0" required minlength="8" name="newPassword">
              </div>
              <div class="mb-0">
                <label class="form-label small fw-bold">Conferma Nuova Password</label>
                <input type="password" class="form-control bg-light border-0" required name="confirmPassword">
              </div>
            </div>
            <div class="modal-footer border-0 p-4 pt-0">
              <button type="button" class="btn btn-light fw-bold" data-bs-dismiss="modal">ANNULLA</button>
              <button type="submit" class="btn btn-brand fw-bold px-4">SALVA MODIFICHE</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <div class="modal fade" id="emailModal" tabindex="-1" aria-labelledby="emailModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
          <div class="modal-header">
            <h5 class="modal-title fw-bold" id="emailModalLabel">Modifica Email</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form class="needs-validation" novalidate action="#" method="POST">
            <div class="modal-body p-4">
              <div class="mb-3">
                <label class="form-label small fw-bold">Nuovo Indirizzo Email</label>
                <input type="email" class="form-control bg-light border-0" required name="newEmail" placeholder="nuova.email@example.com">
              </div>
              <div class="mb-0">
                <label class="form-label small fw-bold">Password per Conferma</label>
                <input type="password" class="form-control bg-light border-0" required name="password">
              </div>
            </div>
            <div class="modal-footer border-0 p-4 pt-0">
              <button type="button" class="btn btn-light fw-bold" data-bs-dismiss="modal">ANNULLA</button>
              <button type="submit" class="btn btn-brand fw-bold px-4">AGGIORNA EMAIL</button>
            </div>
          </form>
        </div>
      </div>
    </div>
{/block}

{block name="script"}
  <script src="formFeedback.js"></script>
{/block}