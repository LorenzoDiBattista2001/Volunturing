{extends file="main.tpl"}

{block name="title"}Volunturing - Modifica Profilo{/block}

{block name="head"}
    <link rel="stylesheet" href="{$css_path}/authenticationForms.css">
{/block}

{block name="body"}

    <main class="container my-5 flex-grow-1">

      <div class="row mb-3 justify-content-center">

        <div class="col-lg-6 col-md-8">
          <div class="card border-0 shadow-lg overflow-hidden">
            
            <div class="card-header card-header-custom p-4 text-center">
              <h2 class="h4 fw-bold mb-0 text-dark text-uppercase">MODIFICA PASSWORD</h2>
              <p class="small text-muted mb-0 mt-1">Inserisci la tua password attuale e la nuova password</p>
            </div>

            <div class="card-body p-4 p-md-5">
              <form action="/account/changePassword" method="POST" class="needs-validation" novalidate>
                
                <div class="mb-4">
                  <label for="currentPassword" class="form-label">Password Attuale</label>
                  <div class="input-group">
                    <span class="input-group-text bg-light border-0"><i class="bi bi-lock text-muted"></i></span>
                    <input type="password" class="form-control border-0 bg-light" id="currentPassword" name="currentPassword" required>
                    <div class="invalid-feedback"></div>
                  </div>
                </div>

                <div class="mb-3">
                  <div class="d-flex justify-content-between">
                    <label for="newPassword" class="form-label">Password Nuova</label>
                  </div>
                  <div class="input-group">
                    <span class="input-group-text bg-light border-0"><i class="bi bi-lock text-muted"></i></span>
                    <input type="password" class="form-control border-0 bg-light" id="newPassword" name="newPassword" minlength="8" required>
                    <div class="invalid-feedback"></div>
                  </div>
                </div>

                <div class="mb-3">
                  <div class="d-flex justify-content-between">
                    <label for="confirmPassword" class="form-label">Conferma Password</label>
                  </div>
                  <div class="input-group">
                    <span class="input-group-text bg-light border-0"><i class="bi bi-lock text-muted"></i></span>
                    <input type="password" class="form-control border-0 bg-light" id="confirmPassword" name="confirmPassword" minlength="8" required>
                    <div class="invalid-feedback"></div>
                  </div>
                </div>

                <div class="text-center mt-4">
                  <button type="submit" class="btn btn-submit w-100 py-3 fw-bold fs-5 shadow-sm">
                    CONFERMA <i class="bi bi-box-arrow-in-right ms-2"></i>
                  </button>
                </div>
  
              </form>
            </div>

          </div>
        </div>
      </div>

      <div class="row mb-3 justify-content-center">

        <div class="col-lg-6 col-md-8">
          <div class="card border-0 shadow-lg overflow-hidden">
            
            <div class="card-header card-header-custom p-4 text-center">
              <h2 class="h4 fw-bold mb-0 text-dark text-uppercase">MODIFICA EMAIL</h2>
              <p class="small text-muted mb-0 mt-1">Inserisci la tua password e il nuovo indirizzo email</p>
            </div>

            <div class="card-body p-4 p-md-5">
              <form action="/account/changeEmail" method="POST" class="needs-validation" novalidate>
                
                <div class="mb-4">
                  <label for="newEmail" class="form-label">Nuovo Indirizzo Email</label>
                  <div class="input-group">
                    <span class="input-group-text bg-light border-0"><i class="bi bi-envelope text-muted"></i></span>
                    <input type="email" class="form-control border-0 bg-light" id="newEmail" name="newEmail" placeholder="mario.rossi@example.com" required>
                    <div class="invalid-feedback"></div>
                  </div>
                </div>

                <div class="mb-3">
                  <div class="d-flex justify-content-between">
                    <label for="password" class="form-label">Password</label>
                  </div>
                  <div class="input-group">
                    <span class="input-group-text bg-light border-0"><i class="bi bi-lock text-muted"></i></span>
                    <input type="password" class="form-control border-0 bg-light" id="password" name="password" required>
                    <div class="invalid-feedback"></div>
                  </div>
                </div>

                <div class="text-center mt-4">
                  <button type="submit" class="btn btn-submit w-100 py-3 fw-bold fs-5 shadow-sm">
                    CONFERMA <i class="bi bi-box-arrow-in-right ms-2"></i>
                  </button>
                </div>
  
              </form>
            </div>

          </div>
        </div>
      </div>

      <div class="row mb-3 justify-content-center">

        <div class="col-lg-6 col-md-8">
          <div class="card border-0 shadow-lg overflow-hidden">
            
            <div class="card-header card-header-custom p-4 text-center">
              <h2 class="h4 fw-bold mb-0 text-dark text-uppercase">MODIFICA PROFILO</h2>
              <p class="small text-muted mb-0 mt-1">Aggiorna le tue informazioni personali</p>
            </div>

            <div class="card-body p-4 p-md-5">
              <form action="/account/update" method="POST" class="needs-validation" novalidate id="updateProfileForm">
                
                <div class="row g-3 mb-4">
                  <div class="col-md-6">
                    <label for="firstName" class="form-label">Nome</label>
                    <input type="text" class="form-control-plaintext" id="firstName" value="{$user->getFirstName()}" readonly>
                  </div>
                  <div class="col-md-6">
                    <label for="lastName" class="form-label">Cognome</label>
                    <input type="text" class="form-control-plaintext" id="lastName" value="{$user->getLastName()}" readonly>
                  </div>
                </div>

                <div class="row g-3 mb-4">
                  <div class="col-md-6">
                    <label for="birthDate" class="form-label">Data di Nascita</label>
                    <input type="date" class="form-control-plaintext" value="{$user->getBirthDate()->format('Y-m-d')}" id="birthDate" readonly>
                  </div>
                  <div class="col-md-6">
                    <label for="birthPlace" class="form-label">Luogo di Nascita</label>
                    <input type="text" class="form-control-plaintext" value="{$user->getBirthPlace()}" id="birthPlace" readonly>
                  </div>
                </div>

                <div class="row g-3 mb-4">
                  <div class="col-md-6">
                    <label for="telephoneNumber" class="form-label">Numero di Telefono</label>
                    <input type="tel" class="form-control border-0 bg-light" id="telephoneNumber" name="telephoneNumber" value="{$user->getTelephoneNumber()}" required>
                    <div class="invalid-feedback" id="telephoneNumberFeedback"></div>
                  </div>
                  <div class="col-md-6">
                    <label for="taxCode" class="form-label">Codice Fiscale</label>
                    <input type="text" class="form-control-plaintext" value="{$user->getTaxCode()}" id="taxCode" readonly>
                  </div>
                </div>

                <div class="row g-3 mb-4">
                  <div class="col-md-9">
                    <label for="streetAddress" class="form-label">Indirizzo di Residenza</label>
                    <input type="text" class="form-control border-0 bg-light" id="streetAddress" name="streetAddress" value="{$user->getStreetAddress()}" required>
                    <div class="invalid-feedback" id="streetAddressFeedback"></div>
                  </div>
                  <div class="col-md-3">
                    <label for="houseNumber" class="form-label">Numero Civico</label>
                    <input type="number" class="form-control border-0 bg-light" id="houseNumber" name="houseNumber"  value="{$user->getHouseNumber()}" required>
                    <div class="invalid-feedback" id="houseNumberFeedback"></div>
                  </div>
                </div>

                <div class="mb-4">
                  <label for="description" class="form-label">Descrizione:</label>
                  <textarea class="form-control border-1 bg-light" id="description" name="description" rows="3">{$user->getDescription()}</textarea>
                </div>

                <div class="text-center mt-4">
                  <button type="submit" class="btn btn-submit w-100 py-3 fw-bold fs-5 shadow-sm">
                    CONFERMA <i class="bi bi-box-arrow-in-right ms-2"></i>
                  </button>
                </div>
  
              </form>
            </div>

          </div>
        </div>
  
      </div>
    </main>
{/block}

{block name="script"}
  <script src="formFeedback.js"></script>
{/block}