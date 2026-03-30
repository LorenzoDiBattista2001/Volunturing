{extends file="main.tpl"}

{block name="title"}Volunturing - Dati Carta{/block}

{block name="head"}
    <link rel="stylesheet" href="{$css_path}/creditCardForm.css"/>
{/block}

{block name="body"}
    <main class="container my-5 flex-grow-1">
      <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
          
          <div class="d-flex justify-content-between mb-4 px-2 text-muted small fw-bold">
            <span class="text-success"><i class="bi bi-check-circle-fill me-1"></i> 1. IMPORTO</span>
            <span class="text-warning">2. DATI PAGAMENTO</span>
          </div>
          <div class="progress mb-4 bg-white shadow-sm" style="height: 8px;">
            <div class="progress-bar" role="progressbar" style="width: 100%; background-color: #ff9411;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
          </div>

          <div class="alert alert-warning border-0 shadow-sm d-flex justify-content-between align-items-center p-3 mb-4">
            <span class="fw-bold"><i class="bi bi-cart-check me-2"></i>Totale Donazione:</span>
            <span class="fs-4 fw-bold">{$amount},00 €</span>
          </div>

          <div class="card border-0 shadow-lg overflow-hidden">
            <div class="card-header card-header-custom p-4 text-center">
              <h2 class="h4 fw-bold mb-0 text-dark text-uppercase">Pagamento con Carta</h2>
              <div class="mt-2 text-muted">
                <i class="bi bi-credit-card-2-front me-1"></i>
                <i class="bi bi-credit-card-2-back me-1"></i>
                <i class="bi bi-shield-lock-fill text-success ms-2"></i> Sicuro al 100%
              </div>
            </div>

            <div class="card-body p-4 p-md-5">
              <form action="/donation/confirm" method="POST" class="needs-validation" novalidate id="form">
                
                <div class="row g-3 mb-4">
                  <div class="col-md-6">
                    <label for="firstName" class="form-label">Nome Titolare</label>
                    <input type="text" class="form-control border-0 bg-light" id="firstName" name="firstName" placeholder="Mario" required>
                  </div>
                  <div class="col-md-6">
                    <label for="lastName" class="form-label">Cognome Titolare</label>
                    <input type="text" class="form-control border-0 bg-light" id="lastName" name="lastName" placeholder="Rossi" required>
                  </div>
                </div>

                <div class="mb-4">
                  <label for="cardNumber" class="form-label">Numero della Carta</label>
                  <div class="input-group">
                    <span class="input-group-text bg-light border-0"><i class="bi bi-credit-card text-muted"></i></span>
                    <input type="text" class="form-control border-0 bg-light" id="cardNumber" name="cardNumber" placeholder="0000 0000 0000 0000" maxlength="19" required>
                    <div class="invalid-feedback" id="cardNumberFeedback"></div>
                  </div>
                </div>

                <div class="row g-3 mb-4">
                  <div class="col-6">
                    <label for="expirationDate" class="form-label">Scadenza (MM/AA)</label>
                    <div class="input-group">
                      <input type="text" class="form-control border-0 bg-light" id="expirationDate" name="expirationDate" placeholder="MM/AA" maxlength="5" required>
                      <div class="invalid-feedback" id="expirationDateFeedback"></div>
                    </div>
                  </div>
                  <div class="col-6">
                    <label for="cvv" class="form-label">CVV / CVC</label>
                    <div class="input-group">
                      <input type="password" class="form-control border-0 bg-light" id="cvv" name="cvv" placeholder="123" maxlength="3" required>
                      <span class="input-group-text bg-light border-0" data-bs-toggle="tooltip" title="Codice di 3 cifre sul retro della carta">
                        <i class="bi bi-question-circle text-muted"></i>
                      </span>
                      <div class="invalid-feedback" id="cvvFeedback"></div>
                    </div>
                  </div>
                </div>

                <div class="text-center mt-5">
                  <button type="submit" class="btn btn-submit w-100 py-3 fw-bold fs-5 shadow-sm">
                    CONFERMA DONAZIONE <i class="bi bi-lock-fill ms-2"></i>
                  </button>
                </div>
  
              </form>
            </div>
          </div>
          
          <div class="text-center mt-4">
            <a href="javascript:history.back()" class="btn btn-link text-decoration-none text-muted small">
              <i class="bi bi-chevron-left me-1"></i> Modifica importo o causale
            </a>
          </div>
        </div>
      </div>
    </main>
{/block}

{block name="script"}
  <script src="{$js_path}/creditCardForm.js"></script>
{/block}