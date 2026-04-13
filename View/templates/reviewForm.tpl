{extends file="main.tpl"}

{block name="title"}Volunturing - Recensione{/block}

{block name="head"}
    <link rel="stylesheet" href="{$css_path}/reviewForm.css"/>
{/block}

{block name="body"}
    <main class="container my-5 flex-grow-1">
      <div class="row justify-content-center">
        <div class="col-lg-7 col-md-10">
          
          <div class="card review-card shadow-lg p-4 p-md-5">
            <div class="text-center mb-5">
              <i class="bi bi-chat-quote text-brand fs-1" style="color: var(--brand-orange);"></i>
              <h2 class="fw-bold mt-3">La tua opinione conta</h2>
              <p class="text-muted">Condividi la tua esperienza con la nostra organizzazione.</p>
            </div>

            <form action="/review/publish" method="POST" id="reviewForm" class="needs-validation" novalidate>
              
              <div class="mb-4">
                <label for="reviewText" class="form-label fw-bold small text-uppercase text-muted">La tua recensione</label>
                <textarea class="form-control" id="reviewText" name="reviewText" rows="5" required></textarea>
                <div class="invalid-feedback">Per favore, inserisci un commento prima di inviare.</div>
              </div>

              <div class="mb-4 text-center">
                <label class="form-label fw-bold small text-uppercase text-muted">Come valuti le nostre attivit&agrave;?</label>
                
                <div class="rating-container" id="ratingGroup">

                  <input type="radio" name="rating" id="star5" value="5">
                  <label for="star5" title="Ottimo">05</label>

                  <input type="radio" name="rating" id="star4" value="4">
                  <label for="star4" title="Buono">04</label>

                  <input type="radio" name="rating" id="star3" value="3">
                  <label for="star3" title="Sufficiente">03</label>

                  <input type="radio" name="rating" id="star2" value="2">
                  <label for="star2" title="Scarso">02</label>

                  <input type="radio" name="rating" id="star1" value="1" checked>
                  <label for="star1" title="Molto scarso">01</label>
                </div>
                <div class="small text-muted mt-2" id="ratingLabel">Seleziona un valore da 1 a 5</div>
              </div>

              <div class="text-center mt-5">
                <button type="submit" class="btn btn-submit-review w-100 shadow-sm text-uppercase">
                  Conferma Recensione <i class="bi bi-check-circle ms-2"></i>
                </button>
              </div>

            </form>
          </div>

          <div class="alert alert-info border-0 shadow-sm mt-4 text-center small">
            <i class="bi bi-info-circle me-2"></i> Le recensioni sono pubbliche e aiutano altri volontari a conoscerci meglio.
          </div>

        </div>
      </div>
    </main>
{/block}

{block name="script"}
  <script src="{$js_path}/reviewForm.js"></script>
{/block}