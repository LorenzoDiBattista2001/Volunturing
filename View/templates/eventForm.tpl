{extends file="main.tpl"}

{block name="title"}Volunturing - Aggiungi Evento{/block}

{block name="head"}
    <link rel="stylesheet" href="{$css_path}/eventForm.css"/>
{/block}

{block name="body"}
    <main class="container my-5 flex-grow-1">
      <div class="row justify-content-center">
        <div class="col-lg-8">
          <div class="card border-0 shadow-lg overflow-hidden">
            
            <div class="card-header card-header-custom p-4 text-center">
              <h2 class="h5 fw-bold mb-0 text-dark text-uppercase">AGGIUNGI UN EVENTO DI VOLONTARIATO</h2>
              <p class="text-muted mb-0 mt-1">Inserisci i dettagli del nuovo evento</p>
            </div>

            <div class="card-body p-4 p-md-5">
              <form action="/admin/events/create" method="POST" class="needs-validation" novalidate>
                
                <div class="row row-cols-1 mb-4">
                  <div>
                    <label for="title" class="form-label">Titolo dell'evento</label>
                    <input type="text" class="form-control border-0 bg-light" id="title" name="title" required>
                  </div>
                </div>

                <div class="row g-3 mb-4">
                  <div class="col-md-6">
                    <label for="fieldOfAction" class="form-label">Area di Intervento</label>
                    <select class="form-select border-0 bg-light" id="fieldOfAction" name="fieldOfAction" aria-label="area di intervento">
                      <option selected>--Area di Intervento--</option>
                      <option value="Tutela ambientale">Tutela Ambientale</option>
                      <option value="Supporto logistico">Supporto Logistico</option>
                      <option value="Raccolta fondi">Raccolta Fondi</option>
                      <option value="Colletta alimentare">Colletta Alimentare</option>
                    </select>
                  </div>
                  <div class="col-md-6">
                    <label for="coordinator" class="form-label">Responsabile</label>
                    <input type="text" class="form-control border-0 bg-light" id="coordinator" name="coordinator" required>
                  </div>
                </div>

                <div class="row g-3 mb-4">
                  <div class="col-md-3">
                    <label for="date" class="form-label">Data</label>
                    <input type="date" class="form-control border-0 bg-light" id="date" required>
                  </div>
                  <div class="col-md-3">
                    <label for="time" class="form-label">Ora</label>
                    <input type="time" class="form-control border-0 bg-light" id="time" required>
                  </div>
                  <div class="col-md-6">
                    <label for="place" class="form-label">Luogo</label>
                    <input type="text" class="form-control border-0 bg-light" id="place" required>
                  </div>
                </div>

                <div class="row mb-3 ">
                  <label for="requesteVolunteerNumber" class="col-sm-6 col-form-label">Numero atteso di volontari: </label>
                  <div class="col-sm-2 me-auto">
                    <input type="number" class="form-control border-1 bg-light" id="requesteVolunteerNumber" name="requesteVolunteerNumber">
                  </div>
                </div>

                <div class="row mb-3 ">
                  <label for="maxVolunteerNumber" class="col-sm-6 col-form-label">Numero massimo di candidature accettabili: </label>
                  <div class="col-sm-2 me-auto">
                    <input type="number" class="form-control border-1 bg-light" id="maxVolunteerNumber" name="maxVolunteerNumber">
                  </div>
                </div>

                <div class="mb-4">
                  <label for="candidateRequirements" class="form-label">Requisiti del candidato (Opzionale):</label>
                  <textarea class="form-control border-1 bg-light" id="candidateRequirements" name="candidateRequirements" rows="3"></textarea>
                </div>

                <div class="text-center mt-4">
                  <button type="submit" class="btn btn-submit w-50 py-3 fw-bold fs-5 shadow-sm">
                    CREA EVENTO <i class="bi bi-plus-circle ms-2"></i>
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
  <script src="{$js_path}/formFeedback.js"></script>
{/block}