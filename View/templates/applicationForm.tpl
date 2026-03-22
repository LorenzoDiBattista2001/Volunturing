{extends file="main.tpl"}

{block name="title"}Volunturing - Candidati{/block}
    
{block name="head"}
  <link rel="stylesheet" href="{$css_path}/applicationForm.css">
{/block}    
    
{block name="body"}
    <main class="container my-5 flex-grow-1">
      <div class="row justify-content-center">
        <div class="col-lg-7">
          <div class="card border-0 shadow-lg overflow-hidden">
            
            <div class="card-header card-header-custom p-4 text-center">
              <h2 class="h4 fw-bold mb-0 text-dark text-uppercase">Conferma Candidatura</h2>
              <p class="small text-muted mb-0 mt-1">Stai per candidarti all'evento: <strong>{$title}</strong></p>
            </div>

            <div class="card-body p-4 p-md-5">
              <form class="needs-validation" novalidate action="/events/submitApplication/{$eventId}" method="POST" enctype="application/x-www-form-urlencoded">
                
                <div class="mb-4">
                  <label for="motivation" class="form-label">
                    <i class="bi bi-chat-left-text me-2 text-warning"></i>Cosa ti spinge a partecipare?
                  </label>
                  <textarea 
                    class="form-control border-0 bg-light" 
                    id="motivation" 
                    name="motivation" 
                    rows="4" 
                    placeholder="Raccontaci brevemente perch&eacute; ti stai candidando per questo evento..."></textarea>
                  <div class="form-text mt-2">
                    <i class="bi bi-info-circle me-1"></i> Opzionale
                  </div>
                </div>

                <div class="mb-3">
                  <div class="form-check p-3 rounded bg-light border border-dashed">
                    <input 
                      class="form-check-input ms-0 me-2" 
                      type="checkbox" 
                      id="terms" 
                      name="terms" 
                      required>
                    <label class="form-check-label fw-semibold" for="terms">
                      Dichiaro di possedere i requisiti richiesti per partecipare all'evento
                    </label>

                    <div class="invalid-feedback">
                      Per inoltrare la candidatura, devi confermare di possedere i requisiti.
                    </div>
                  </div>
                </div>

                <div class="action-divider text-center">
                  <div class="row g-3 justify-content-center">
                    <div class="col-md-8">
                      <button type="submit" class="btn btn-submit w-100 py-3 fw-bold fs-5 shadow-sm">
                        CONFERMA INVIO <i class="bi bi-send-check ms-2"></i>
                      </button>
                    </div>
                    <div class="col-md-8 text-center">
                      <a href="javascript:history.back()" class="btn btn-link text-muted text-decoration-none small">
                        Torna ai dettagli dell'evento
                      </a>
                    </div>
                  </div>
                </div>

              </form>
            </div>
          </div>
        </div>
      </div>
    </main>
{/block}

{block name="script"}
  <script src="{$js_path}/formFeedback.js"></script>
{/block}
