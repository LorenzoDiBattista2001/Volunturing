{extends file="main.tpl"}

{block name="title"}Volunturing - Chi Siamo{/block}

{block name="head"}
    <link rel="stylesheet" href="{$css_path}/associationInfo.css"/>
{/block}

{block name="body"}
    <header class="bg-white section-padding border-bottom">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-lg-6">
            <h6 class="text-brand fw-bold text-uppercase ls-1">La nostra Mission</h6>
            <h1 class="display-4 fw-bold mb-4">Costruiamo ponti di <span class="text-brand">solidarietà</span> a Torino.</h1>
            <p class="lead text-secondary mb-4">
              Volontorino nasce dal desiderio di rendere il volontariato accessibile, moderno e trasparente. Crediamo che ogni piccolo gesto, se coordinato, possa generare un impatto straordinario sul nostro territorio.
            </p>
            <div class="d-flex gap-3">
              <a href="/events/explore" class="btn btn-warning text-dark fw-bold px-4 py-2 rounded-pill">SCOPRI GLI EVENTI</a>
              <a href="/about/contacts" class="btn btn-outline-dark fw-bold px-4 py-2 rounded-pill">CONTATTACI</a>
            </div>
          </div>
          <div class="col-lg-5 offset-lg-1 d-none d-lg-block">
             <div class="p-5 bg-brand-light rounded-5 text-center">
                <i class="bi bi-people-fill text-brand display-1"></i>
             </div>
          </div>
        </div>
      </div>
    </header>

    <section class="section-padding bg-light">
      <div class="container text-center">
        <h2 class="fw-bold mb-5">I Valori che ci guidano</h2>
        <div class="row g-4">
          <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm p-4 rounded-4">
              <i class="bi bi-shield-check mission-icon"></i>
              <h4 class="fw-bold">Trasparenza</h4>
              <p class="text-muted">Ogni candidatura e ogni donazione è gestita con la massima chiarezza e rendicontazione.</p>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm p-4 rounded-4">
              <i class="bi bi-geo-alt-fill mission-icon"></i>
              <h4 class="fw-bold">Territorialità</h4>
              <p class="text-muted">Siamo radicati a Torino e provincia, conoscendo profondamente le necessità dei nostri quartieri.</p>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm p-4 rounded-4">
              <i class="bi bi-lightning-charge-fill mission-icon"></i>
              <h4 class="fw-bold">Innovazione</h4>
              <p class="text-muted">Utilizziamo le tecnologie digitali per semplificare l'incontro tra domanda e offerta di solidarietà.</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="section-padding bg-white">
      <div class="container">
        <div class="row">
          <div class="col-lg-5">
            <h2 class="fw-bold mb-4">La nostra Storia</h2>
            <p class="text-muted">Dalla nostra fondazione nel 2015, abbiamo percorso molta strada insieme ai nostri volontari.</p>
          </div>
          <div class="col-lg-7">
            <div class="timeline-step">
              <h5 class="fw-bold">2015 - La Fondazione</h5>
              <p class="text-muted">Un gruppo di studenti universitari di Torino decide di creare un'associazione per coordinare le piccole attività di quartiere.</p>
            </div>
            <div class="timeline-step">
              <h5 class="fw-bold">2018 - Riconoscimento OdV</h5>
              <p class="text-muted">Otteniamo il riconoscimento ufficiale come Organizzazione di Volontariato, espandendo il nostro raggio d'azione.</p>
            </div>
            <div class="timeline-step">
              <h5 class="fw-bold">2023 - Verso il Digitale</h5>
              <p class="text-muted">Lancio della piattaforma "Volunturing" per permettere la gestione telematica completa degli eventi.</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="section-padding bg-brand-light">
      <div class="container text-center">
        <h2 class="fw-bold mb-5">Il Nostro Team</h2>
        <div class="row g-4">
          <div class="col-md-4">
            <div class="card founder-card bg-transparent">
              <div class="founder-avatar">MR</div>
              <h5 class="fw-bold">Mario Rossi</h5>
              <p class="text-brand fw-bold small">Presidente & Fondatore</p>
              <p class="small text-muted px-3">Visionario e coordinatore, guida l'associazione con passione dal primo giorno.</p>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card founder-card bg-transparent">
              <div class="founder-avatar">LB</div>
              <h5 class="fw-bold">Luca Bianchi</h5>
              <p class="text-brand fw-bold small">Responsabile Logistica</p>
              <p class="small text-muted px-3">L'anima operativa del team, si assicura che ogni evento sia organizzato nei minimi dettagli.</p>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card founder-card bg-transparent">
              <div class="founder-avatar">SV</div>
              <h5 class="fw-bold">Sara Verdi</h5>
              <p class="text-brand fw-bold small">Comunicazione</p>
              <p class="small text-muted px-3">Voce e volto di Volontorino, gestisce il rapporto con la comunità e i partner.</p>
            </div>
          </div>
        </div>
      </div>
    </section>
{/block}