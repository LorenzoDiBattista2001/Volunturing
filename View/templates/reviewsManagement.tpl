{extends file="main.tpl"}

{block name="title"}Volunturing - Gestione Recensioni{/block}

{block name="head"}
    <link rel="stylesheet" href="{$css_path}/reviewsManagement.css"/>
{/block}

{block name="body"}

    <main class="container my-5 flex-grow-1">
      
      <div class="d-flex justify-content-between align-items-end mb-4 border-bottom pb-3">
        <div>
          <h2 class="fw-bold mb-1">Gestione Recensioni</h2>
          <p class="text-muted mb-0 small text-uppercase fw-bold ls-1">Monitora e rimuovi contenuti inappropriati</p>
        </div>
        <div class="text-end d-none d-md-block">
          <span class="badge bg-white text-muted border px-3 py-2">Totale: {$reviewsNumber} recensioni</span>
        </div>
      </div>

      <div class="row g-4">
      {foreach $reviews as $review}
        <div class="col-md-6">
          <div class="card h-100 review-card-admin p-4">

            <button type="button" class="btn-delete-trigger" 
                    data-bs-toggle="modal" 
                    data-bs-target="#deleteReviewModal" 
                    data-bs-id="{$review->getReviewId()}" 
                    data-bs-user="{$review->getAuthor()->getFirstName()} {$review->getAuthor()->getLastName()}">
              <i class="bi bi-trash3-fill"></i>
            </button>

            <div class="d-flex align-items-center mb-3">
              <div class="avatar-circle me-3">{$review->getAuthor()->getInitials()}</div>
              <div>
                <h6 class="fw-bold mb-0">{$review->getAuthor()->getFirstName()} {$review->getAuthor()->getLastName()}</h6>
                <div class="star-rating">
                  {for $i = 1 to $review->getRating()}
                  <i class="bi bi-star-fill"></i>{/for}
                  {for $i = ($review->getRating() + 1) to 5}
                  <i class="bi bi-star"></i>{/for}
                </div>
              </div>
            </div>
            <p class="text-secondary small mb-3">
              {$review->getText()}
            </p>
            <div class="text-muted small mt-auto">
              <i class="bi bi-calendar3 me-1"></i> {$review->getDate()->format('d-m-Y')}
            </div>
          </div>
        </div>
      {/foreach}
      </div>
    </main>

    <div class="modal fade" id="deleteReviewModal" tabindex="-1" aria-labelledby="deleteReviewModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
          <div class="modal-header modal-header-danger">
            <h5 class="modal-title fw-bold" id="deleteReviewModalLabel">Conferma Eliminazione</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form action="/admin/reviews/delete" method="POST" id="deleteReviewForm">
            <div class="modal-body p-4 text-center">
              <i class="bi bi-exclamation-triangle text-danger display-4 mb-3"></i>
              <p class="mb-0">Sei sicuro di voler eliminare definitivamente la recensione di <strong id="modalUserName"></strong>?</p>
              <p class="text-muted small mt-2">Questa azione è irreversibile e la recensione non sarà più visibile agli utenti.</p>
              
              <input type="hidden" name="reviewId" id="modalReviewId">
            </div>
            <div class="modal-footer border-0 p-4 pt-0 justify-content-center">
              <button type="button" class="btn btn-light fw-bold px-4" data-bs-dismiss="modal">ANNULLA</button>
              <button type="submit" class="btn btn-danger fw-bold px-4 shadow-sm">ELIMINA ORA</button>
            </div>
          </form>
        </div>
      </div>
    </div>
{/block}

{block name="script"}
  <script src="{$js_path}/reviewsManagement.js"></script>
{/block}