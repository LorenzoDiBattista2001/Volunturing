{extends file="main.tpl"}

{block name="title"}Volunturing - Donazione{/block}

{block name="head"}
    <link rel="stylesheet" href="{$css_path}/donationForm.css"/>
{/block}

{block name="body"}
    <main class="container my-5 flex-grow-1">
      <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
          
          <div class="d-flex justify-content-between mb-4 px-2 text-muted small fw-bold">
            <span class="text-warning">1. IMPORTO E CAUSALE</span>
            <span>2. DATI PAGAMENTO</span>
          </div>
          <div class="progress mb-4 bg-white shadow-sm" style="height: 8px;">
            <div class="progress-bar" role="progressbar" style="width: 50%; background-color: #ff9411;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
          </div>

          <div class="card border-0 shadow-lg overflow-hidden">
            <div class="card-header card-header-custom p-4 text-center">
              <h2 class="h4 fw-bold mb-0 text-dark text-uppercase">Sostieni le nostre attivit&agrave;</h2>
              <p class="small text-muted mb-0 mt-1">Ogni contributo, anche piccolo, fa la differenza</p>
            </div>

            <div class="card-body p-4 p-md-5">
              <form action="/donation/amount" method="POST" class="needs-validation" novalidate>
                
                <div class="mb-4">
                  <label class="form-label mb-3">Scegli un importo rapido</label>
                  <div class="row g-2">
                    <div class="col-4">
                      <input type="radio" class="btn-check" name="quickAmount" id="amt20" autocomplete="off" onclick="document.getElementById('amount').value=20">
                      <label class="btn btn-outline-warning w-100 fw-bold" for="amt20">20€</label>
                    </div>
                    <div class="col-4">
                      <input type="radio" class="btn-check" name="quickAmount" id="amt50" autocomplete="off" onclick="document.getElementById('amount').value=50">
                      <label class="btn btn-outline-warning w-100 fw-bold" for="amt50">50€</label>
                    </div>
                    <div class="col-4">
                      <input type="radio" class="btn-check" name="quickAmount" id="amt100" autocomplete="off" onclick="document.getElementById('amount').value=100">
                      <label class="btn btn-outline-warning w-100 fw-bold" for="amt100">100€</label>
                    </div>
                  </div>
                </div>

                <div class="mb-4">
                  <label for="amount" class="form-label">Oppure inserisci un importo a tua scelta (min. 10,00 euro)</label>
                  <div class="input-group">
                    <span class="input-group-text bg-light border-0 fw-bold text-muted">€</span>
                    <input type="number" class="form-control border-0 bg-light fs-5 fw-bold" id="amount" name="amount" min="10" placeholder="10,00" required>
                    <div class="invalid-feedback">L'importo minimo per la donazione è di 10 euro.</div>
                  </div>
                </div>

                <div class="mb-4">
                  <label for="reason" class="form-label">Causale o Messaggio (Opzionale)</label>
                  <textarea class="form-control border-0 bg-light" id="reason" name="reason" rows="3"></textarea>
                </div>

                <div class="text-center mt-5">
                  <button type="submit" class="btn btn-submit w-100 py-3 fw-bold fs-5 shadow-sm">
                    CONTINUA <i class="bi bi-arrow-right-circle ms-2"></i>
                  </button>
                  <p class="mt-3 small text-muted">
                    <i class="bi bi-shield-check me-1"></i> Transazione sicura e crittografata
                  </p>
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