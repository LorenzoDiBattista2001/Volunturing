{extends file="main.tpl"}

{block name="title"}Volunturing - Registrazione{/block}

{block name="head"}
    <link href="{$css_path}/authenticationForms.css" rel="stylesheet">
{/block}

{block name="body"}
    <main class="container my-5 flex-grow-1">
      <div class="row justify-content-center">
        <div class="col-lg-8">
          <div class="card border-0 shadow-lg overflow-hidden">
            
            <div class="card-header card-header-custom p-4 text-center">
              <h2 class="h4 fw-bold mb-0 text-dark text-uppercase">Crea il tuo Profilo</h2>
              <p class="small text-muted mb-0 mt-1">Unisciti alla nostra comunità di volontari</p>
            </div>

            <div class="card-body p-4 p-md-5">
              <form action="#" method="POST" class="needs-validation" novalidate>
                
                <div class="row g-3 mb-4">
                  <div class="col-md-6">
                    <label for="firstName" class="form-label">Nome</label>
                    <input type="text" class="form-control border-0 bg-light" id="firstName" name="firstName" placeholder="Mario" required>
                  </div>
                  <div class="col-md-6">
                    <label for="lastName" class="form-label">Cognome</label>
                    <input type="text" class="form-control border-0 bg-light" id="lastName" name="lastName" placeholder="Rossi" required>
                  </div>
                </div>

                <div class="row g-3 mb-4">
                  <div class="col-md-6">
                    <label for="birthDate" class="form-label">Data di Nascita</label>
                    <input type="date" class="form-control border-0 bg-light" id="birthDate" name="birthDate" required>
                  </div>
                  <div class="col-md-6">
                    <label for="birthPlace" class="form-label">Luogo di Nascita</label>
                    <input type="text" class="form-control border-0 bg-light" id="birthPlace" name="birthPlace" placeholder="Torino, Milano..." required>
                  </div>
                </div>

                <div class="row g-3 mb-4">
                  <div class="col-md-6">
                    <label for="telephoneNumber" class="form-label">Numero di Telefono</label>
                    <input type="tel" class="form-control border-0 bg-light" id="telephoneNumber" name="telephoneNumber" required>
                  </div>
                  <div class="col-md-6">
                    <label for="taxCode" class="form-label">Codice Fiscale</label>
                    <input type="text" class="form-control border-0 bg-light" id="taxCode" name="taxCode" required>
                  </div>
                </div>

                <div class="row g-3 mb-4">
                  <div class="col-md-6">
                    <label for="streetAddress" class="form-label">Indirizzo di Residenza</label>
                    <input type="text" class="form-control border-0 bg-light" id="streetAddress" name="streetAddress" required>
                  </div>
                  <div class="col-md-6">
                    <label for="houseNumber" class="form-label">Numero Civico</label>
                    <input type="number" class="form-control border-0 bg-light" id="houseNumber" name="houseNumber" required>
                  </div>
                </div>

                <div class="mb-4">
                  <label for="email" class="form-label">Indirizzo Email</label>
                  <input type="email" class="form-control border-0 bg-light" id="email" name="email" placeholder="mario.rossi@example.com" required>
                </div>

                <div class="row g-3 mb-4">
                  <div class="col-md-6">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control border-0 bg-light" id="password" name="password" minlength="8" required>
                  </div>
                  <div class="col-md-6">
                    <label for="confirm" class="form-label">Conferma Password</label>
                    <input type="password" class="form-control border-0 bg-light" id="confirm" name="passwordConfirm" required>
                  </div>
                </div>

                <div class="mb-4 form-check">
                  <input type="checkbox" class="form-check-input" id="privacy" required>
                  <label class="form-check-label small text-muted" for="privacy">
                    Accetto i termini di servizio e l'informativa sulla privacy
                  </label>
                </div>

                <div class="text-center mt-4">
                  <button type="submit" class="btn btn-submit w-100 py-3 fw-bold fs-5 shadow-sm">
                    REGISTRATI ORA <i class="bi bi-person-plus-fill ms-2"></i>
                  </button>
                  <p class="mt-4 mb-0 small text-muted">
                    Hai gi&agrave; un account? <a href="loginForm.html" class="text-warning fw-bold text-decoration-none">Accedi</a>
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