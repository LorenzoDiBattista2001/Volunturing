{extends file="main.tpl"}

{block name="title"}Volunturing - Contatti{/block}

{block name="head"}
    <link rel="stylesheet" href="{$css_path}/contacts.css"/>
{/block}

{block name="body"}
    <main class="container my-5 flex-grow-1">
      <div class="text-center mb-5">
        <h1 class="fw-bold">Contattaci</h1>
        <p class="text-muted">Hai domande, dubbi o curiosità sulle nostre attivit&agrave;? Non esitare a contattarci! Saremo felici di fornirti ogni chiarimento</p>
      </div>

      <div class="row g-4 justify-content-center">

        <div class="col-lg-8">
          
          <div class="card contact-card shadow-sm p-4 mb-4">
            <div class="d-flex align-items-start mb-4">
              <div class="icon-box me-3">
                <i class="bi bi-geo-alt-fill"></i>
              </div>
              <div>
                <h6 class="fw-bold mb-1">Dove trovarci</h6>
                <p class="text-muted small mb-0">Via dei Volontari, 123<br>10121 Torino (TO)</p>
              </div>
            </div>

            <div class="d-flex align-items-start mb-4">
              <div class="icon-box me-3">
                <i class="bi bi-telephone-fill"></i>
              </div>
              <div>
                <h6 class="fw-bold mb-1">Telefono</h6>
                <p class="text-muted small mb-0">+39 011 123 4567<br><span class="x-small">(Lun-Ven, 09:00 - 18:00)</span></p>
              </div>
            </div>

            <div class="d-flex align-items-start">
              <div class="icon-box me-3">
                <i class="bi bi-envelope-at-fill"></i>
              </div>
              <div>
                <h6 class="fw-bold mb-1">Indirizzo di posta elettronica</h6>
                <p class="text-muted small mb-0">info@volunturing.it</p>
              </div>
            </div>
          </div>

          <div class="card contact-card shadow-sm p-4 mb-4">
            <h6 class="fw-bold mb-3 border-bottom pb-2">I nostri riferimenti</h6>
            <ul class="list-unstyled mb-0">
              <li class="mb-3">
                <div class="fw-bold small">Norberto Novelli</div>
                <div class="text-muted x-small">Presidente</div>
                <a href="mailto:novelli.norberto@example.com" class="text-brand text-decoration-none small">novelli.norberto@example.com</a>
              </li>
              <li class="mb-3">
                <div class="fw-bold small">Chiara Sartirana</div>
                <div class="text-muted x-small">Responsabile dei servizi informatici</div>
                <a href="mailto:sartirana.chiara@example.com" class="text-brand text-decoration-none small">sartirana.chiara@example.com</a>
              </li>
              <li>
                <div class="fw-bold small">Amedeo Chiamparino</div>
                <div class="text-muted x-small">Supervisore d'ufficio</div>
                <a href="mailto:chiamparino.amedeo@example.com" class="text-brand text-decoration-none small">chiamparino.amedeo@example.com</a>
              </li>
            </ul>
          </div>

        </div>

      </div>
    </main>
{/block}