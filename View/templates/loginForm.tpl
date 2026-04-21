{extends file="main.tpl"}

{block name="title"}Volunturing - Login{/block}

{block name="head"}
  <link href="{$css_path}/authenticationForms.css" rel="stylesheet">
{/block}

{block name="body"}
    <main class="container my-5 flex-grow-1">
      <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
          <div class="card border-0 shadow-lg overflow-hidden">
            
            <div class="card-header card-header-custom p-4 text-center">
              <h2 class="h4 fw-bold mb-0 text-dark text-uppercase">Accedi al tuo Account</h2>
              <p class="small text-muted mb-0 mt-1">Inserisci le tue credenziali per continuare</p>
            </div>

            <div class="card-body p-4 p-md-5">
              <form action="/auth/login" method="POST" class="needs-validation" novalidate>
                
                <div class="mb-4">
                  <label for="email" class="form-label">Indirizzo Email</label>
                  <div class="input-group">
                    <span class="input-group-text bg-light border-0"><i class="bi bi-envelope text-muted"></i></span>
                    <input type="email" class="form-control border-0 bg-light" id="email" name="email" placeholder="mario.rossi@example.com" required>
                    <div class="invalid-feedback">Inserisci un'email valida.</div>
                  </div>
                </div>

                <div class="mb-3">
                  <div class="d-flex justify-content-between">
                    <label for="password" class="form-label">Password</label>
                  </div>
                  <div class="input-group">
                    <span class="input-group-text bg-light border-0"><i class="bi bi-lock text-muted"></i></span>
                    <input type="password" class="form-control border-0 bg-light" id="password" name="password" required>
                    <div class="invalid-feedback">Inserisci la password.</div>
                  </div>
                </div>

                <div class="text-center mt-4">
                  <button type="submit" class="btn btn-submit w-100 py-3 fw-bold fs-5 shadow-sm">
                    ACCEDI <i class="bi bi-box-arrow-in-right ms-2"></i>
                  </button>
                  <p class="mt-4 mb-0 small text-muted">
                    Non hai ancora un account? <a href="/auth/registrationForm" class="text-warning fw-bold text-decoration-none">Registrati ora</a>
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