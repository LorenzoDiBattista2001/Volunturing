{extends file="main.tpl"}

{block name="title"}Volunturing - Dettagli Utente{/block}

{block name="head"}
    <link rel="stylesheet" href="{$css_path}/userDetails.css">
{/block}

{block name="body"}
    <main class="container my-5 flex-grow-1">

      <div class="row g-4">
        
        <div class="col-lg-4">
          <div class="card card-details shadow-sm p-4 text-center">
            <div class="avatar-large">{$volunteer->getInitials()}</div>
            <h3 class="fw-bold mb-4 border-bottom border-2 pb-3">{$volunteer->getFirstName()} {$volunteer->getLastName()}</h3>
            
            <div class="p-3 bg-light rounded-3 mb-4">
              <div class="small text-uppercase fw-bold text-muted mb-1">Stato Profilo</div>
              {if $volunteer->isBlocked()}
              <div class="h5 status-blocked mb-0">
                <i class="bi bi-patch-minus-fill me-2"></i>BLOCCATO
              </div>
              {else}
              <div class="h5 status-active mb-0">
                <i class="bi bi-patch-check-fill me-2"></i>ATTIVO
              </div>
              {/if}
            </div>

            <div class="d-grid gap-2">
              {if $volunteer->isBlocked()}
              <a href="/admin/users/unlock/{$volunteer->getUserId()}" class="btn btn-admin btn-rehab">
                <i class="bi bi-person-check-fill me-2"></i>RIABILITA PROFILO
              </a> 
              {else}
              <button type="button" class="btn btn-admin btn-block" data-bs-toggle="modal" data-bs-target="#blockModal">
                <i class="bi bi-slash-circle me-2"></i>BLOCCA PROFILO
              </button>
              {/if}
              <a href="/admin/users/manage" class="btn btn-outline-secondary btn-admin mt-2">
                <i class="bi bi-arrow-left me-2"></i>Torna alla lista
              </a>
            </div>
          </div>

          <div class="alert alert-info mt-4 border-0 shadow-sm small">
            <i class="bi bi-info-circle-fill me-2"></i>
            Il blocco del profilo impedirà all'utente di effettuare il login finché non verrà riabilitato manualmente.
          </div>
        </div>

        <div class="col-lg-8">
          <div class="card card-details shadow-sm p-4 p-md-5">
            <h5 class="fw-bold mb-4 border-bottom pb-2 text-brand">Dati Anagrafici</h5>
            
            <div class="row g-3">
              <div class="col-md-6">
                <div class="info-label">Nome e Cognome</div>
                <div class="info-value">{$volunteer->getFirstName()} {$volunteer->getLastName()}</div>
              </div>
              <div class="col-md-6">
                <div class="info-label">Et&agrave;</div>
                <div class="info-value">{$volunteer->calculateAge()} anni</div>
              </div>
              <div class="col-md-6">
                <div class="info-label">Codice Fiscale</div>
                <div class="info-value font-monospace">{$volunteer->getTaxCode()}</div>
              </div>
              <div class="col-md-6">
                <div class="info-label">Data di Nascita</div>
                <div class="info-value">{$volunteer->getBirthDate()->format('d-m-Y')}</div>
              </div>
            </div>

            <h5 class="fw-bold mb-4 mt-4 border-bottom pb-2 text-brand">Contatti e Residenza</h5>
            <div class="row g-3">
              <div class="col-md-12">
                <div class="info-label">Indirizzo</div>
                <div class="info-value">{$volunteer->getStreetAddress()}, {$volunteer->getHouseNumber()}</div>
              </div>
              <div class="col-md-6">
                <div class="info-label">Email</div>
                <div class="info-value">{$volunteer->getEmail()}</div>
              </div>
              <div class="col-md-6">
                <div class="info-label">Cellulare</div>
                <div class="info-value">+{$volunteer->getTelephoneNumber()}</div>
              </div>
            </div>

            <h5 class="fw-bold mb-4 mt-4 border-bottom pb-2 text-brand">Auto-descrizione</h5>
            <div class="bg-light p-3 rounded-3 text-secondary italic">
              "{$volunteer->getDescription()}"
            </div>
          </div>
        </div>
      </div>
    </main>

    <div class="modal fade" id="blockModal" tabindex="-1" aria-labelledby="blockModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
          <div class="modal-header modal-header-danger">
            <h5 class="modal-title fw-bold" id="blockModalLabel">Stai bloccando {$volunteer->getFirstName()} {$volunteer->getLastName()}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form action="/admin/users/block/{$volunteer->getUserId()}" method="POST" novalidate class="needs-validation">
            <div class="modal-body p-4">
              <p class="text-muted small mb-4">Per favore, inserisci una motivazione per il blocco del profilo. Questa spiegazione sarà inclusa nella mail automatica di notifica inviata all'utente.</p>
              
              <div class="mb-3">
                <label for="reason" class="form-label fw-bold small text-uppercase">Motivazione del blocco</label>
                <textarea class="form-control" id="reason" name="reason" rows="4" placeholder="Inserisci qui la ragione del provvedimento..." required></textarea>
                <div class="form-text text-danger">Campo obbligatorio.</div>
              </div>
            </div>
            <div class="modal-footer border-0 p-4 pt-0">
              <button type="button" class="btn btn-light fw-bold" data-bs-dismiss="modal">ANNULLA</button>
              <button type="submit" class="btn btn-danger fw-bold px-4 shadow-sm">CONFERMA BLOCCO</button>
            </div>
          </form>
        </div>
      </div>
    </div>
{/block}
    
{block name="script"}
  <script src="{$js_path}/formFeedback.js"></script>
{/block}