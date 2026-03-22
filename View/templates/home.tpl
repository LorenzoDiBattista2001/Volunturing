{extends file="main.tpl"}

{block name="title"}Volunturing - Home{/block}

{block name="head"}
    <link rel="stylesheet" href="{$css_path}/home.css"/>
{/block}
{block name="body"}
  <!-- HERO SECTION-->
    <main class="container my-5 flex-grow-1">
      <div class="row justify-content-center">
        <div class="col-lg-10">
          <div class="card border-0 shadow-lg overflow-hidden">
            <div class="row g-0">
              <div class="col-md-12">
                <div class="card-body text-center p-5">
                  <span class="badge bg-success text-white mb-3 px-3 py-2 rounded-pill fw-bold">BENVENUTI</span>
                  <h1 class="display-4 fw-bold text-dark mb-3">VOLONTORINO</h1>
                  <p class="lead text-muted mb-4">
                    Uniamo le forze per costruire una comunit&agrave; pi&ugrave; solidale. 
                    Scopri come puoi contribuire ai nostri progetti oggi stesso.
                  </p>
                  
                  <!-- Call to Action -->
                  <div class="row g-3 justify-content-center">
                    <div class="col-sm-5 col-md-4">
                      <a href="/events/explore" class="btn btn-warning w-100 py-3 fw-bold shadow">
                        <i class="bi bi-calendar-event me-2"></i> ESPLORA EVENTI
                      </a>
                    </div>
                    <div class="col-sm-5 col-md-4">
                      <a href="#" class="btn btn-outline-success w-100 py-3 fw-bold">
                        <i class="bi bi-heart-fill me-2"></i> DONA ORA
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- INFO-->
      <div class="row mt-5 g-4 justify-content-center">
        <!-- About -->
        <div class="col-md-4">
          <div class="card h-100 border-0 shadow-sm text-center p-3 hover-lift">
            <div class="card-body">
              <div class="icon-box mb-3">
                <i class="bi bi-people-fill fs-1 text-warning"></i>
              </div>
              <h4 class="card-title fw-bold">Chi Siamo</h4>
              <p class="card-text text-muted small">Conosci la nostra missione, la nostra storia e il team che lavora ogni giorno sul territorio.</p>
              <a href="#" class="btn btn-link text-warning fw-bold text-decoration-none">Scopri di più &rarr;</a>
            </div>
          </div>
        </div>

        <!-- Reviews -->
        <div class="col-md-4">
          <div class="card h-100 border-0 shadow-sm text-center p-3 hover-lift">
            <div class="card-body">
              <div class="icon-box mb-3">
                <i class="bi bi-chat-quote-fill fs-1 text-warning"></i>
              </div>
              <h4 class="card-title fw-bold">Dicono di Noi</h4>
              <p class="card-text text-muted small">Leggi le storie e le testimonianze dei volontari che hanno già partecipato ai nostri eventi.</p>
              <a href="#" class="btn btn-link text-warning fw-bold text-decoration-none">Leggi recensioni &rarr;</a>
            </div>
          </div>
        </div>

        <!-- Contacts -->
        <div class="col-md-4">
          <div class="card h-100 border-0 shadow-sm text-center p-3 hover-lift">
            <div class="card-body">
              <div class="icon-box mb-3">
                <i class="bi bi-envelope-paper-fill fs-1 text-warning"></i>
              </div>
              <h4 class="card-title fw-bold">Contatti</h4>
              <p class="card-text text-muted small">Hai domande? Scrivici o vieni a trovarci nella nostra sede per parlare dei tuoi progetti.</p>
              <a href="#" class="btn btn-link text-warning fw-bold text-decoration-none">Approfondisci &rarr;</a>
            </div>
          </div>
        </div>
      </div>
    </main>
{/block}