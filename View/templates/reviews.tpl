{extends file="main.tpl"}

{block name="title"}Volunturing - Dicono di Noi{/block}

{block name="head"}
    <link rel="stylesheet" href="{$css_path}/reviews.css"/>
{/block}

{block name="body"}
    <header class="reviews-hero text-center">
      <div class="container">
        <h1 class="display-4 fw-bold mb-3">Dicono di Noi</h1>
        <p class="lead mb-4">Scopri le storie e le esperienze dei volontari che rendono speciale Volontorino.</p>
        <div class="stats-badge">
          <div class="me-3">
            <span class="h3 fw-bold mb-0">{$rating}</span>
            <span class="text-muted">/5</span>
          </div>
          <div class="star-rating">
            {for $i = 1 to $rating}
            <i class="bi bi-star-fill"></i>{/for}
            {for $i = ($rating + 1) to 5}
            <i class="bi bi-star"></i>{/for}
          </div>
          <div class="ms-3 text-muted small fw-bold">Basato su {$reviewsNumber} recensioni</div>
        </div>
      </div>
    </header>

    <main class="container mb-5 flex-grow-1">
      <div class="row g-4">
        
        {foreach $reviews as $review}
        <div class="col-md-6 col-lg-4">
          <div class="card h-100 shadow-sm review-card p-4 position-relative">
            <i class="bi bi-quote quote-icon"></i>
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
            <p class="text-secondary small flex-grow-1">
              {$review->getText()}
            </p>
            <div class="mt-3 review-date">
              <i class="bi bi-clock me-1"></i> Pubblicata il {$review->getDate()->format('d-m-Y')}
            </div>
          </div>
        </div>
        {/foreach}

      </div>
    </main>
{/block}