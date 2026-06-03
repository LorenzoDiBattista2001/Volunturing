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
            <h1 class="display-4 fw-bold mb-4">Costruiamo ponti di <span class="text-brand">solidariet&agrave;</span> a Torino.</h1>
            <p class="lead text-secondary mb-4">
              Volontorino nasce dal desiderio di rendere il volontariato accessibile, moderno e trasparente. Crediamo che ogni piccolo gesto, se coordinato, possa generare un impatto straordinario sul nostro territorio.
            </p>
            <div class="d-flex gap-3">
              <a href="{$root}/events/explore" class="btn btn-warning text-dark fw-bold px-4 py-2 rounded-pill">SCOPRI GLI EVENTI</a>
              <a href="{$root}/about/contacts" class="btn btn-outline-dark fw-bold px-4 py-2 rounded-pill">CONTATTACI</a>
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
              <p class="text-muted">Ogni candidatura e ogni donazione &egrave; gestita con la massima chiarezza e rendicontazione.</p>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm p-4 rounded-4">
              <i class="bi bi-geo-alt-fill mission-icon"></i>
              <h4 class="fw-bold">Territorialit&agrave;</h4>
              <p class="text-muted">Radicati a Torino e dintorni, conosciamo profondamente le necessità dei nostri quartieri.</p>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm p-4 rounded-4">
              <i class="bi bi-lightning-charge-fill mission-icon"></i>
              <h4 class="fw-bold">Innovazione</h4>
              <p class="text-muted">Utilizziamo le tecnologie digitali per semplificare l'incontro tra domanda e offerta di solidariet&agrave;.</p>
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
            <p class="text-muted">L'associazione "VolonTorino" nasce nel capoluogo Piemontese nell'anno 1998 per iniziativa del giovane
            analista finanziario Norberto Novelli, impegnato in attivit&agrave; di promozione sociale sin dai tempi delle scuole superiori.</p>
            
            <p class="text-muted">Dopo alcuni mesi di scarsa rilevanza e tiepida recettività da parte dei cittadini, l'organizzazione iniziò gradualmente ad attirare nuove leve e a giocare un ruolo di primo piano nella vita sociale della citt&agrave;.</p>
          </div>
          <div class="col-lg-7">
            <div class="timeline-step">
              <h5 class="fw-bold">1998 - La Fondazione</h5>
              <p class="text-muted">Insieme ai due amici storici Carla Fassino e Giulio Castellani, Norberto Novelli dà vita
              all'associazione di volontariato, cui dà il nome di VolonTorino (dalla crasi delle parole "Volontario" e "Torino")</p>
            </div>
            <div class="timeline-step">
              <h5 class="fw-bold">2017 - L'Organizzazione di Volontariato (OdV)</h5>
              <p class="text-muted">A seguito dell'emanazione del decreto legislativo 117/2017, noto come “Codice del Terzo Settore”, l'associazione deve ristrutturare il proprio statuto: ci&ograve; comporta,
              tra le altre cose, la necessit&agrave; di espandere la base sociale, che vede l'arrivo dei nuovi associati Chiara Sartirana, Ludovica Cattaneo, Amedeo Chiamparino e Sara Arona</p>
            </div>
            <div class="timeline-step">
              <h5 class="fw-bold">2025 - Verso il Digitale</h5>
              <p class="text-muted">Il consiglio amministrativo, presieduto dal fondatore Norberto Novelli, delibera sulla creazione di un'applicazione web per la digitalizzazione delle procedure di candidatura agli eventi da parte dei volontari.
              Il nome scelto per l'applicazione web &egrave; "Volunturing", frutto della fusione delle parole inglesi 'Volunteering' ("fare volontariato") e 'Turin' (Torino)</p>
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
              <div class="founder-avatar">NN</div>
              <h5 class="fw-bold">Norberto Novelli</h5>
              <p class="text-brand fw-bold small">Presidente & Fondatore</p>
              <p class="small text-muted px-3">Analista finanziario di professione, dedito ad attivit&agrave; di promozione sociale nel tempo libero.</p>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card founder-card bg-transparent">
              <div class="founder-avatar">CF</div>
              <h5 class="fw-bold">Carla Fassino</h5>
              <p class="text-brand fw-bold small">Vicepresidente, Responsabile della Comunicazione</p>
              <p class="small text-muted px-3">Da sempre voce e volto di Volontorino, gestisce i rapporti con i partner istituzionali e gli altri stakeholders.</p>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card founder-card bg-transparent">
              <div class="founder-avatar">GC</div>
              <h5 class="fw-bold">Giulio Castellani</h5>
              <p class="text-brand fw-bold small">Responsabile della Logistica</p>
              <p class="small text-muted px-3">L'anima operativa del team, si assicura che ogni evento sia organizzato nei minimi dettagli.</p>
            </div>
          </div>
        </div>
      </div>
    </section>
{/block}